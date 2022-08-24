<?php

namespace Modules\Gallery\Http\Controllers;

use Aws\S3\Exception\S3Exception as S3;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\Entities\Album;
use Modules\Gallery\Entities\GalleryImage;
use Image;
use File;
use Modules\Language\Entities\Language;
use Validator;
use LaravelLocalization;
use Modules\Post\Entities\Section;
use Session;

class AlbumController extends Controller
{
    public function index()
    {
        $galleryImages  = GalleryImage::where('is_cover', 1)->orderBy('id', 'desc')->paginate(15);
        return view('gallery::gallery', compact('galleryImages'));
    }

    public function addImage()
    {
        return view('gallery::add_gallery_image');
    }

    public function saveImageGallery(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'cover' => 'required',
            'files' => 'required',
        ])->validate();

        if ($request->hasFile('files')) :
            try {

                // save cover image
                if ($request->hasFile('cover')) {
                    $cover = $request->file('cover');
                    $coverType = $cover->getClientOriginalExtension();
                    $cover_name = date('YmdHis') . "_galleryImage_cover_" . rand(1, 50) . '.' . $coverType;
                    $cover->move(base_path('public/images/'), $cover_name);
                    $coverImage = new GalleryImage();
                    $coverImage->original_image = 'images/' . $cover_name;
                    $coverImage->title = $request->title;
                    $coverImage->is_cover = 1;
                    $coverImage->gallery_image_id = Null;
                    $coverImage->disk = settingHelper('default_storage');
                    $coverImage->save();
                }



                //save other images
                $images = $request->file('files');

                foreach ($images as $requestImage) :

                    $fileType = $requestImage->getClientOriginalExtension();
                    $originalImageName = date('YmdHis') . "_galleryImage_" . rand(1, 50) . '.' . $fileType;
                    $directory = 'public/images/';
                    $originalImageUrl = $directory . $originalImageName;
                    Image::make($requestImage)->save($originalImageUrl);
                    $galleryImage = new GalleryImage();
                    $galleryImage->original_image = str_replace("public/", "", $originalImageUrl);
                    $galleryImage->is_cover = 0;
                    $galleryImage->gallery_image_id = $coverImage->id;
                    $galleryImage->disk = settingHelper('default_storage');
                    $galleryImage->save();

                endforeach;

                return redirect()->back()->with('success', __('successfully_added'));
            } catch (\Exception $e) {
        dd($e);

                Log::error($e->getMessage());
                return null;
            }
        else :
            return redirect()->back()->with('error', __('something_went_wrong'));
        endif;
    }

    public function editImage($id)
    {
        $image = GalleryImage::findOrfail($id);

        return view('gallery::edit_gallery_image', compact('image'));
    }

    public function updateImage(Request $request)
    {
        Validator::make($request->all(), [
            'title'  => 'required',
            'cover'  => 'mimes:jpg,JPG,JPEG,jpeg,png|max:5120',
            'image'     => 'mimes:jpg,JPG,JPEG,jpeg,png|max:5120',
        ])->validate();

        $image = GalleryImage::findOrfail($request->image_id);
        $image->title = $request->title;
        $image->save();


        if ($request->hasFile('cover')) {

            @unlink(basePath("public/$image->original_image"));

            $cover = $request->file('cover');
            $coverType = $cover->getClientOriginalExtension();
            $cover_name = date('YmdHis') . "_galleryImage_cover_" . rand(1, 50) . '.' . $coverType;
            $cover->move(base_path('public/images/'), $cover_name);
            $image->original_image = 'images/' . $cover_name;
            $image->is_cover = 1;
            $image->gallery_image_id = Null;
            $image->disk = settingHelper('default_storage');
            $image->save();
        }

        if ($request->hasFile('files')) {

            $images = $request->file('files');

            foreach ($images as $item) :

                $imageType = $item->getClientOriginalExtension();
                $imageName = date('YmdHis') . "_galleryImage_" . rand(1, 50) . '.' . $imageType;
                $item->move(base_path('public/images/'), $imageName);
                $newImage = new GalleryImage();
                $newImage->original_image = 'images/' . $imageName;
                $newImage->is_cover = 0;
                $newImage->gallery_image_id = $image->id;
                $newImage->disk = settingHelper('default_storage');
                $newImage->save();

            endforeach;
        }

        if ($request->ids) {
            $ids = explode(',', substr($request->ids, 0, -1));
            foreach ($ids as $id) {
                $image = GalleryImage::find($id);
                @unlink("public/$image->original_image");
                $image->delete();
            }
        }

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function filterImage(Request $request)
    {
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $search_query       = $request;

        $albums         = Album::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        //        dd($albums);

        $galleryImages = GalleryImage::where('album_id', 'like', '%' . $request->album_id . '%')
            ->where('tab', 'like', '%' . $request->tab . '%')
            ->where('title', 'like', '%' . $request->search_key . '%')
            ->orderBy('id', 'desc')
            ->paginate('15');
        return view('gallery::image_search', compact('albums', 'activeLang', 'search_query', 'galleryImages'));
    }

    public function deleteImage()
    {
        $id = request()->id;
        $image = GalleryImage::find($id);
        $count = $image->gallery_images->count();
        if ($count) {
            Session::flash('error', 'ابتدا عکس های آلبوم را حذف نمائید');
            return 'ok';
        }
        @unlink("public/$image->original_image");
        $image->delete();
        session()->flash('success', 'آلبوم مورد نظر با موفقیت حذف گردید');
        return 'ok';
    }
}
