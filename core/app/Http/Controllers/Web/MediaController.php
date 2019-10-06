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
        $request->validate([
            'name' => 'required|unique:campaigns,name'
        ]);

        $newCampaign = new Campaign();

        $newCampaign->name = $request->name;
        $newCampaign->start_date = $request->start_date;
        $newCampaign->close_date = $request->close_date;
        $newCampaign->status = $request->status;
        $newCampaign->save();

        $newCampaign->updateDefaultCampaign();

        foreach (CampaignImageCategory::all() as $campaignImageCategory) {

            $this->saveCampaignImages($request, $newCampaign, $campaignImageCategory);

        }

        return redirect()->back()->with('success', 'New Campaign is Created');
    }

    public function saveCampaignImages(Request $request, Campaign $newCampaign, CampaignImageCategory $campaignImageCategory)
    {
        $parameterName = str_replace(' ', '_', $campaignImageCategory->name);
        $campaignName = str_replace(' ', '_', $newCampaign->name);

        $directory = "assets/front/campaign/images/$parameterName/";

        if (!file_exists($directory)) {

            mkdir($directory, 666, true);
        }

        if($request->hasFile($parameterName)){

            foreach ($request->file($parameterName) as $key => $originImageFile) {
                        
                $imageObject = ImageIntervention::make($originImageFile)->resize($campaignImageCategory->width_size, $campaignImageCategory->height_size);
                $imageObject->save($directory.$campaignName."_".$parameterName."_".($key+1).'.jpg');
                
                $newCampaignImage = new CampaignImage();
                $newCampaignImage->image_path = $directory.$campaignName."_".$parameterName."_".($key+1).'.jpg';
                $newCampaignImage->campaign_image_category_id = $campaignImageCategory->id;
                $newCampaignImage->campaign_id = $newCampaign->id;
                $newCampaignImage->save();
            }
        }
    }

    public function showAllCampaigns(Request $request)
    {
        $campaigns = Campaign::all();

        if ($request->ajax()) {
            return $campaigns;
        }

        return view('admin.other_layouts.media.all_campaigns_enabled')->withCampaigns($campaigns);
    }

    public function showAllDisabledCampaigns()
    {
        $campaigns = Campaign::onlyTrashed()->paginate(15);
        return view('admin.other_layouts.media.all_campaigns_disabled')->withCampaigns($campaigns);
    }

    public function showCampaignCategoryImages(Request $request)
    {
        if ($request->ajax()) {
            
            $campaignId = $request->campaignId;
            $categoryId = $request->categoryId;

            // return "CampaignId : $campaignId, CategoryId : $categoryId";
            return CampaignImage::where('campaign_id', $campaignId)->where('campaign_image_category_id', $categoryId)->get();
        }

        return 'Not Ajax Call';
    }

    public function submitEditedCampaign(CampaignRequest $request, $campaignId)
    {
        $campaignToUpdate = Campaign::findOrFail($campaignId);
 
        $request->validate([
            'name' => 'required|unique:campaigns,name,'.$campaignToUpdate->id,
        ]);

        $campaignToUpdate->name = $request->name;
        $campaignToUpdate->start_date = $request->start_date;
        $campaignToUpdate->close_date = $request->close_date;
        $campaignToUpdate->status = $request->status;
        $campaignToUpdate->save();

        $campaignToUpdate->updateDefaultCampaign();
        $campaignToUpdate->campaignImages()->delete();

        foreach (CampaignImageCategory::all() as $campaignImageCategory) {

            $this->saveCampaignImages($request, $campaignToUpdate, $campaignImageCategory);
            $this->saveUploadedCampaignImages($request, $campaignToUpdate, $campaignImageCategory);

        }

        return redirect()->back()->with('success', 'New Campaign is Updated');
    }

    public function saveUploadedCampaignImages(Request $request, Campaign $campaignToUpdate, CampaignImageCategory $campaignImageCategory)
    {
        $parameterName = 'uploaded_'.str_replace(' ', '_', $campaignImageCategory->name);

        foreach ($request->$parameterName as $key => $imagePath) {
            
            if ($imagePath) {
                $newCampaignImage = new CampaignImage();
                $newCampaignImage->image_path = $imagePath;
                $newCampaignImage->campaign_image_category_id = $campaignImageCategory->id;
                $newCampaignImage->campaign_id = $campaignToUpdate->id;
                $newCampaignImage->save();
            }
        }
    }

    public function campaignDeleteMethod($campaignId)
    {
        // dd(Campaign::findOrFail($campaignId)->update(['status' => false]));
        $campaignToDelete = Campaign::findOrFail($campaignId);
        $campaignToDelete->update(['status' => false]);
        $campaignToDelete->delete();

        return redirect()->back()->with('success', 'Campaign is Deleted');
    }

    public function campaignRestoreMethod($campaignId)
    {
        $campaignToRestore = Campaign::withTrashed()->findOrFail($campaignId);
        $campaignToRestore->restore();

        return redirect()->back()->with('success', 'Campaign is Restored');
    }

    public function submitCreatedCampaignImageCategory(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'width'=>'required',
            'height'=>'required',
        ]);

        $newImageCategory = CampaignImageCategory::create([
                                'name' => $request->name,
                                'width_size' => $request->width,
                                'height_size' => $request->height,
                            ]);;

        return redirect()->back()->with('success', 'New Category has been Created');

    }

    public function showAllEnabledCampaignImageCategoies()
    {
        $campaignImageCategories = CampaignImageCategory::paginate(15);
        return view('admin.other_layouts.media.all_campaign_image_categories_enabled')->withCampaignImageCategories($campaignImageCategories);
    }

    public function showAllDisabledCampaignImageCategoies()
    {
        $campaignImageCagtegories = CampaignImageCategory::onlyTrashed()->paginate(10);
        return view('admin.other_layouts.media.all_campaign_image_categories_disabled')->withCampaignImageCategories($campaignImageCagtegories);
    }

    public function submitEditedCampaignImageCategory(Request $request, $categoryId)
    {
        $request->validate([
            'name'=>'required',
            'width'=>'required',
            'height'=>'required',
        ]);

        $categoryToUpdate = CampaignImageCategory::find($categoryId);

        $updateImageCategory = $categoryToUpdate->update([
                                'name' => $request->name,
                                'width_size' => $request->width,
                                'height_size' => $request->height,
                            ]);;

        return redirect()->back()->with('success', 'New Category has been Updated');
    }
    
    public function campaignImageCategoryDeleteMethod($categoryId)
    {
        CampaignImageCategory::findOrFail($categoryId)->delete();
        return redirect()->back()->with('success', 'Category has been deleted');
    }

    public function campaignImageCategoryRestoreMethod($campaignId)
    {
        CampaignImageCategory::withTrashed()->find($campaignId)->restore();
        return redirect()->back()->with('success', 'Category has been restored');
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
