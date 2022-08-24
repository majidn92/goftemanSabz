<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Modules\Ads\Entities\AdLocation;
use Modules\Appearance\Entities\ThemeSection;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\Section;
use LaravelLocalization;
use App\VisitorTracker;
use Illuminate\Support\Facades\Input;
use Sentinel;
use DB;
use Modules\Post\Entities\Category;
use File;
use Modules\Ads\Entities\SideAd;
use Modules\Ads\Entities\CenterAd;
use Illuminate\Http\Request;
use Modules\Gallery\Entities\GalleryImage;
use Modules\Post\Entities\State;


class HomeController extends Controller
{
    public function home()
    {
        $language = LaravelLocalization::setLocale() ?? settingHelper('default_language');

        if (Sentinel::check() && !View::exists('site.website.' . $language . '.logged.widgets')) :

            $this->widgetsSection($language);

        endif;

        //تمام اخبار
        $posts = Post::where('status', 1)->where('visibility', 1)->get();
        // اسلایدر
        $data['slider_posts'] = $posts->where('slider', 1)->sortBy('slider_order')->sortByDesc('created_at')->take(3);
        // ویژه
        $data['featured_posts'] = $posts->where('featured', 1)->sortBy('featured_order')->sortByDesc('created_at')->take(4);
        //آخرین اخبار
        $data['last_posts'] = $posts->sortByDesc('created_at')->take(9);
        //اخبار پربازدید
        $our = $posts->where('populare', 1)->sortByDesc('created_at')->sortBy('populare_order')->take(4);
        $other = $posts->where('populare', 0)->sortByDesc('created_at')->sortByDesc('total_hit')->take(5);
        $data['populare_posts'] = $our->merge($other)->shuffle();
        // اتاق گفتگو
        $data['chat_room_posts'] = $posts->where('chat_room', 1)->sortByDesc('created_at')->sortBy('chat_room_order')->take(7)->values();
        // اخبار استان ها
        $data['state'] = $state =  State::find(1);
        $data['state_posts'] = $posts->where('state_id', $state->id)->sortByDesc('created_at')->take(4);
        // سایر اخبار
        $data['other_posts'] = $posts->where('rss', 1)->sortByDesc('created_at')->take(9);
        //دیدگاه ها
        $data['opinions'] = $posts->where('opinion', 1)->sortByDesc('created_at')->sortBy('opinion_order')->take(4);
        //ویژه نگار
        $data['persons_of_day'] = $posts->where('person_of_day', 1)->sortByDesc('created_at')->sortBy('person_of_day_order')->take(4);
        //تبلیغات کناری
        $data['side_ads'] = SideAd::orderBy('rank')->take(3)->get();
        //تبلیغات میانی
        $data['center_ads'] = CenterAd::orderBy('rank')->take(6);
        //  آلبوم تصاویر صفحه اصلی
        $data['gallery_images'] = GalleryImage::where('is_cover', 1)->orderby('created_at', 'desc')->get();
        // آلبوم ویدئو و صوت صفحه اصلی
        $data['featured_media'] = Post::where('status', 1)
            ->where('visibility', 1)
            ->where(function ($q) {
                $q->where('post_type', 'audio')
                    ->orwhere('post_type', 'video');
            })
            ->orderBy('created_at', 'desc')
            ->limit(6)->get();
        // بخش ها
        $data['sections'] = Section::where('show', 1)->orderBy('rank', 'asc')->get();
        // کاربران حقوقی
        $data['hoghooghi_profiles'] = DB::table('users')->where('hoghooghi', 1)->where('is_featured', 1)->orderBy('featured_order', 'asc')->get();
        // کاریران حقیقی
        $data['haghighi_profiles'] = DB::table('users')->where('hoghooghi', 0)->where('is_featured', 1)->orderBy('featured_order', 'asc')->get();
        $tracker                 = new VisitorTracker();
        $tracker->page_type      = \App\Enums\VisitorPageType::HomePage;
        $tracker->url            = \Request::url();
        $tracker->source_url     = \url()->previous();
        $tracker->ip             = \Request()->ip();
        $tracker->agent_browser  = UserAgentBrowser(\Request()->header('User-Agent'));

        $tracker->save();

        return view('site.pages.home', $data);
    }

