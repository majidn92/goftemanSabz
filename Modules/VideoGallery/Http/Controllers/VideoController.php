<?php

namespace Modules\VideoGallery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;
use Modules\Language\Entities\Language;
use Modules\VideoGallery\Entities\VideoGallery;
use Modules\VideoGallery\Entities\VideoCategory;
use Modules\Post\Entities\Section;




class VideoController extends Controller
{
    public function videos()
    {
        $videos  = VideoGallery::orderBy('id', 'desc')->paginate(15);
        $categories = VideoCategory::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view('videogallery::videos', compact('activeLang', 'videos', 'categories'));
    }

    public function createVideo()
    {
        $videos  = VideoGallery::orderBy('id', 'desc')->paginate(15);
        $categories = VideoCategory::all();
        $sections = Section::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view('videogallery::add_video', compact('activeLang', 'videos', 'categories', 'sections'));
    }

    public function storeVideo(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
            'cover' => 'required',
            'video' => 'required',
            'rank' => 'required',
        ];
        $messages = [
            'category_id.required' => 'انتخاب گروه الزامی است',
            'section_id.required' => 'انتخاب بخش یا صنعت الزامی است',
        ];
        $request->validate($rules, $messages);

        // upload cover image
        $cover = $request->cover;
        $ext = $cover->extension();
        $cover_name = rand(100000, 999999) . '.' .  $ext;
        $cover->move(public_path('videos/videogallery/cover/'), $cover_name);

        // upload video
        $video = $request->video;
        $ext = $video->extension();
        $video_name = rand(100000, 999999) . '.' .  $ext;
        $video->move(public_path('videos/videogallery/'), $video_name);

        $video = new VideoGallery;

        $video->video_category_id = $request->category_id;
        $video->section_id = $request->section_id;
        $video->title = $request->title;
        $video->rank = $request->rank;
        $video->cover = 'videos/videogallery/cover/' . $cover_name;
        $video->path = 'videos/videogallery/' . $video_name;
        if (isset($request->featured)) {
            $video->featured = 1;
        } else {
            $video->featured = 0;
        }

        $video->save();
        return redirect(route('video.videos'))->with('success', 'ویدئو موردنظر با موفقیت اضافه شد');
    }

    public function editVideo($id)
    {
        $video = VideoGallery::findOrfail($id);
        $categories = VideoCategory::all();
        $sections = Section::all();
        $activeLang = Language::where('status', 'active')->orderBy('name', 'ASC')->get();

        return view('videogallery::edit_video', compact('video', 'activeLang', 'categories', 'sections'));
    }

    public function updateVideo(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            'section_id' => 'required',
            'title' => 'required',
            'rank' => 'required',
        ];
        $messages = [
            'category_id.required' => 'انتخاب گروه الزامی است',
            'section_id.required' => 'انتخاب بخش یا صنعت الزامی است',
        ];
        $request->validate($rules, $messages);

        $video = VideoGallery::findOrfail($request->video_id);

        // upload cover image
        if ($cover = $request->cover) {
            $ext = $cover->extension();
            $cover_name = rand(100000, 999999) . '.' .  $ext;
            $cover->move(public_path('videos/videogallery/cover/'), $cover_name);
            @unlink(public_path($video->cover));
            $video->cover = 'videos/videogallery/cover/' . $cover_name;
        }

        // upload video
        if ($video_file = $request->video) {
            $ext = $video_file->extension();
            $video_name = rand(100000, 999999) . '.' .  $ext;
            $video_file->move(public_path('videos/videogallery/'), $video_name);
            @unlink(public_path($video->path));
            $video->path = 'videos/videogallery/' . $video_name;
        }

        $video->video_category_id = $request->category_id;
        $video->section_id = $request->section_id;
        $video->title = $request->title;
        $video->rank = $request->rank;

        if (isset($request->featured)) {
            $video->featured = 1;
        } else {
            $video->featured = 0;
        }

        $video->save();
        return back()->with('success', 'ویدئو موردنظر با موفقیت ویرایش شد');
    }

    public function deleteVideo(Request $request)
    {
        $video = VideoGallery::find($request->video_id);
        @unlink('public/' . $video->path);
        @unlink('public/' . $video->cover);
        $video->delete();
        $data['status']     = "success";
        $data['message']    =  __('successfully_deleted');
        echo json_encode($data);
    }

    public function fetchVideo()
    {
    }
}
