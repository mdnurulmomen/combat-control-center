<?php

namespace App\Http\Controllers\Web;

use App\Models\News;
use App\Models\Image;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as ImageIntervention;

class MediaController extends Controller
{
    public function submitCreatedImage(Request $request)
    {
        $request->validate([
            'preview'=>'required',
            'order'=>'nullable|unique:images,order'
        ]);

        $newImage = new Image();

        $newImage->name = $request->name;
        $newImage->order = $request->order;

        if($request->has('preview')){
            $originImageFile = $request->file('preview');
            $imageObject = ImageIntervention::make($originImageFile);
            $imageObject->resize(512, 512)->save('assets/front/images/ads/'.$originImageFile->hashname());

            $newImage->preview = 'assets/front/images/ads/'.$originImageFile->hashname();
        }

        $newImage->save();

        return redirect()->back()->with('success', 'New Image is Created');
    }

    public function showAllImages()
    {
        $images = Image::paginate(6);
        return view('admin.other_layouts.media.all_images', compact('images'));
    }

    public function showImageEditForm(Request$request, $imageId)
    {
        $imageToUpdate = Image::findOrFail($imageId);
        return view('admin.other_layouts.media.edit_image', compact('imageToUpdate'));
    }

    public function submitEditedImage(Request $request, $imageId)
    {
        $imageToUpdate = Image::findOrFail($imageId);

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

        return redirect()->back()->with('success', 'Image is Updated');
    }

    public function imageDeleteMethod($imageId)
    {
        $imageToDelete = Image::findOrFail($imageId);
        $imageToDelete->delete();

        return redirect()->back()->with('success', 'Image is Deleted');
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
