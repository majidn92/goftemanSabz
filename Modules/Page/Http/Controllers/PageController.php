<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Language\Entities\Language;
use Modules\Page\Entities\Page;
use Validator;
use Modules\Gallery\Entities\Image as galleryImage;

class PageController extends Controller
{
    public function index()
    {
        $pages =Page::orderBy('id','ASC')->paginate(10);

        return view('page::pages',['pages'=> $pages]);
    }

    public function create()
    {
        $activeLang = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();
        return view('page::add_page',compact('activeLang', 'countImage'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|unique:pages|min:2|max:40',

        ])->validate();

        $page =new Page();
        $page->title =$request->title;

        if($request->slug != null) :
            Validator::make($request->all(), [
            'slug' => 'required|min:2|unique:pages|max:30|regex:/^\S*$/u', ])->validate();
            $page->slug =$request->slug;
        else :
            $page->slug = $this->make_slug($request->title);
        endif;

        $page->description =$request->description;

        $page->template =$request->template;
        $page->visibility =$request->visibility;
        $page->language =$request->language;
        $page->show_for_register =$request->show_for_register;
        $page->show_title =$request->show_title;
        $page->show_breadcrumb =$request->show_breadcrumb;
        $page->location = $request->location;
        $page->meta_title =$request->meta_title;
        $page->meta_description =$request->meta_description;
        $page->meta_keywords =$request->meta_keywords;
        $page->image_id=$request->image_id;
        $page->page_type=$request->page_type;
        $page->save();

        return redirect()->back()->with('success', __('successfully_added'));
    }

    public function edit($id)
    {
        $page=Page::find($id);
        $activeLang = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();

        return view('page::edit', compact('page', 'activeLang', 'countImage'));
    }

    public function update(Request $request, $id)
    {
        if (strtolower(\Config::get('app.demo_mode')) == 'yes'):
            return redirect()->back()->with('error', __('You are not allowed to add/modify in demo mode.'));
        endif;
        Validator::make($request->all(), [
            'title' => 'required|min:2|max:40|unique:pages,title,' . $id,

        ])->validate();

        $page = Page::find($id);
        $page->title = $request->title;
        $page->language = $request->language;
        if ($request->slug != null) :
            Validator::make($request->all(), [
                'slug' => 'required|min:2|max:30|regex:/^\S*$/u|unique:pages,slug,' . $id,
            ])->validate();
            $page->slug = $request->slug;
        else :
            $page->slug = $this->make_slug($request->title);
        endif;

        $page->description = $request->description;
        $page->template = $request->template;
        $page->visibility = $request->visibility;
        $page->show_for_register = $request->show_for_register;
        $page->show_title = $request->show_title;
        $page->show_breadcrumb = $request->show_breadcrumb;
        $page->location = $request->location;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = $request->meta_keywords;
        $page->image_id=$request->image_id;
        $page->page_type=$request->page_type;
        $page->save();

        Cache::forget('primary_menu');
        Cache::forget('menuDetails');

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    private function make_slug($string, $delimiter = '-') {

        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);

        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
        $result = mb_strtolower($string);

        if ($result):
            return $result;
        else:
            return $string;
        endif;
    }
}
