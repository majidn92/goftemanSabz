<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Language\Entities\Language;
use Modules\Post\Entities\Category;
use Modules\Post\Entities\QuizQuestion;
use Modules\Post\Entities\SubCategory;
use Validator;
use Modules\User\Entities\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Modules\Post\Entities\Post;
use Sentinel;
use Carbon\Carbon;
use URL;
use Illuminate\Support\Facades\Storage;
use Aws\S3\Exception\S3Exception as S3;
use Modules\Gallery\Entities\Image as galleryImage;
use Modules\Gallery\Entities\Video;
use Modules\Gallery\Entities\Audio;
use LaravelLocalization;
use Input;
use Modules\Ads\Entities\Ad;
use Modules\Common\Http\Controllers\GlobalController;
use Modules\Post\Entities\State;
use Modules\Post\Entities\Section;

class PostController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $categories = Category::all();
        $activeLang = Language::where('status', 'active')->orderBy('name', 'ASC')->get();

        $user = Sentinel::getUser();
        // dd($user->hasAccess(['access_all_user_posts']));
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->with('image', 'video', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('image', 'video', 'category', 'subCategory', 'user')
                ->paginate('15');
        }

        return view('post::index', compact('posts', 'categories', 'activeLang'));
    }

    public function createArticle()
    {
        $categories     = Category::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        $subCategories  = SubCategory::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage     = galleryImage::count();
        $countVideo     = Video::count();
        $states = State::all();
        $sections = Section::offset(3)->limit(9999)->get();
        $sources = DB::get();

        return view('post::article_create', compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo', 'states', 'sections','sources'));
    }

    public function saveNewPost(Request $request, $type)
    {
        // dd($request->all());
        $messages = [
            'title.required' => 'تیتر خبر الزامی است',
            'title.min' => 'عنوان باید حداقل دو حرف باشد',
            'title.min' => 'لید خبر باید حداقل 50 کاراکتر باشد',
            'title.unique' => 'عنوان تکراری است',
            'slug.required' => 'نامک خبر الزامی است',
            'slug.min' => 'نامک باید حداقل 2 حرف باشد',
            'slug.unique' => 'نامک تکراری است',
            'sub_title.required' => 'لید خبر الزامی است',
            'content.required' => 'پر کردن محتوا الزامی است',
            'language.required' => 'انتخاب زبان الزامی است',
            'category_ids.required' => 'انتخاب گروه الزامی است',
            'video_id.required' => 'انتخاب ویدئو الزامی است',
            'audio_id.required' => 'انتخاب صوت الزامی است',
            'image_id.required' => 'انتخاب عکس الزامی است',
        ];

        $rules = [
            'title'             => 'required|min:2|unique:posts',
            'slug'              => 'required|min:2|unique:posts|regex:/^\S*$/u',
            'sub_title'           => 'required',
            'language'          => 'required',
            'category_ids'       => 'required',
            'image_id'              => 'required',
        ];

        if ($type == 'video') {
            $rules['video_id'] = ['required'];
        }

        if ($type == 'audio') {
            $rules['audio_id'] = ['required'];
        }

        Validator::make($request->all(), $rules, $messages)->validate();

        $post = new Post();
        $post->on_title =   $request->on_title;
        $post->title = $request->title;
        $post->sub_title = $request->sub_title;
        if ($request->slug != null) :
            $post->slug = $request->slug;
        else :
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->user_id = Sentinel::getUser()->id;
        $post->content = $request->content;

        $post->status   = $request->status;
        if ((!(Sentinel::getUser()->hasAccess(['show_post_directly'])) and $request->status == 1)) {
            $post->status   = 3;
        }

        $post->layout = 'style_2';


        if (isset($request->featured)) :
            $post->featured = 1;
        else :
            $post->featured = 0;
        endif;

        if (isset($request->breaking)) :
            $post->breaking = 1;
        else :
            $post->breaking = 0;
        endif;

        if (isset($request->slider)) :
            $post->slider = 1;
        else :
            $post->slider = 0;
        endif;

        if (isset($request->opinion)) :
            $post->opinion = 1;
        else :
            $post->opinion = 0;
        endif;

        if (isset($request->populare)) :
            $post->populare = 1;
        else :
            $post->populare = 0;
        endif;

        if (isset($request->person_of_day)) :
            $post->person_of_day = 1;
        else :
            $post->person_of_day = 0;
        endif;

        if (isset($request->chat_room)) :
            $post->chat_room = 1;
        else :
            $post->chat_room = 0;
        endif;

        if (isset($request->featured_main_page)) :
            $post->featured_main_page = 1;
        else :
            $post->featured_main_page = 0;
        endif;

        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->tags = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language = $request->language;
        $post->image_id = $request->image_id;

        if ($type == 'video') :
            $post->post_type = 'video';
            $post->video_id = $request->video_id;
            $post->video_url_type = $request->video_url_type;
            $post->video_url = $request->video_url;
            $post->video_thumbnail_id = $request->video_thumbnail_id;
        elseif ($type == 'audio') :
            $post->post_type = 'audio';
            $post->audio_id = $request->audio_id;
        else :
            $post->post_type = 'article';
        endif;

        if ($request->status == 2) :
            $post->scheduled = 1;
            $post->scheduled_date = jalali_to_miladi($request->scheduled_date);
        endif;

        $post->contents = $request->new_content;

        $post->save();

        // ($type == 'audio') ? Audio::find($request->audio_id)->update(['post_id' => $post->id]) : null;

        // add relation sections
        if ($request->has('section_id')) {
            foreach ($request->section_id as $item) {
                DB::table('post_section')->insert([
                    'post_id' => $post->id,
                    'section_id' => $item,
                ]);
            }
        }

        // add relation states
        if ($request->has('state_id')) {
            foreach ($request->state_id as $item) {
                DB::table('post_state')->insert([
                    'post_id' => $post->id,
                    'state_id' => $item,
                ]);
            }
        }

        // add relation categories
        if ($request->has('category_ids')) {
            $category_ids = explode(',', $request->category_ids);
            foreach ($category_ids as $item) {
                DB::table('category_post')->insert([
                    'post_id' => $post->id,
                    'category_id' => $item,
                ]);
            }
        }

        // add relation sub_categories
        if ($request->has('sub_category_ids')) {
            $sub_category_ids = explode(',', $request->sub_category_ids);
            foreach ($sub_category_ids as $item) {
                DB::table('post_sub_category')->insert([
                    'post_id' => $post->id,
                    'sub_category_id' => $item,
                ]);
            }
        }

        generateRssFile();

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');
        Cache::forget('lastPost');
        Cache::forget('menuDetails');
        Cache::forget('primary_menu');

        return redirect('post')->with('success', __('successfully_added'));
    }

    public function editPost($type, $id)
    {
        $activeLang = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $post = Post::where('id', $id)->with(['image', 'video', 'videoThumbnail', 'category', 'subCategory'])->first();
        // dd($post->audio);
        $categories = Category::where('language', $post->language)->get();
        $ads = Ad::orderBy('created_at', 'desc')->get();
        $sections = Section::offset(3)->limit(9999)->get();

        $subCategories  = [];
        if ($post->category_id != "") {
            $subCategories  = SubCategory::where('category_id', $post->category_id)->get();
        }

        $post_contents = [];
        if (!blank($post->contents)) :
            foreach ($post->contents as $key => $content) {
                $content_type = array_keys($content);
                foreach ($content as $value) {

                    $abc = [];
                    foreach ($value as $key => $item) {

                        if ($key == 'image_id' && $key != "") {

                            $image = galleryImage::find($item);
                            $abc[] = [$key => $item, 'image' => $image];
                        } elseif ($key == 'video_thumbnail_id' && $key != "") {

                            $image = galleryImage::find($item);
                            $abc[] = [$key => $item, 'video_thumbnail' => $image];
                        } elseif ($key == 'video_id' && $key != "") {

                            $video = Video::find($item);
                            $abc[] = [$key => $item, 'video' => $video];
                        } else {
                            $abc[] = [$key => $item];
                        }
                    }
                    $post_contents[] = [$content_type[0] => $abc];
                }
            }
        endif;

        $countImage  = galleryImage::count();
        $countAudio  = Audio::count();
        $countVideo  = Video::count();

        if ($type == 'article') :
            return view('post::article_edit', compact('post', 'categories', 'subCategories', 'activeLang', 'countImage', 'countVideo', 'post_contents', 'ads', 'sections'));
        elseif ($type == 'video') :
            return view('post::video_post_edit', compact('post', 'categories', 'subCategories', 'activeLang', 'countImage', 'countVideo', 'post_contents', 'ads', 'sections'));
        elseif ($type == 'audio') :
            return view('post::audio_post_edit', compact('post', 'categories', 'subCategories', 'activeLang', 'countImage', 'countAudio', 'countVideo', 'post_contents', 'ads', 'sections'));
        elseif ($type == 'trivia-quiz') :
            $post           = Post::where('id', $id)->with(['image', 'video', 'videoThumbnail', 'category', 'subCategory', 'quizResults'])->first();
            $quiz_questions = QuizQuestion::with('quizAnswers')->where('post_id', $id)->get();
            return view('post::trivia_quiz_edit', compact('post', 'categories', 'subCategories', 'activeLang', 'countImage', 'countAudio', 'countVideo', 'post_contents', 'quiz_questions'));
        elseif ($type == 'personality-quiz') :
            $post           = Post::where('id', $id)->with(['image', 'video', 'videoThumbnail', 'category', 'subCategory', 'quizResults'])->first();
            $quiz_questions = QuizQuestion::with('quizAnswers')->where('post_id', $id)->get();
            return view('post::personality_quiz_edit', compact('post', 'categories', 'subCategories', 'activeLang', 'countImage', 'countAudio', 'countVideo', 'post_contents', 'quiz_questions'));
        endif;
    }

    public function updatePost(Request $request, $type, $id)
    {
        $messages = [
            'title.required' => 'تیتر خبر الزامی است',
            'title.min' => 'عنوان باید حداقل دو حرف باشد',
            'title.min' => 'لید خبر باید حداقل 50 کاراکتر باشد',
            'title.unique' => 'عنوان تکراری است',
            'slug.required' => 'نامک خبر الزامی است',
            'slug.min' => 'نامک باید حداقل 2 حرف باشد',
            'slug.unique' => 'نامک تکراری است',
            'sub_title.required' => 'لید خبر الزامی است',
            'content.required' => 'پر کردن محتوا الزامی است',
            'language.required' => 'انتخاب زبان الزامی است',
            'category_ids.required' => 'انتخاب گروه الزامی است',
            'video_id.required' => 'انتخاب ویدئو الزامی است',
            'audio_id.required' => 'انتخاب صوت الزامی است',
            'image_id.required' => 'انتخاب عکس الزامی است',
        ];

        $rules = [
            'title'             => 'required|min:2|unique:posts,title,' . $id,
            'slug'              => 'required|min:2|regex:/^\S*$/u|unique:posts,slug,' . $id,
            'sub_title'           => 'required',
            'language'          => 'required',
            'category_ids'       => 'required',
            'image_id'              => 'required',
        ];

        if ($type == 'video') {
            $rules['video_id'] = ['required'];
        }

        if ($type == 'audio') {
            $rules['audio_id'] = ['required'];
        }

        Validator::make($request->all(), $rules, $messages)->validate();

        $post = Post::find($id);
        $post->title = $request->title;
        $post->on_title = $request->on_title;
        $post->sub_title = $request->sub_title;
        if ($request->slug != null) :
            $post->slug = $request->slug;
        else :
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->content = $request->content;

        $post->status = $request->status;
        if ((!(Sentinel::getUser()->hasAccess(['show_post_directly'])) and $request->status == 1) || ((Sentinel::getUser()->hasAccess(['show_post_directly']) && $post->user_id != Sentinel::getUser()->id && $post->status == 1))) {
            $post->status   = 3;
        }

        $post->layout = 'style_2';

        if (isset($request->featured)) :
            $post->featured = 1;
        else :
            $post->featured = 0;
        endif;

        if (isset($request->breaking)) :
            $post->breaking = 1;
        else :
            $post->breaking = 0;
        endif;

        if (isset($request->slider)) :
            $post->slider   = 1;
        else :
            $post->slider   = 0;
        endif;

        if (isset($request->opinion)) :
            $post->opinion  = 1;
        else :
            $post->opinion  = 0;
        endif;

        if (isset($request->populare)) :
            $post->populare  = 1;
        else :
            $post->populare  = 0;
        endif;

        if (isset($request->person_of_day)) :
            $post->person_of_day  = 1;
        else :
            $post->person_of_day  = 0;
        endif;

        if (isset($request->chat_room)) :
            $post->chat_room = 1;
        else :
            $post->chat_room = 0;
        endif;

        if (isset($request->featured_main_page)) :
            $post->featured_main_page = 1;
        else :
            $post->featured_main_page = 0;
        endif;

        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->tags = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language = $request->language;
        $post->category_id = $request->category_id;
        $post->sub_category_id = $request->sub_category_id;
        $post->image_id = $request->image_id;
        $post->state_id = $request->state_id;

        if (isset($request->video_id)) :
            $post->video_id = $request->video_id;
        endif;

        if (isset($request->video_url)) :
            $post->video_url = $request->video_url;
        endif;

        if (isset($request->video_thumbnail_id)) :
            $post->video_thumbnail_id = $request->video_thumbnail_id;
        endif;

        if ($request->status == 2) :
            $post->scheduled_date = jalali_to_miladi($request->scheduled_date);
        endif;

        if (isset($request->scheduled)) :
            $post->scheduled = 1;
        endif;

        $post->contents = $request->new_content;

        $post->save();

        // edit relation section
        DB::table('post_section')->where('post_id', $post->id)->delete();
        if ($request->has('section_id')) {
            foreach ($request->section_id as $item) {
                DB::table('post_section')->insert([
                    'post_id' => $post->id,
                    'section_id' => $item,
                ]);
            }
        }

        // edit relation state
        DB::table('post_state')->where('post_id', $post->id)->delete();
        if ($request->has('state_id')) {
            foreach ($request->state_id as $item) {
                DB::table('post_state')->insert([
                    'post_id' => $post->id,
                    'state_id' => $item,
                ]);
            }
        }

        // edit relation categories
        DB::table('category_post')->where('post_id', $post->id)->delete();
        if ($request->has('category_ids')) {
            $category_ids = explode(',', $request->category_ids);
            foreach ($category_ids as $item) {
                DB::table('category_post')->insert([
                    'post_id' => $post->id,
                    'category_id' => $item,
                ]);
            }
        }

        // edit relation sub_categories
        DB::table('post_sub_category')->where('post_id', $post->id)->delete();
        if ($request->has('sub_category_ids')) {
            $sub_category_ids = explode(',', $request->sub_category_ids);
            foreach ($sub_category_ids as $item) {
                DB::table('post_sub_category')->insert([
                    'post_id' => $post->id,
                    'sub_category_id' => $item,
                ]);
            }
        }

        generateRssFile();

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');
        Cache::forget('lastPost');
        Cache::forget('menuDetails');
        Cache::forget('primary_menu');

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function fetchCategory(Request $request)
    {
        $select         = $request->get('select');
        $value          = $request->get('value');
        $data           = Category::where('language', $value)->get();
        $output         = '<option value="">' . __('select_category') . '</option>';
        foreach ($data as $row) :
            $output     .= '<option value="' . $row->id . '">' . $row->category_name . '</option>';
        endforeach;

        echo $output;
    }

    public function fetchSubcategory(Request $request)
    {
        $category_id = $request->get('category_id');
        $output = '';
        if ($category_id == null) {
            return $output;
        }

        $category = Category::find($category_id);
        $sub_categories = $category->subCategory;

        $output .=  '<div class="category-box" data-category-id="' . $category->id . '">';
        $output .= '<div class="category">' . $category->category_name . '</div>';

        foreach ($sub_categories as $sub_category) {
            $output .= '<div class="option"><input type="checkbox" data-category-id="' . $category_id . '" data-sub-category-id="' . $sub_category->id . '" data-sub-category-name="' . $sub_category->sub_category_name . '" >' . $sub_category->sub_category_name . '</div>';
        }

        $output .= '</div>';

        echo $output;
    }

    public function slider()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.slider', 1)
                ->orderBy('slider_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.slider', 1)
                ->orderBy('slider_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::slider_posts', compact('posts'));
    }

    public function featuredPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.featured', 1)
                ->orderBy('featured_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.featured', 1)
                ->orderBy('featured_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::featured_posts', compact('posts'));
    }

    public function breakingPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.breaking', 1)
                ->orderBy('breaking_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.breaking', 1)
                ->where('user_id', $user->id)
                ->orderBy('breaking_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::breaking_posts', compact('posts'));
    }

    public function pendingPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 3)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 3)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::pending_posts', compact('posts'));
    }

    public function scheduledPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 2)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 2)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::scheduled_posts', compact('posts'));
    }

    public function draftPosts()
    {

        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 0)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('visibility', 1)
                ->where('posts.status', 0)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::draft_posts', compact('posts'));
    }

    public function popularePosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.populare', 1)
                ->orderBy('populare_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.populare', 1)
                ->orderBy('populare_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::populare_posts', compact('posts'));
    }

    public function opinionPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.opinion', 1)
                ->orderBy('opinion_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.opinion', 1)
                ->orderBy('opinion_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::opinion_posts', compact('posts'));
    }

    public function personOfDayPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.person_of_day', 1)
                ->orderBy('person_of_day_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.person_of_day', 1)
                ->orderBy('person_of_day_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::person_of_day_posts', compact('posts'));
    }

    public function chatRoomPosts()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess(['access_all_user_posts'])) {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('posts.chat_room', 1)
                ->orderBy('chat_room_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        } else {
            $posts = Post::where('status', 1)
                ->where('visibility', 1)
                ->where('user_id', $user->id)
                ->where('posts.chat_room', 1)
                ->orderBy('chat_room_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->with('image', 'category', 'subCategory', 'user')
                ->paginate('15');
        }
        return view('post::chat_room_posts', compact('posts'));
    }

    public function removePostFrom(Request $request)
    {
        $feature = $request->feature;
        $post = Post::find($request->post_id);
        $post->$feature = 0;

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        $post->save();

        $data['status']     = "success";
        $data['message']    =  __('successfully_updated');

        echo json_encode($data);
    }

    public function addPostTo(Request $request)
    {
        $feature = $request->feature;
        $post = Post::find($request->post_id);

        $post->$feature = 1;

        $post->save();

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        $data['status']     = "success";
        $data['message']    =  __('successfully_updated');

        echo json_encode($data);
        // dd($post);

    }

    public function updateSliderOrder(Request $request)
    {

        for ($i = 0; $i < count($request->post_id); $i++) :
            $post               =   Post::find($request->post_id[$i]);
            $post->slider_order = $request->order[$i];
            $post->save();
        endfor;

        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        return redirect()->back()->with('success', __('successfully_updated'));
    }
    public function updateFeaturedOrder(Request $request)
    {
        if (strtolower(\Config::get('app.demo_mode')) == 'yes') :
            return redirect()->back()->with('error', __('You are not allowed to add/modify in demo mode.'));
        endif;

        for ($i = 0; $i < count($request->post_id); $i++) :
            $post                   = Post::find($request->post_id[$i]);
            $post->featured_order   = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success', __('successfully_updated'));
    }
    public function updateBreakingOrder(Request $request)
    {
        if (strtolower(\Config::get('app.demo_mode')) == 'yes') :
            return redirect()->back()->with('error', __('You are not allowed to add/modify in demo mode.'));
        endif;

        for ($i = 0; $i < count($request->post_id); $i++) {
            $post                   = Post::find($request->post_id[$i]);
            $post->breaking_order   = $request->order[$i];
            $post->save();
        }

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        return redirect()->back()->with('success', __('successfully_updated'));
    }
    public function updatePopulareOrder(Request $request)
    {
        for ($i = 0; $i < count($request->post_id); $i++) {
            $post = Post::find($request->post_id[$i]);
            $post->populare_order = $request->order[$i];
            $post->save();
        }

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function updateOpinionOrder(Request $request)
    {
        for ($i = 0; $i < count($request->post_id); $i++) :
            $post = Post::find($request->post_id[$i]);
            $post->opinion_order = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function updateChatRoomOrder(Request $request)
    {
        for ($i = 0; $i < count($request->post_id); $i++) :
            $post = Post::find($request->post_id[$i]);
            $post->chat_room_order = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function updatePersonOfDayOrder(Request $request)
    {
        for ($i = 0; $i < count($request->post_id); $i++) :
            $post = Post::find($request->post_id[$i]);
            $post->person_of_day_order = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    public function createVideoPost()
    {
        $categories         = Category::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        $subCategories      = SubCategory::all();
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();
        $countVideo         = Video::count();
        $states = State::all();
        $sections = Section::offset(3)->limit(9999)->get();

        return view('post::video_post_create', compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo', 'states', 'sections'));
    }

    public function createAudioPost()
    {
        $categories         = Category::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        $subCategories      = SubCategory::all();
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();
        $countAudio         = Audio::count();
        $countVideo         = Video::count();
        $states = State::all();
        $sections = Section::offset(3)->limit(9999)->get();

        return view('post::audio_post_create', compact('categories', 'subCategories', 'activeLang', 'countImage', 'countAudio', 'countVideo', 'states', 'sections'));
    }

    public function createTriviaQuiz()
    {
        $categories     = Category::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        $subCategories  = SubCategory::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage     = galleryImage::count();
        $countVideo     = Video::count();

        return view('post::trivia_quiz_create', compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo'));
    }

    public function createPersonalityQuiz()
    {
        $categories     = Category::where('language', LaravelLocalization::setLocale() ?? settingHelper('default_language'))->get();
        $subCategories  = SubCategory::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage     = galleryImage::count();
        $countVideo     = Video::count();

        return view('post::personality_quiz_create', compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo'));
    }

    public function filterPost(Request $request)
    {
        $categories         = Category::all();
        if ($request->category_id == null) :
            $subCategories  = [];
        else :
            $subCategories  = SubCategory::where('category_id', $request->category_id)->get();
        endif;
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $search_query       = $request;


        $posts = Post::where('language', 'like', '%' . $request->language . '%')
            ->where('post_type', 'like', '%' . $request->post_type . '%')
            // ->where('category_id', 'like', '%' . $request->category_id . '%')
            // ->where('sub_category_id', 'like', '%' . $request->sub_category_id . '%')
            ->where('title', 'like', '%' . $request->search_key . '%')
            ->orderBy('created_at', 'desc')
            ->with('image', 'video', 'category', 'subCategory', 'user')
            ->paginate('15');

        // dd($posts);

        return view('post::post_search', compact('posts', 'categories', 'activeLang', 'search_query', 'subCategories'));
    }

    private function make_slug($string, $delimiter = '-')
    {

        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);

        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
        $result = mb_strtolower($string);

        if ($result) :
            return $result;
        else :
            return $string;
        endif;
    }

    // added by majid molaea for delete all posts
    public function delete_all_post(Request $request)
    {
        $ids = $request->ids;
        $ids = explode(",", $ids);
        foreach ($ids as $id) {
            $post = Post::findorfail($id);
            $post->delete();
        }
        return back()->with('success', 'اخبار مورد نظر با موفقیت حذف شدند');
    }

    // added by majid molaea for change author post
    public function changeAuthor()
    {
        $post = Post::find(request()->post_id);
        $post->user_id = request()->author_id;
        $post->save();
        return back()->with('success', 'نویسنده خبر مورد نظر تغییر یافت');
    }

    public function deletePostFrom(Request $request)
    {
        $ids = $request->ids;
        $column = $request->column;
        $ids = explode(",", $ids);
        foreach ($ids as $id) {
            $post = Post::find($id);
            $post->$column = 0;
            $post->save();
        }
        return back()->with('success', 'خبر مورد نظر با موفقیت از بخش مربوطه حذف شد');
    }
}
