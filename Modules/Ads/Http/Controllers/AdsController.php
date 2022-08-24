<?php

namespace Modules\Ads\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Ads\Entities\Ad;
use Modules\Ads\Entities\AdLocation;
use Validator;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Aws\S3\Exception\S3Exception as S3;
use Modules\Gallery\Entities\Image as galleryImage;

use Modules\Ads\Entities\SideAd;
use Modules\Ads\Entities\CenterAd;
use Modules\Post\Entities\Section;


class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ads = Ad::with('adImage')->paginate(10);
        return view('ads::index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $countImage     = galleryImage::count();
        return view('ads::ads_create', compact('countImage'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'ad_name'   => 'required|min:2|max:100',
            'ad_type'   => 'required',
            'ad_size'   => 'required'
        ])->validate();

        $ad             = new Ad();
        $ad->ad_name    = $request->ad_name;
        $ad->ad_size    = $request->ad_size;
        $ad->ad_type    = $request->ad_type;
        $ad->ad_url     = $request->ad_url;

        if ($request->ad_type  == 'code') :
            Validator::make($request->all(), ['ad_code' => 'required'])->validate();
            $ad->ad_code = $request->ad_code;
        elseif ($request->ad_type   == 'image') :
            Validator::make($request->all(), ['ad_image_id' => 'required'])->validate();
            $ad->ad_image_id = $request->ad_image_id;
        elseif ($request->ad_type   == 'text') :
            Validator::make($request->all(), ['ad_text' => 'required'])->validate();
            $ad->ad_text = e($request->ad_text);
        endif;

        $ad->save();

        Cache::forget('adLocations');
        Cache::forget('categorySections');
        Cache::forget('categorySectionsAuth');
        Cache::forget('footerWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('sideWidgets');
        Cache::forget('primary_menu');

        return redirect()->back()->with('success', __('successfully_added'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $ad     = Ad::where('id', $id)->with('adImage')->first();
        $countImage     = galleryImage::count();
        return view('ads::ads_edit', compact('ad', 'countImage'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (strtolower(\Config::get('app.demo_mode')) == 'yes') :
            return redirect()->back()->with('error', 'You are not allowed to add/modify in demo mode.');
        endif;
        Validator::make($request->all(), [
            'ad_name' => 'required|min:2|max:100',
            'ad_type' => 'required',
            'ad_size' => 'required'
        ])->validate();

        $ad             = Ad::find($id);
        $ad->ad_name    = $request->ad_name;
        $ad->ad_size    = $request->ad_size;
        $ad->ad_type    = $request->ad_type;
        $ad->ad_url     = $request->ad_url;

        if ($request->ad_type == 'code') :
            Validator::make($request->all(), ['ad_code' => 'required'])->validate();
            $ad->ad_code = $request->ad_code;
        elseif ($request->ad_type == 'image') :
            Validator::make($request->all(), ['ad_image_id' => 'required'])->validate();
            $ad->ad_image_id = $request->ad_image_id;
        elseif ($request->ad_type == 'text') :
            Validator::make($request->all(), ['ad_text' => 'required'])->validate();
            $ad->ad_text = e($request->ad_text);
        endif;

        $ad->save();

        Cache::Flush();

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function assignAds()
    {

        $adLocations = AdLocation::with('ad')->get();
        // return $adLocations;
        $ads = Ad::with('adImage')->get();
        return view('ads::ad_location', compact('adLocations', 'ads'));
    }

    public function updateLocation(Request $request)
    {
        // return $request;
        $total_item     = count($request->ad_location_id);
        for ($i = 0; $i < $total_item; $i++) {
            AdLocation::where('id', $request->ad_location_id[$i])->update(['ad_id' => $request->ad_id[$i], 'status' => $request->status[$i]]);
        }

        Cache::forget('adLocations');
        return redirect()->back()->with('success', __('successfully_updated'));
    }



    // add by majid molaei for side ads

    public function index_side()
    {
        $ads = SideAd::paginate(10);
        return view('ads::side.index', compact('ads'));
    }

    public function create_side()
    {
        return view('ads::side.ads_create');
    }

    public function store_side(Request $request)
    {
        Validator::make($request->all(), [
            'url'   => 'required',
            'rank'   => 'required',
            'image'   => 'required',
        ])->validate();

        $ad             = new SideAd();
        $ad->url    = $request->url;
        $ad->rank    = $request->rank;
        $ad->start_date    = null;
        $ad->end_date    = null;
        $ad->set_date    =  0;
        if (isset($request->set_date)) {
            $ad->start_date    = jalali_to_miladi($request->start_date);
            $ad->end_date    = jalali_to_miladi($request->end_date);
            $ad->set_date    =  1;
        }
        $image = $request->image;
        $ext = $image->extension();
        $name = 'side_ad-' . rand(100000, 999999) . '.' . $ext;
        $image->move('public/images/', $name);
        $ad->path    = 'public/images/' . $name;
        $ad->save();

        return redirect()->back()->with('success', __('successfully_added'));
    }

    public function edit_side($id)
    {
        $ad = SideAd::where('id', $id)->first();
        return view('ads::side/ads_edit', compact('ad'));
    }

    public function update_side(Request $request, $id)
    {

        Validator::make($request->all(), [
            'url'   => 'required',
            'rank'   => 'required',
        ])->validate();


        $ad             = SideAd::find($id);

        $ad->url    = $request->url;
        $ad->rank    = $request->rank;
        $ad->start_date    = null;
        $ad->end_date    = null;
        $ad->set_date    =  0;
        if (isset($request->set_date)) {
            $ad->start_date    = jalali_to_miladi($request->start_date);
            $ad->end_date    = jalali_to_miladi($request->end_date);
            $ad->set_date    =  1;
        }

        $image = $request->image;
        if ($image) {
            $ext = $image->extension();
            $name = 'side_ad-' . rand(100000, 999999) . '.' . $ext;
            $image->move('public/images/', $name);
            if ($ad->path) {
                @unlink($ad->path);
            }
            $ad->path    = 'public/images/' . $name;
        }

        $ad->save();

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    // add by majid molaei for center ads

    public function index_center()
    {
        $ads = CenterAd::paginate(10);
        return view('ads::center.index', compact('ads'));
    }

    public function create_center()
    {
        $sections = Section::offset(2)->limit(9999)->get();
        return view('ads::center.ads_create', compact('sections'));
    }

    public function store_center(Request $request)
    {
        // dd(isset($request->top));
        Validator::make($request->all(), [
            'url'   => 'required|string',
            'image'   => 'required|mimes:jpg,png,gif|max:1500'
        ])->validate();

        $ad = new CenterAd();
        $ad->url = $request->url;
        $ad->rank = $request->rank;
        $ad->section_id = $request->section_id;
        if (isset($request->top)) {
            $ad->top = 1;
        } else {
            $ad->top = 0;
        }
        $image = $request->image;
        $ext = $image->extension();
        $name = 'center_ad-' . rand(100000, 999999) . '.' . $ext;
        $image->move('public/images/', $name);
        $ad->path = 'public/images/' . $name;
        $ad->save();

        return redirect('ads/center')->with('success', __('successfully_added'));
    }

    public function edit_center($id)
    {
        $ad     = CenterAd::where('id', $id)->first();
        $sections = Section::offset(2)->limit(9999)->get();
        return view('ads::center/ads_edit', compact('ad', 'sections'));
    }

    public function update_center(Request $request, $id)
    {

        Validator::make($request->all(), [
            'url'   => 'required',
        ])->validate();

        $ad = CenterAd::find($id);

        $ad->url = $request->url;
        $ad->rank = $request->rank;
        $ad->section_id = $request->section_id;
        if (isset($request->top)) {
            $ad->top = 1;
        } else {
            $ad->top = 0;
        }
        $image = $request->image;
        if ($image) {
            $ext = $image->extension();
            $name = 'center_ad-' . rand(100000, 999999) . '.' . $ext;
            $image->move('public/images/', $name);
            if ($ad->path) {
                @unlink($ad->path);
            }
            $ad->path    = 'public/images/' . $name;
        }

        $ad->save();

        return redirect()->back()->with('success', __('successfully_updated'));
    }
}
