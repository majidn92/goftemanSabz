<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">{{ __('dashboard') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    @if (Sentinel::getUser()->roles[0]->id != 4 && Sentinel::getUser()->roles[0]->id != 5)
                        <li class="nav-item ">
                            <a class="nav-link @yield('home')" href="{{ route('dashboard') }}">
                                <i class="fas fa-home fa-th-large"></i>{{ __('dashboard') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link @yield('home')" href="{{ route('user-account') }}">
                                <i class="fas fa-home fa-th-large"></i>{{ __('profile') }}
                            </a>
                        </li>
                    @endif
                    @if (Sentinel::getUser()->roles[0]->id == 1)
                        <li class="nav-item ">
                            <a class="nav-link @yield('section')" href="#" data-toggle="collapse" @yield('section-aria-expanded', 'aria-expanded=false') data-target="#submenu-9" aria-controls="submenu-9">
                                <i class="fas fa-fw fa-th-list"></i>چیدمان صفحه اصلی
                            </a>
                            <div id="submenu-9" class="collapse submenu @yield('section-show')">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @yield('section-index')" href="{{ url('setting/sections') }}">
                                            بخش ها
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('menu')" href="{{ route('menu-item') }}">
                                            منو هدر
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('footer_menu_item')" href="{{ url('footer-menu') }}">
                                            منو فوتر
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('category-active')" href="{{ route('categories') }}">
                                            گروه
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('sub-category-active')" href="{{ route('sub-categories') }}">
                                            زیر گروه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['post_read']) || Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('post')" href="#" data-toggle="collapse" @yield('post-aria-expanded', 'aria-expanded=false') data-target="#submenu-2" aria-controls="submenu-2">
                                <i class="fas fa-fw fa-th-list"></i>{{ __('posts') }}
                            </a>
                            <div id="submenu-2" class="collapse submenu @yield('post-show')">
                                <ul class="nav flex-column">
                                    @if (Sentinel::getUser()->hasAccess(['post_write']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('create_article')" href="{{ route('create-article') }}">ایجاد خبر متنی</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @yield('create_video')" href="{{ route('create-video-post') }}">{{ __('create_video_post') }} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @yield('create_audio')" href="{{ route('create-audio-post') }}">{{ __('create_audio_post') }} </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link @yield('post-active')" href="{{ route('post') }}">{{ __('all_post') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('pending-post-active')" href="{{ route('pending-posts') }}">در انتظار تائید</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('draft-post-active')" href="{{ route('draft-posts') }}">پیش نویس</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('scheduled-post-active')" href="{{ route('scheduled-posts') }}">زمانبندی</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('slider-post-active')" href="{{ route('slider-posts') }}">اسلایدر</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('feature-post-active')" href="{{ route('featured-posts') }}">ویژه</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('breaking-post-active')" href="{{ route('breaking-posts') }}">فوری</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('populare-post-active')" href="{{ route('populare-posts') }}">پر بازدید</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('opinion-post-active')" href="{{ route('opinion-posts') }}">دیدگاه</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('chat-room-post-active')" href="{{ route('chat-room-posts') }}">اتاق گفتگو</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('person-of-day-post-active')" href="{{ route('person-of-day-posts') }}">ویژه نگار</a>
                                    </li>

                                    @if (Sentinel::getUser()->hasAccess(['post_write']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('create_trivia_quiz')" href="{{ route('create-trivia-quiz') }}">{{ __('create_trivia_quiz') }} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @yield('create_personality_quiz')" href="{{ route('create-personality-quiz') }}">{{ __('create_personality_quiz') }} </a>
                                        </li>
                                    @endif
                                    @if (Sentinel::getUser()->hasAccess(['post_write']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('rss')" href="{{ route('rss-feeds') }}">
                                                RSS
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link @yield('files')" href="{{ route('files') }}">
                            <i class="fas fa-fw fa-upload"></i>  بارگذاری فایل
                        </a>
                    </li>

                    @if (Sentinel::getUser()->hasAccess(['comments_read']) || Sentinel::getUser()->hasAccess(['comments_write']) || Sentinel::getUser()->hasAccess(['comments_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('comments_active')" href="#" data-toggle="collapse" @yield('comments-aria-expanded', 'aria-expanded=false') data-target="#submenu-115" aria-controls="submenu-115">
                                <i class="fas fa-fw fa-comments"></i>{{ __('comments') }}
                            </a>
                            <div id="submenu-115" class="collapse submenu @yield('comments-show')">
                                <ul class="nav flex-column">
                                    @if (Sentinel::getUser()->hasAccess(['comments_read']) || Sentinel::getUser()->hasAccess(['comments_delete']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('comments')" href="{{ route('comments') }}">
                                                {{ __('all_comments') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (Sentinel::getUser()->hasAccess(['comments_write']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('comments-setting')" href="{{ route('setting-comment') }}">
                                                {{ __('settings') }}
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['album_read']) || Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('all-images-active')" href="{{ route('images') }}">
                                <i class="fas fa-fw fa-image"></i> آلبوم تصاویر
                            </a>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['pages_read']) || Sentinel::getUser()->hasAccess(['pages_write']) || Sentinel::getUser()->hasAccess(['pages_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('pages')" href="#" data-toggle="collapse" @yield('page-aria-expanded', 'aria-expanded=false') data-target="#submenu-1" aria-controls="submenu-1">
                                <i class="fa fa-fw fa-file"></i> {{ __('pages') }}
                            </a>
                            <div id="submenu-1" class="collapse submenu @yield('page-show')">
                                <ul class="nav flex-column">
                                    @if (Sentinel::getUser()->hasAccess(['pages_write']))
                                        <li class="nav-item">
                                            <a class="nav-link @yield('add-page-active')" href="{{ route('add-page') }}">{{ __('add_page') }}</a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link @yield('pages-list')" href="{{ route('pages') }}">{{ __('pages') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['polls_read']) || Sentinel::getUser()->hasAccess(['polls_write']) || Sentinel::getUser()->hasAccess(['polls_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('poll')" href="{{ route('polls') }}">
                                <i class="mdi mdi-poll"></i>{{ __('polls') }}
                            </a>
                        </li>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['ads_read']) || Sentinel::getUser()->hasAccess(['ads_write']) || Sentinel::getUser()->hasAccess(['ads_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('ads')" href="#" @yield('ads-aria-expanded', 'aria-expanded=false') data-toggle="collapse" data-target="#submenu-3" aria-controls="submenu-3">
                                <i class="fab fa-fw fa-buysellads"></i>{{ __('ads') }}
                            </a>
                            <div id="submenu-3" class="collapse submenu @yield('ads-show')">
                                <ul class="nav flex-column">
                                    {{-- بابت حذف موقت تبلیغات اصلی --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link @yield('ads_main')" href="{{ route('ads') }}"></i>تبلیغات اصلی</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link @yield('ads_side')" href="{{ route('side') }}"></i>تبلیغات نوار کناری</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('ads_center')" href="{{ route('center') }}"></i>تبلیغات میانی</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['widget_read']) || Sentinel::getUser()->hasAccess(['widget_write']) || Sentinel::getUser()->hasAccess(['widget_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('widgets')" href="{{ route('widgets') }}">
                                <i class="fas fa-fw fa-th-large"></i>{{ __('widgets') }}
                            </a>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['notification_write']))
                        <li class="nav-item">
                            <a class="nav-link @yield('notification_active')" href="#" data-toggle="collapse" @yield('notification-aria-expanded', 'aria-expanded=false') data-target="#submenu-113" aria-controls="submenu-113">
                                <i class="fas fa-bell"></i>{{ __('notification') }}
                            </a>
                            <div id="submenu-113" class="collapse submenu @yield('notification-show')">
                                <ul class="nav flex-column">
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('send_notification')" href="{{ route('send-notification') }}">
                                            {{ __('send_notification') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('send_custom_notification')" href="{{ route('send-custom-notification') }}">
                                            {{ __('send_custom_notification') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('notify_setting')" href="{{ route('notification-setting') }}">
                                            {{ __('settings') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['newsletter_read']) || Sentinel::getUser()->hasAccess(['newsletter_write']) || Sentinel::getUser()->hasAccess(['newsletter_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('newsletter_active')" href="#" data-toggle="collapse" @yield('newsletter-aria-expanded', 'aria-expanded=false') data-target="#submenu-114" aria-controls="submenu-114">
                                <i class="fa fa-paper-plane"></i>{{ __('newsletter') }}
                            </a>
                            <div id="submenu-114" class="collapse submenu @yield('newsletter-show')">
                                <ul class="nav flex-column">
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('send_newsletter')" href="{{ route('send-email-to-subscriber') }}">
                                            {{ __('send_email_to_subscribers') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('subscriber')" href="{{ route('subscriber-list') }}">
                                            {{ __('subscribers') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['contact_message_read']) || Sentinel::getUser()->hasAccess(['contact_message_write']) || Sentinel::getUser()->hasAccess(['contact_message_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('contact_message')" href="{{ route('contact') }}">
                                <i class="fas fa-fw fa-space-shuttle"></i>{{ __('contact_messages') }}
                            </a>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['permission_read']) || Sentinel::getUser()->hasAccess(['permission_write']) || Sentinel::getUser()->hasAccess(['permission_delete']) || Sentinel::getUser()->hasAccess(['role_read']) || Sentinel::getUser()->hasAccess(['role_write']) || Sentinel::getUser()->hasAccess(['role_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('rolePermission')" href="#" data-toggle="collapse" @yield('rolePermission_', 'aria-expanded=false') data-target="#submenu-110" aria-controls="submenu-110">
                                <i class="fas fa-fw fa-key"></i>{{ __('roles_&_permissions') }}
                            </a>
                            <div id="submenu-110" class="collapse submenu @yield('p-show')">

                                <ul class="nav flex-column">
                                    @if (Sentinel::getUser()->hasAccess(['permission_read']) || Sentinel::getUser()->hasAccess(['permission_write']) || Sentinel::getUser()->hasAccess(['permission_delete']))
                                        <li class="nav-item ">
                                            <a class="nav-link @yield('rolePermissionsub')" href="{{ route('roles') }}">
                                                {{ __('roles') }}
                                            </a>
                                        </li>
                                    @endif

                                    @if (Sentinel::getUser()->hasAccess(['role_read']) || Sentinel::getUser()->hasAccess(['role_write']) || Sentinel::getUser()->hasAccess(['role_delete']))
                                        <li class="nav-item ">
                                            <a class="nav-link @yield('permissions')" href="{{ route('permissions') }}">
                                                {{ __('permissions') }}
                                            </a>
                                        </li>
                                    @endif

                                    @if (Sentinel::getUser()->hasAccess(['role_read']) || Sentinel::getUser()->hasAccess(['role_write']) || Sentinel::getUser()->hasAccess(['role_delete']))
                                        <li class="nav-item ">
                                            <a class="nav-link @yield('other-permissions')" href="{{ route('other-permissions') }}">
                                                سایر دسترسی ها
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['users_read']) || Sentinel::getUser()->hasAccess(['users_write']) || Sentinel::getUser()->hasAccess(['users_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('user-list')" href="{{ route('users-list') }}">
                                <i class="fas fa-fw fa-users"></i>{{ __('users') }}
                            </a>
                        </li>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['settings_read']) || Sentinel::getUser()->hasAccess(['settings_write']) || Sentinel::getUser()->hasAccess(['settings_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('settings_active')" href="#" data-toggle="collapse" @yield('settings', 'aria-expanded=false') data-target="#submenu-111" aria-controls="submenu-111">
                                <i class="fas fa-fw fa-cog"></i>{{ __('settings') }}
                            </a>
                            <div id="submenu-111" class="collapse submenu @yield('s-show')">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @yield('theme_option')" href="{{ route('themes-options') }}">تنظیمات ظاهری</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-general')" href="{{ route('setting-general') }}">
                                            {{ __('general_settings') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-company')" href="{{ route('setting-company') }}">
                                            {{ __('company_informations') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @yield('social')" href="{{ route('socials') }}">
                                            {{ __('socials') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-email')" href="{{ route('setting-email') }}">
                                            {{ __('email_settings') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-source')" href="{{ url('setting/sources') }}">
                                            منابع خبری
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-storage')" href="{{ route('setting-storage') }}">
                                            {{ __('storage_settings') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-seo')" href="{{ route('setting-seo') }}">
                                            {{ __('seo_settings') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-recaptcha')" href="{{ route('setting-recaptcha') }}">
                                            {{ __('recaptcha_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-url')" href="{{ route('settings-url') }}">
                                            {{ __('url_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-ffmpeg')" href="{{ route('settings-ffmpeg') }}">
                                            {{ __('ffmpeg_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-custom')" href="{{ route('setting-custom-header-footer') }}">
                                            {{ __('custom_header_footer') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('cron-information')" href="{{ route('cron-information') }}">
                                            {{ __('cron_information') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-preference')" href="{{ route('preferene-control') }}">
                                            {{ __('preference_setting') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('email_temp')" href="{{ route('email-templates') }}">
                                            {{ __('email_template') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('setting-social-login')" href="{{ route('setting-social-login') }}">
                                            {{ __('social_login_settings') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('cache-route-config')" href="{{ route('cache') }}">
                                            {{ __('cache') }}
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('update-database')" href="{{ route('update-database') }}">
                                            {{ __('update') }}
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (Sentinel::getUser()->hasAccess(['api_read']) || Sentinel::getUser()->hasAccess(['api_write']) || Sentinel::getUser()->hasAccess(['api_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('api_active')" href="#" data-toggle="collapse" @yield('api', 'aria-expanded=false') data-target="#submenu-112" aria-controls="submenu-112">
                                <i class="fas fa-fw fa-mobile"></i>{{ __('mobile_app') }}
                            </a>
                            <div id="submenu-112" class="collapse submenu @yield('api-show')">
                                <ul class="nav flex-column">
                                    <li class="nav-item ">
                                        <a class="nav-link @yield('api-settings')" href="{{ route('api-settings') }}">
                                            {{ __('api_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('android-settings')" href="{{ route('android-settings') }}">
                                            {{ __('android_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('ios-settings')" href="{{ route('ios-settings') }}">
                                            {{ __('ios_settings') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('app-config')" href="{{ route('app-config') }}">
                                            {{ __('app_config') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('ads-config')" href="{{ route('ads-config') }}">
                                            {{ __('ads_config') }}
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link @yield('app-intro')" href="{{ route('app-intro') }}">
                                            {{ __('app_intro') }}
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endif


                    @if (Sentinel::getUser()->hasAccess(['language_settings_read']) || Sentinel::getUser()->hasAccess(['language_settings_write']) || Sentinel::getUser()->hasAccess(['language_settings_delete']))
                        <li class="nav-item">
                            <a class="nav-link @yield('language-setting')" href="{{ route('language-settings') }}">
                                <i class="fas fa-fw fa-globe"></i>{{ __('language_settings') }}
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="#"> </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"> </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
