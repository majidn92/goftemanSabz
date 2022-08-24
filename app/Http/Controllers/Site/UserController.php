<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\WidgetService;
use Modules\User\Entities\User;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Validator;
use Activation;

class UserController extends Controller
{
    public function insert_mobile()
    {
        $widgetService = new WidgetService();
        $widgets = $widgetService->getWidgetDetails();
        return view('site.auth.insert_mobile', compact('widgets'));
    }

    public function insert_mobile_post(Request $request)
    {
        $rules = [
            'mobile' => 'required|digits:11'
        ];
        if (settingHelper('captcha_visibility') == 1) {
            $rules['g-recaptcha-response'] = 'required';
        }
        $request->validate($rules);
        $mobile = $request->mobile;
        session()->put('mobile', $mobile);
        $user = User::where('phone', $mobile)->first();
        if ($user) {
            session()->put('user', $user);
            return redirect('insert-password');
        } else {
            $code = rand(1000, 9999);
            //ارسال کد از طریق پیامک به شماره کاربر

            // new
            // file_get_contents("https://api.kavenegar.com/v1/4D4F6F7449496E557735305051487336424E585448696863364B4C7268646934704934735262717A524F343D/verify/lookup.json?receptor=$mobile&token=$code&template=hybridevent");
            session()->put('code', $code);
            return redirect('register');
        }
    }

    public function resend_code()
    {
        $mobile = session()->get('mobile');
        $code = rand(1000, 9999);
        session()->put('code', $code);
        //ارسال کد از طریق پیامک به شماره کاربر
        file_get_contents("https://api.kavenegar.com/v1/4D4F6F7449496E557735305051487336424E585448696863364B4C7268646934704934735262717A524F343D/verify/lookup.json?receptor=$mobile&token=$code&template=hybridevent");
    }

    public function insert_password()
    {
        $mobile = session()->get('mobile');
        return view('site.auth.insert_password', compact('mobile'));
    }

    public function showLoginForm()
    {
        $mobile = session()->get('mobile');
        return view('site.auth.insert_password', compact('mobile'));
    }

    public function login(Request $request)
    {
        if (settingHelper('captcha_visibility') == 1) :
            $request->validate([
                'password'      => ['required', 'string'],
                'g-recaptcha-response'      => ['nullable', 'string'],
            ]);
        else :
            $request->validate([
                'password'      => ['required', 'string'],
            ]);
        endif;

        $user = session()->get('user');
        if ($user->is_user_banned == 0) {
            return redirect()->back()->with(['error' => __('your_account_is_banned')]);
        }

        try {

            if (!Hash::check($request->get('password'), $user->password)) {
                return redirect(url('login'))->with(['error' => 'رمز عبور صحیح نیست']);
            }

            $password = $request->password;
            $credentials = [
                'phone' => $user->phone,
                'password' => $password,
            ];

            Sentinel::authenticate($credentials);

            return redirect()->route('home');
        } catch (NotActivatedException $e) {

            return redirect()->back()->with(['error' => __('your_account_is_not_activated')]);
        }
    }

    public function showRegistrationForm()
    {
        $mobile = session()->get('mobile');
        return view('site.auth.register', compact('mobile'));
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $code = session()->get('code');
        if ($request->hoghooghi) {
            session()->flash('hoghooghi', 1);
        }
        

        $rules = [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'password'      => ['required', 'string', 'min:8'],
            // 'code'      => ['required', 'digits:4', 'in:' . $code],

        ];

        if($request->hoghooghi){
            $rules['last_name'] = ['nullable', 'string', 'max:255'];
        }

        if(settingHelper('captcha_visibility') == 1){
            $rules['g-recaptcha-response'] = ['required', 'string'];
        }

        $request->validate($rules);

        $request['is_password_set'] = 1;

        try {

            $user = User::where('phone', $request->mobile)->first();

            if (!blank($user)) {
                if ($user->withActivation == "") {

                    $user->password             = bcrypt($request->password);
                    $user->first_name           = $request->first_name;
                    $user->last_name            = $request->last_name;
                    $user->phone                = $request->phone;
                    $user->hoghooghi                = $request->hoghooghi;
                    // $user->dob                = jalali_to_miladi_date($request->dob);
                    $user->is_password_set      = 1;
                    $user->save();

                    return redirect()->route('site.login.form')->with('success', __('با موفقیت ثبت شد'));
                } else {
                    return redirect()->back()->with('error', __('شماره موبایل قبلا ثبت شده است'));
                }
            }
            $data = $request->all();
            // $data['dob'] = jalali_to_miladi_date($request->dob);

            $data['phone'] = session()->get('mobile');

            $user = Sentinel::register($data);
            $role = Sentinel::findRoleBySlug('user');

            $role->users()->attach($user);


            $user = User::find($user->id);
            // dd($user);

            session()->put('user', $user);
            Activation::create($user);

            return redirect()->route('site.login.form')->with('success', __('با موفقیت ثبت شد'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('ثبت نام با خطا مواجه شد'));
        }
    }

    public function forgotPassword()
    {
        return view('site.auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        try {

            $user = User::wherePhone($request->mobile)->first();

            if (blank($user)) {
                return redirect()->back()->with('error', __('شماره موبایل شما ثبت نشده است'));
            }

            $mobile = $request->mobile;
            session()->put('mobile', $mobile);
            $code = rand(1000, 9999);
            session()->put('code', $code);
            // ارسال کد تائید به شماره موبایل کاربر
            file_get_contents("https://api.kavenegar.com/v1/4D4F6F7449496E557735305051487336424E585448696863364B4C7268646934704934735262717A524F343D/verify/lookup.json?receptor=$mobile&token=$code&template=hybridevent");

            return redirect('reset-password')->with([
                'success' => __('کد به شماره موبایل شما ارسال شد'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('ارسال کد با خطا مواجه شد'));
        }
    }

    public function resetPassword()
    {
        $mobile = session()->get('mobile');
        $user = User::wherePhone($mobile)->first();

        if ($user) :
            return view('site.auth.reset_password', ['mobile' => $mobile]);
        else :
            return redirect('login');
        endif;
    }

    public function PostResetPassword(Request $request)
    {
        $code = session()->get('code');

        Validator::make($request->all(), [
            'password'              => 'confirmed|required|min:5|max:10',
            'password_confirmation' => 'required|min:5|max:10',
            'code' => 'required|digits:4|in:' . $code,
        ])->validate();

        try {

            $mobile = session()->get('mobile');
            $user = User::where('phone', $mobile)->first();

            if ($user) :
                $user->password = Hash::make($request->password);
                $user->save();
                session()->put('user', $user);
                return redirect()->route('site.login.form')->with('success', __('you_can_login_with_new_password'));
            else :
                return redirect()->route('site.login.form')->with('success', __('شماره موبایل مورد نظر یافت نشد'));
            endif;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('عملیات با خطا مواجه شد'));
        }
    }

    public function logout()
    {
        Sentinel::logout();

        return redirect()->route('home');
    }
}