    public function categorySections($language)
    {
        if (Sentinel::check()) :
            $categorySections       = Cache::remember('categorySectionsAuth', $seconds = 1200, function () {
                return ThemeSection::with('ad')
                    ->with(['category'])
                    ->where('is_primary', '<>', 1)->orderBy('order', 'ASC')
                    ->where(function ($query) {
                        $query->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                    })
                    ->get();
            });

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts     = Cache::remember('video_postsAuth', $seconds = 1200, function () {
                return Post::with('category', 'image', 'user')
                    ->where('post_type', 'video')
                    ->where('visibility', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->limit(8)
                    ->get();
            });

            $latest_posts       = Cache::remember('latest_postsAuth', $seconds = 1200, function () {
                return Post::with('category', 'image', 'user')
                    ->where('visibility', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->limit(6)
                    ->get();
            });

            $totalPostCount     = Cache::remember('totalPostCountAuth', $seconds = 1200, function () {
                return Post::where('visibility', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->count();
            });

        else :
            $categorySections       = Cache::remember('categorySections', $seconds = 1200, function () {
                return ThemeSection::with('ad')
                    ->with(['category'])
                    ->where('is_primary', '<>', 1)->orderBy('order', 'ASC')
                    ->where(function ($query) {
                        $query->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                    })
                    ->get();
            });

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts     = Cache::remember('video_posts', $seconds = 1200, function () {
                return Post::with('category', 'image', 'user')
                    ->where('post_type', 'video')
                    ->where('visibility', 1)
                    ->where('status', 1)
                    ->when(Sentinel::check() == false, function ($query) {
                        $query->where('auth_required', 0);
                    })
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->limit(8)
                    ->get();
            });

            $latest_posts       = Cache::remember('latest_posts', $seconds = 1200, function () {
                return Post::with('category', 'image', 'user')
                    ->where('visibility', 1)
                    ->where('status', 1)
                    ->when(Sentinel::check() == false, function ($query) {
                        $query->where('auth_required', 0);
                    })
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->limit(6)
                    ->get();
            });

            $totalPostCount     = Cache::remember('totalPostCount', $seconds = 1200, function () {
                return Post::where('visibility', 1)
                    ->where('status', 1)
                    ->when(Sentinel::check() == false, function ($query) {
                        $query->where('auth_required', 0);
                    })
                    ->orderBy('id', 'desc')
                    ->where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))
                    ->count();
            });

        endif;

        if (fopen(resource_path() . "/views/site/website/category_sections.blade.php", 'w')) :
            $file = resource_path() . "/views/site/website/category_sections.blade.php";
            $view = view('site.partials.home.category_section', compact('categorySections', 'video_posts', 'totalPostCount', 'latest_posts'))->render();
            File::put($file, $view);
        endif;


        //        return view('site.partials.home.category_section',compact('categorySections','video_posts','totalPostCount','latest_posts'))->render();
    }

    public function widgetsSection($language)
    {

        if (Sentinel::Check()) :
            $path = resource_path() . "/views/site/website/" . $language . '/logged';
        else :
            $path = resource_path() . "/views/site/website/" . $language;
        endif;

        File::makeDirectory($path, 0777, true, true);

        $file = $path . '/widgets.blade.php';

        if (fopen($file, 'w')) :

            $view = view('site.partials.right_sidebar_widgets');

            File::put($file, $view);
        endif;
    }

    public function feed_detail_page($id)
    {
        $post = Post::find($id);
        return view('site.pages.feed_detail_page', compact('post'));
    }

    public function load_img_album($album_id)
    {
        $album = \Modules\Gallery\Entities\Album::find($album_id);
        $images = $album->galleryImages;
        $response = "";
        foreach ($images as $image) {
            $response .= '<img src="' . static_asset($image->original_image) . '" class="lightboxed" rel="img-' . $album->id . ' ">';
        }
        echo $response;
    }

    public function media_albums(Request $request)
    {
        $media_posts = Post::where('status', 1)
            ->where('visibility', 1)
            ->where(function ($query) {
                $query->where('post_type', 'video')
                    ->orwhere('post_type', 'audio');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $popular_media_posts = $media_posts->sortByDesc('total_hint')->take(10);
        $last_media_post = $media_posts->first();
        $back_ground_color = Section::find(2)->color;

        return view('site.pages.media_albums', compact('media_posts', 'popular_media_posts', 'last_media_post', 'back_ground_color'));
    }

    public function states()
    {
        $states = \Modules\Post\Entities\State::all();
        return view('site.pages.states', compact('states'));
    }

    public function state($state_id)
    {
        $state = State::find($state_id);
        $posts = $state->posts;
        $section_color = Section::where('style', 'state')->first()->color;
        return view('site.pages.state', compact('posts', 'state', 'section_color'));
    }

    // public function state($state_id)
    // {
    //     $posts = Post::where('visibility', 1)
    //         ->where('status', 1)
    //         ->where('state_id', $state_id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(5);


    //     $section_color = Section::where('style', 'state')->first()->color;
    //     $state = State::find($state_id);
    //     return view('site.pages.state', compact('posts', 'state', 'section_color'));
    // }

    public function section($section_id)
    {
        $section = Section::find($section_id);
        $top_center_ads = $section->center_ads->where('top', 1);
        $posts = $section->posts->where('visibility', 1)->where('status', 1)->sortByDesc('created_at');

        return view('site.partials.home.category.section', compact('posts', 'section', 'top_center_ads'));
    }

    public function refresh_state_content()
    {
        $state_id = request()->state_id;
        $section = Section::where('style', 'state')->first();
        $state = State::find($state_id);
        $state_posts = Post::where('state_id', $state->id)->orderBy('created_at', 'desc')->limit(4)->get();
        if ($state_posts->count() == 0) return 'no_data';
        return view('site.partials.home.sections.refresh_state_content_ajax', compact('section', 'state', 'state_posts'));
    }

    public function downloadFile($name)
    {
        $file = url("public/files/$name");
        // dd($file);
        // header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=$name");
        readfile($file);
    }
}
