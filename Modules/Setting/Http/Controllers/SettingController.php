<?php

namespace Modules\Setting\Http\Controllers;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Modules\Language\Entities\Language;
use Modules\Setting\Entities\Setting;
use Validator;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\Mail;
use Modules\Setting\Entities\EmailTemplate;
use File;
use Image;
use Illuminate\Support\Facades\Storage;
use App;
use Modules\Post\Entities\Section;
use Exception;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $countries      = Countries::all();

        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view(
            'setting::index',
            [
                'activeLang'    => $activeLang,
                'countries'     => $countries
            ]
        );
    }

    //update settings
    public function updateSettings(Request $request)
    {

        $default_language   = $request->default_language ?? settingHelper('default_language');

        $company_language   = $request->company_language;
        $seo_language       = $request->seo_language;
        $onesignal_language = $request->onesignal_language;

        foreach ($request->except('_token', 'company_language', 'seo_language', 'onesignal_language') as $key => $value) :

            Cache::Flush();

            if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) {
                $path = '';
            } else {
                $path = 'public/';
            }

            // if ($request->$key != null) :
            if ($key == 'logo') :
                if ($request->file('logo')) :

                    $validation = Validator::make($request->all(), [
                        'logo'  => 'required|mimes:jpg,JPG,JPEG,jpeg,gif,png|max:5120',
                    ])->validate();

                    $setting    = Setting::where('title', 'logo')->first();


                    if (File::exists($path . $setting->value) && !blank($setting->value)) :
                        unlink($path . $setting->value);
                    endif;

                    $requestImage       = $request->file('logo');

                    $fileType           = $requestImage->getClientOriginalExtension();
                    $originalImageName  = date('YmdHis') . "_logo_" . rand(1, 50) . '.' . $fileType;

                    if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) :
                        $directory              = 'images/';
                    else :
                        $directory              = 'public/images/';
                    endif;

                    $originalImageUrl   = $directory . $originalImageName;

                    Image::make($requestImage)->save($originalImageUrl);

                    $setting->value     = str_replace("public/", "", $originalImageUrl);
                    $setting->lang      = $default_language;

                    $setting->save();
                endif;

            elseif ($key == 'favicon') :
                if ($request->file('favicon')) :

                    $validation     = Validator::make($request->all(), [
                        'favicon'   => 'required|mimes:jpg,JPG,JPEG,jpeg,gif,png,ico|max:5120',
                    ])->validate();

                    $setting        = Setting::where('title', 'favicon')->first();

                    if (File::exists($path . $setting->value) && !blank($setting->value)) :
                        unlink($path . $setting->value);
                    endif;

                    $requestImage       = $request->file('favicon');

                    $fileType           = $requestImage->getClientOriginalExtension();
                    $originalImageName  = date('YmdHis') . "_favicon_" . rand(1, 50) . '.' . $fileType;

                    if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) :
                        $directory              = 'images/';
                    else :
                        $directory              = 'public/images/';
                    endif;

                    $originalImageUrl   = $directory . $originalImageName;

                    Image::make($requestImage)->save($originalImageUrl);

                    $setting->value     = str_replace("public/", "", $originalImageUrl);
                    $setting->lang      = $default_language;

                    $setting->save();

                endif;

            elseif ($key == 'og_image') :
                if ($request->file('og_image')) :

                    $validation     = Validator::make($request->all(), [
                        'og_image'  => 'required|mimes:jpg,JPG,JPEG,jpeg,gif,png,ico|max:5120',
                    ])->validate();

                    $setting = Setting::where('title', 'og_image')->first();
                    if (File::exists($setting->value)) :
                        unlink($setting->value);
                    endif;
                    $requestImage       = $request->file('og_image');

                    $fileType           = $requestImage->getClientOriginalExtension();
                    $originalImageName  = date('YmdHis') . "_og_image_" . rand(1, 50) . '.' . $fileType;


                    if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) :
                        $directory              = 'images/';
                    else :
                        $directory              = 'public/images/';
                    endif;

                    $originalImageUrl   = $directory . $originalImageName;

                    Image::make($requestImage)->save($originalImageUrl);

                    $setting->value     = str_replace("public/", "", $originalImageUrl);
                    $setting->lang      = $default_language;

                    $setting->save();

                endif;

            else :

                if ($key == "application_name" || $key == "address" || $key == "email" || $key == "phone" || $key == "zip_code" || $key == "city" || $key == "state" || $key == "country" || $key == "website" || $key == "company_registration" || $key == "tax_number" || $key == "about_us_description") :

                    $setting            = Setting::where('title', $key)->where('lang', $company_language)->first();

                    if ($setting == "") :
                        $setting        = new Setting();
                        $setting->title = $key;
                        $setting->value = $value;
                        $setting->lang  = $company_language;
                    else :
                        $setting->value = $value;
                        $setting->lang  = $company_language;
                    endif;

                elseif ($key == "seo_title" || $key == "seo_keywords" || $key == "seo_meta_description" || $key == "author_name" || $key == "og_title" || $key == "og_description") :

                    $setting            = Setting::where('title', $key)->where('lang', $seo_language)->first();

                    if ($setting == "") :
                        $setting        = new Setting();
                        $setting->title = $key;
                        $setting->value = $value;
                        $setting->lang  = $seo_language;
                    else :
                        $setting->value = $value;
                        $setting->lang  = $seo_language;
                    endif;

                elseif ($key == "onesignal_action_message" || $key == "onesignal_accept_button" || $key == "onesignal_cancel_button") :

                    $setting            = Setting::where('title', $key)->where('lang', $onesignal_language)->first();

                    if ($setting == "") :
                        $setting        = new Setting();
                        $setting->title = $key;
                        $setting->value = $value;
                        $setting->lang  = $onesignal_language;
                    else :
                        $setting->value = $value;
                        $setting->lang  = $onesignal_language;
                    endif;

                elseif ($key == "custom_footer_js" || $key == "custom_header_style" || $key == "predefined_header" || $key == "addthis_public_id" || $key == "addthis_toolbox") :

                    $setting            = Setting::where('title', $key)->where('lang', $default_language)->first();

                    if ($setting == "") :
                        $setting        = new Setting();
                        $setting->title = $key;
                        $setting->value = base64_encode($value);
                        $setting->lang  = $default_language;
                    else :
                        $setting->value = base64_encode($value);
                        $setting->lang  = $default_language;
                    endif;

                else :
                    $setting = Setting::where('title', $key)->where('lang', $default_language)->first();

                    if ($setting == "") :
                        $setting        = new Setting();
                        $setting->title = $key;
                        $setting->value = $value;
                        $setting->lang  = $default_language;
                    else :
                        $setting->value = $value;
                        $setting->lang  = $default_language;
                    endif;

                endif;

                $setting->save();

            endif;
        // endif;
        endforeach;

        $preloader = $request->preloader;
        if ($preloader) {
            // dd($preloader->getClientOriginalName());
            $request->validate([
                'preloader' => 'mimes:gif',
            ], [
                'preloader.mimes' => 'نوع فایل پیش نمایش باید  gif  باشد'
            ]);
            $file_pattern = "public/site/images/preloader.*";
            array_map("unlink", glob($file_pattern));
            $ext = $preloader->extension();
            $preloader_name = 'preloader' . '.' . $ext;
            $preloader->move('public/site/images/', $preloader_name);
        }

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    //view email template list
    public function emailTemplates()
    {
        $emailTemplates = EmailTemplate::all();
        return view('setting::email_templates', ['emailTemplates' => $emailTemplates]);
    }

    //edit an email template
    public function editEmailTemplates($id)
    {
        $emailTemplate  = EmailTemplate::find($id);
        return view('setting::edit_email_template', ['emailTemplate' => $emailTemplate]);
    }

    //update email template
    public function updateEmailTemplate(Request $request)
    {
        Validator::make($request->all(), [
            'email_group'       => 'required',
            'subject'           => 'required|min:5',
            'template_id'       => 'required',
            'template_body'     => 'required|min:10',
        ])->validate();

        $emailTemplate                  = EmailTemplate::find($request->template_id);

        $emailTemplate->subject         = $request->subject;
        $emailTemplate->template_body   = $request->template_body;

        $emailTemplate->save();

        return redirect()->route('email-templates')->with('success', __('successfully_updated'));
    }

    public function getCompanyInfo(Request $request)
    {

        $settings           = Setting::where('lang', $request->lang)->get();

        if ($request->type == 'company') :
            $needles        = ['application_name', 'address', 'email', 'phone', 'zip_code', 'city', 'state', 'country', 'website', 'company_registration', 'tax_number', 'about_us_description'];
        elseif ($request->type == 'seo') :
            $needles        = ['seo_title', 'seo_keywords', 'seo_meta_description', 'author_name', 'og_title', 'og_description'];
        else :
            $needles        = ['onesignal_action_message', 'onesignal_accept_button', 'onesignal_cancel_button'];
        endif;

        if ($settings->count() != 0) :

            foreach ($needles as $needle) :
                $i = 1;
                foreach ($settings as $setting) :

                    if ($i == 1) :

                        if (in_array($needle, $setting->toArray())) :
                            $data[$needle] = $setting->value;
                            $i++;
                        else :
                            $data[$needle] = '';
                        endif;

                    endif;

                endforeach;
            endforeach;

        else :
            foreach ($needles as $needle) :
                $data[$needle] = "";
            endforeach;
        endif;

        return response()->json($data);
    }

    public function sendTestMail(Request $request)
    {

        try {
            $data[]     = 'test email setting';

            Mail::send('setting::send_email_test', compact('data'), function ($message) use ($request) {

                $message->to($request->email)->subject(__('test_mail_subject'));
                $message->from(settingHelper('mail_address'));
            });

            return redirect()->back()->with('success', __('test_mail_success_message'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('test_mail_error_message'));
        }
    }

    public function generalSetting()
    {
        $countries      = Countries::all();

        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view(
            'setting::general',
            [
                'activeLang'    => $activeLang,
                'countries'     => $countries
            ]
        );
    }

    public function companySetting()
    {
        $countries      = Countries::all();

        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view(
            'setting::company_information',
            [
                'activeLang'    => $activeLang,
                'countries'     => $countries
            ]
        );
    }

    public function settingEmail()
    {
        return view('setting::email_setting');
    }

    public function settingStorage()
    {
        return view('setting::storage_setting');
    }

    public function settingSeo()
    {
        $countries      = Countries::all();

        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();

        return view(
            'setting::seo_setting',
            [
                'activeLang'    => $activeLang,
                'countries'     => $countries
            ]
        );
    }

    public function settingRecaptcha()
    {
        return view('setting::recaptcha_setting');
    }

    public function settingCustom()
    {
        return view('setting::custom_setting');
    }

    public function settingsUrl()
    {
        return view('setting::url_setting');
    }

    public function settingsFfmpeg()
    {
        return view('setting::settings_ffmpeg');
    }

    public function cronInformation()
    {
        return view('setting::cron_information');
    }

    public function prefereneControl()
    {
        return view('setting::preference_control');
    }

    public function scheduleRun($slug)
    {

        try {

            if ($slug == "newsletter") {

                \Artisan::call('queue:cron');
            } elseif ($slug == "video-convert") {

                \Artisan::call('videoConverter:cron');
            } elseif ($slug == "rss-import") {

                \Artisan::call('rssImport:cron');
            } else {

                \Artisan::call('schedulepost:cron');
            }

            return redirect(route('cron-information'))->with('success', __('cron_job_completed_successfully'));
        } catch (\Exception $e) {

            return redirect(route('cron-information'))->with('error', __('cron_job_completed_unsuccessfully'));
        }
    }

    public function settingSocialLogin()
    {
        return view('setting::setting_social_login');
    }

    public function cacheView()
    {
        return view('setting::cache-update');
    }

    public function cacheUpdate(Request $request)
    {
        if (strtolower(\Config::get('app.demo_mode')) == 'yes') :
            return redirect()->back()->with('error', __('You are not allowed to add/modify in demo mode.'));
        endif;

        chmod(base_path() . '/bootstrap/cache', 0777);

        if ($request->config_cache == 'enable') :
            if (!File::exists(base_path() . '/bootstrap/cache/config.php')) :
                \Artisan::call('config:cache');
            endif;
        elseif ($request->config_cache == 'disable') :
            if (File::exists(base_path() . '/bootstrap/cache/config.php')) :
                \Artisan::call('config:clear');
            endif;
        endif;

        return redirect(url('/') . '/setting/cache')->with('success', __('successfully_updated'));
    }

    // added by majid molaea for section part
    public function sections()
    {
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $sections = Section::orderBy('rank', 'asc')->get();
        return view('setting::sections.index', compact('activeLang', 'sections'));
    }

    public function section_create()
    {
        return view('setting::sections.create');
    }

    public function section_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'nullable',
        ]);

        $section = new Section;
        $section->name = $request->name;
        $section->color = $request->color;
        $section->rank = $request->filled('rank') ? $request->rank : 1;
        $section->style = $request->style;

        $section->show = isset($request->show) ? 1 : 0;
        $section->ads = isset($request->ads) && isset($request->show) ? 1 : 0;

        $section->save();
        return redirect('setting/sections')->with('success', 'بخش جدید با موفقیت ایجاد شد');
    }

    public function section_edit($id)
    {
        $section = Section::find($id);
        return view('setting::sections.edit', compact('section'));
    }

    public function section_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'nullable',
        ]);

        $section = Section::find($request->section_id);

        $section->name = $request->name;
        $section->color = $request->color;
        $section->rank = $request->filled('rank') ? $request->rank : 1;
        $section->style = $request->style;

        if ($section->id == 1) {
            $section->style = 'photo';
        }

        if ($section->id == 2) {
            $section->style = 'video';
        }


        $section->show = isset($request->show) ? 1 : 0;
        $section->ads = isset($request->ads) && isset($request->show) ? 1 : 0;

        $section->save();
        return redirect('setting/sections')->with('success', 'بخش جدید با موفقیت ویرایش شد');
    }

    public function section_ads()
    {
        // dd($id);
        Section::find($request->section_id)->delete();
        return redirect('setting/sections')->with('success', 'بخش مورد نظر با موفقیت حذف شد');
    }

    public function source()
    {
        $sources = \DB::table('sources')->get();
        return view('setting::sources', compact('sources'));
    }

    public function sourceAdd()
    {
        try {
            $name = request()->name;
            \DB::table('sources')->insert(['name' => $name]);
            session()->flash('success','منبع خبری با موفقیت افزوده شد');
            return 'success';
        } catch (Exception $e) {
            session()->flash('error','خطا در سیستم، دوباره تلاش نمائید');
            return 'error';
        }
    }

    public function sourceEdit()
    {
        try {
            $id = request()->id;
            $name = request()->name;
            \DB::table('sources')->where('id', $id)->update(['name' => $name]);
            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }

    public function sourceDelete()
    {
        try {
            $id = request()->id;
            \DB::table('sources')->where('id', $id)->delete();
            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }
}
