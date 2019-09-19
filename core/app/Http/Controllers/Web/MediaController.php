<?php

namespace App\Http\Controllers\Web;

use App\Models\News;
use App\Models\Message;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\CampaignImage;
use App\Http\Controllers\Controller;
use App\Models\CampaignImageCategory;
use App\Http\Requests\CampaignRequest;
use Intervention\Image\Facades\Image as ImageIntervention;

class MediaController extends Controller
{
    public function submitCreatedCampaign(CampaignRequest $request)
    {   
        $newCampaign = new Campaign();

        $newCampaign->name = $request->name;
        $newCampaign->start_date = $request->start_date;
        $newCampaign->close_date = $request->close_date;
        $newCampaign->status = $request->status;

        $newCampaign->save();

        foreach (CampaignImageCategory::all() as $campaignImageCategory) {

            $this->saveCampaignImages($request, $newCampaign, $campaignImageCategory);

        }

        return redirect()->back()->with('success', 'New Campaign is Created');
    }

    public function saveCampaignImages(Request $request, Campaign $newCampaign, CampaignImageCategory $campaignImageCategory)
    {
        $parameterName = str_replace(' ', '_', $campaignImageCategory->name);

        $directory = "assets/front/campaign/images/$campaignImageCategory->name/";

        if (!file_exists($directory)) {

            mkdir($directory, 666, true);
        }

        if($request->hasFile($parameterName)){

            foreach ($request->file($parameterName) as $key => $originImageFile) {
                        
                $imageObject = ImageIntervention::make($originImageFile);
                $imageObject->save($directory.$newCampaign->name."_".$parameterName."_".($key+1).'.jpg');
                
                $newCampaignImage = new CampaignImage();
                $newCampaignImage->image_path = $directory.$newCampaign->name."_".$parameterName."_".($key+1).'.jpg';
                $newCampaignImage->campaign_image_category_id = $campaignImageCategory->id;
                $newCampaignImage->campaign_id = $newCampaign->id;
                $newCampaignImage->save();
            }
        }
    }

    public function showAllCampaigns()
    {
        $campaigns = Campaign::paginate(6);
        return view('admin.other_layouts.media.all_campaigns')->withCampaigns($campaigns);
    }

    public function showCampaignEditForm(Request$request, $campaignId)
    {
        $campaignToUpdate = Campaign::findOrFail($campaignId);
        return view('admin.other_layouts.media.edit_image', compact('campaignToUpdate'));
    }

    public function submitEditedCampaign(Request $request, $campaignId)
    {
        $imageToUpdate = Campaign::findOrFail($imageId);

        $request->validate([
            'order'=>'nullable|unique:images,order,'.$imageToUpdate->id
        ]);

        $imageToUpdate->name = $request->name;
        $imageToUpdate->order = $request->order;

        if($request->has('preview')){
            $originImageFile = $request->file('preview');
            $imageObject = ImageIntervention::make($originImageFile);
            $imageObject->resize(512, 512)->save('assets/front/images/ads/'.$originImageFile->hashname());

            $imageToUpdate->preview = 'assets/front/images/ads/'.$originImageFile->hashname();
        }

        $imageToUpdate->save();

        return redirect()->back()->with('success', 'Campaign is Updated');
    }

    public function campaignDeleteMethod($imageId)
    {
        $imageToDelete = Campaign::findOrFail($imageId);
        $imageToDelete->delete();

        return redirect()->back()->with('success', 'Campaign is Deleted');
    }

    public function submitCreatedNews(Request $request)
    {
        $request->validate([
            'body'=>'required'
        ]);

        $newNews = new News();

        $newNews->body = $request->body;

        $newNews->save();

        return redirect()->back()->with('success', 'New News is Created');
    }

    public function showAllNews()
    {
        $allNews = News::paginate(6);
        return view('admin.other_layouts.media.all_news', compact('allNews'));
    }

    public function submitEditedNews(Request $request, $newsId)
    {
        $request->validate([
            'body'=>'required'
        ]);

        $newsToUpdate = News::findOrFail($newsId);

        $newsToUpdate->body = $request->body;

        $newsToUpdate->save();

        return redirect()->back()->with('success', 'News is Updated');
    }

    public function newsDeleteMethod($newsId)
    {
        $newsToDelete = News::findOrFail($newsId);
        $newsToDelete->delete();

        return redirect()->back()->with('success', 'News is Deleted');
    }

    public function submitCreatedMessage(Request $request)
    {
        $request->validate([
            'body'=>'required'
        ]);

        $newMessage = new Message();

        $newMessage->title = $request->title;
        $newMessage->body = $request->body;

        $newMessage->save();

        return redirect()->back()->with('success', 'New Message is Created');
    }

    public function showAllMessages()
    {
        $allMessages = Message::paginate(6);
        return view('admin.other_layouts.media.all_messages', compact('allMessages'));
    }

    public function submitEditedMessage(Request $request, $messageId)
    {
        $request->validate([
            'body'=>'required'
        ]);

        $messageToUpdate = Message::findOrFail($messageId);

        $messageToUpdate->title = $request->title;
        $messageToUpdate->body = $request->body;

        $messageToUpdate->save();

        return redirect()->back()->with('success', 'Message is Updated');
    }

    public function messageDeleteMethod($messageId)
    {
        $messageToUpdate = Message::findOrFail($messageId);
        $messageToUpdate->delete();

        return redirect()->back()->with('success', 'Message is Deleted');
    }
}
