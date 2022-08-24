<style>
    .dropdown-menu-right {
        left: -30px !important
    }

    @media only screen and (max-width: 480px) {
        .dropdown-menu-right {
            left: 0 !important;
        }
    }

    .new-item-menu:hover {
        background: var(--primary-color);
        color: white;
    }
</style>

<header class="sg-header">
    <div class="sg-topbar top_menubar" style="padding-left: 5%;padding-right: 5%">
        <div style="display: flex">
            <div id="right-section" style="width:75%;display: flex">
                <span>
                    <button id="menu-bar" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="fa fa-align-justify text-light"></i>
                        </span>
                    </button>
                </span>
                {{-- لوگو --}}
                <span>
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ static_asset(settingHelper('logo')) }}" alt="Logo" style="aspect-ratio:unset !important">
                    </a>
                </span>
                {{-- اخبار فوری --}}
                {{-- <div style="width: 70%;padding-left: 10px">
                    <ul class="news-ticker-majid">
                        @php
                            $breaking_posts = \Modules\Post\Entities\Post::where('breaking', 1)
                                ->limit(10)
                                ->orderBy('breaking_order', 'asc')
                                ->get();
                        @endphp
                        @foreach ($breaking_posts as $item)
                            <li style="border-left: solid white 2px;margin-left: 5px"><a href="{{ route('article.detail', [$item->slug]) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div> --}}
            </div>
            <div id="left-section" style="width:25%;direction: ltr;display: flex;align-items: center">
                {{-- پروفایل --}}
                <span class="sg-user">
                    @if (Cartalyst\Sentinel\Laravel\Facades\Sentinel::check())
                        <span class="dropdown">
                            <a class="nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- بابت حذف تصویر پروفایل شخص لاگین شده --}}
                                {{-- @if (Sentinel::getUser()->profile_image != null)
                                    <img src="{{ static_asset('default-image/user.jpg') }}" data-original="{{ static_asset(Sentinel::getUser()->profile_image) }}" class="profile">
                                @else
                                    <i class="fa fa-user-circle mr-2"></i>
                                @endif --}}
                                {{-- {{ Sentinel::getUser()->first_name }} --}}
                                {{-- <i class="fa fa-angle-down  ml-2" aria-hidden="true"></i> --}}
                                <i class="fa fa-user-circle mr-2"></i>
                            </a>

                            <span class="dropdown-menu dropdown-menu-right nav-user-dropdown site-setting-area" style="direction: rtl" aria-labelledby="navbarDropdownMenuLink2">
                                @if (Sentinel::getUser()->roles[0]->id != 4 && Sentinel::getUser()->roles[0]->id != 5)
                                    <a class="" href="{{ route('dashboard') }} " target="_blank"><i class="fa fa-tachometer mr-2" aria-hidden="true"></i>{{ __('dashboard') }}</a>
                                @endif
                                <a class="" href="{{ route('site.profile') }}"><i class="fa fa-user mr-2"></i>{{ __('profile') }}</a>

                                <a class="" href="{{ route('site.profile.form') }}"><i class="fa fa-cog mr-2"></i>{{ __('edit_profile') }}</a>

                                <a class="" href="{{ route('site.logout') }}"><i class="fa fa-power-off mr-2"></i>{{ __('logout') }}</a>

                            </span>
                        </span>
                    @else
                        <span title="ورود" style="margin-right: 5px">
                            <a href="{{ url('insert-mobile') }}">
                                <i class="fa fa-user-circle mr-2" aria-hidden="true"></i>
                            </a>
                        </span>
                    @endif
                </span>
                {{-- تاریخ --}}
                <span style="margin-right: 5px" title="تاریخ">
                    <span>
                        <i class="fa fa-calendar ml-2" aria-hidden="true"></i>
                        <span>
                            {{ miladi_to_jalali(date('Y-m-d H:i:s')) }}
                        </span>
                    </span>
                </span>
                {{-- جستجو --}}
                <span style="position: relative" title="جستجو">
                    <span class="sg-search" style="display: none;position: absolute;width: 250px;bottom: -7px;left:45px">
                        <span class="search-form">
                            <form action="{{ route('article.search') }}" id="search" method="GET">
                                <label for="label" class="d-none">{{ __('search') }}</label>
                                <input class="form-control" id="label" name="search" type="text" placeholder="{{ __('search') }}">
                            </form>
                        </span>
                    </span>
                    <span>
                        <button id="search-btn" style="margin-left: 10px;border :unset;background-color: transparent;">
                            <i class="fa fa-search text-light"></i>
                            <span class="d-none">{{ __('search') }}</span>
                        </button>
                    </span>
                </span>
            </div>
        </div>
    </div>
    </div>
    <div class="sg-menu" style="background: var(--primary-color);border-top:solid 1px white;padding-left: 5%;padding-right: 5%">
        <nav class=" navbar-expand-lg">
            <div style="width: 100%;">
                <div class="menu-content">
                    <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
                        <ul class="navbar-nav">
                            @foreach ($primaryMenu as $mainMenu)
                                @if ($mainMenu->is_mega_menu == 'no')
                                    <li class="nav-item sg-dropdown">
                                        <a href="{{ menuUrl($mainMenu) }}" target="{{ $mainMenu->new_teb == 1 ? '_blank' : '' }}">
                                            {{ $mainMenu->label == 'gallery' ? __('gallery') : $mainMenu->label }}
                                            @if (!blank($mainMenu->children))
                                                <span>
                                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                        </a>
                                        <ul class="sg-dropdown-menu">
                                            @foreach ($mainMenu->children as $child)
                                                <li class="">
                                                    <a href="{{ menuUrl($child) }}" target="{{ $child->new_teb == 1 ? '_blank' : '' }}">{{ $child->label == 'gallery' ? __('gallery') : $child->label }}
                                                        @if (!blank($child->children))
                                                            <span class="pull-left"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                                        @endif
                                                    </a>
                                                    <ul class="sg-dropdown-menu-menu">
                                                        @foreach ($child->children as $subChild)
                                                            <li class=""><a href="{{ menuUrl($subChild) }}" target="{{ $subChild->new_teb == 1 ? '_blank' : '' }}">{{ $subChild->label == 'gallery' ? __('gallery') : $subChild->label }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                @if ($mainMenu->is_mega_menu == 'tab')
                                    <li class="sg-dropdown mega-dropdown">
                                        <a href="{{ menuUrl($mainMenu) ? menuUrl($mainMenu) : '#' }}">
                                            {{ $mainMenu->label == 'gallery' ? __('gallery') : $mainMenu->label }}
                                            <span>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        <div class="sg-dropdown-menu mega-dropdown-menu">
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach ($mainMenu->children as $child)
                                                                @php $key = 0 @endphp
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ $mainMenu->children[$key]->id == $child->id ? 'active' : '' }}" id="{{ $child->label }}-tab" data-toggle="tab" href="#{{ $child->category->slug }}" role="tab" aria-controls="{{ $child->label }}" aria-selected="{{ $mainMenu->children[$key]->id == $child->id ? 'true' : 'false' }}">{{ $child->label == 'gallery' ? __('gallery') : $child->label }}</a>
                                                                </li>
                                                                @php $key++ @endphp
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="tab-content" id="myTabContent">
                                                            @foreach ($mainMenu->children as $child)
                                                                <div class="tab-pane fade {{ $mainMenu->children[0]->id == $child->id ? 'show active' : '' }}" id="{{ $child->category->slug }}" role="tabpanel" aria-labelledby="{{ $child->label }}-tab">
                                                                    <div class="row">
                                                                        @foreach ($child->postByCategory as $item)
                                                                            <div class="col-md-6 col-lg-3">
                                                                                <div class="sg-post">
                                                                                    <div class="entry-header">
                                                                                        <div class="entry-thumbnail">
                                                                                            <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                                                                                @if (isFileExist(@$item->image, $result = @$item->image->medium_image_three))
                                                                                                    <img class="img-fluid" src="{{ safari_check() ? basePath(@$item->image) . '/' . $result : static_asset('default-image/default-240x160.png') }}" data-original="{{ basePath(@$item->image) }}/{{ $result }}" alt="{!! $item->title !!}">
                                                                                                @else
                                                                                                    <img class="img-fluid" src="{{ static_asset('default-image/default-240x160.png') }}" alt="{!! $item->title !!}">
                                                                                                @endif
                                                                                            </a>
                                                                                        </div>
                                                                                        @if ($item->post_type == 'video')
                                                                                            <div class="video-icon block">
                                                                                                <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                                                                            </div>
                                                                                        @elseif($item->post_type == 'audio')
                                                                                            <div class="video-icon block">
                                                                                                <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="entry-content">
                                                                                        <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                                                                            <p>{!! Str::limit($item->title, 35) !!}</p>
                                                                                        </a>
                                                                                        <div class="entry-meta">
                                                                                            <ul class="global-list">
                                                                                                <li>
                                                                                                    {{ __('post_by') }}
                                                                                                    <a href="{{ route('site.author', ['id' => $item->user->id]) }}">
                                                                                                        {{ $item->user->first_name }}
                                                                                                    </a>
                                                                                                    <a href="{{ route('article.date', date('Y-m-d', strtotime($item->updated_at))) }}">
                                                                                                        {{ date('d F Y', strtotime($item->created_at)) }}
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if ($mainMenu->is_mega_menu == 'category')
                                    <li class="sg-dropdown mega-dropdown">
                                        <a href="{{ menuUrl($mainMenu) }}" target="{{ $mainMenu->new_teb == 1 ? '_blank' : '' }}">{{ $mainMenu->label == 'gallery' ? __('gallery') : $mainMenu->label }}
                                            @if (!blank($mainMenu->children))
                                                <span>
                                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                        </a>
                                        <div class="sg-dropdown-menu mega-dropdown-menu">
                                            <div class="mega-menu-content" style="background: #f1f1f1">
                                                <div class="d-flex sub-category-box">
                                                    @foreach ($mainMenu->children as $child)
                                                        <div style="cursor: pointer" class="new-item-menu">
                                                            <a href="{{ menuUrl($child) }}" target="{{ $child->new_teb == 1 ? '_blank' : '' }}">
                                                                <h3>{{ $child->label == 'gallery' ? __('gallery') : $child->label }}</h3>
                                                            </a>
                                                            <ul class="global-list">
                                                                @foreach ($child->children as $subChild)
                                                                    <li>
                                                                        <a href="{{ menuUrl($subChild) }}" target="{{ $subChild->new_teb == 1 ? '_blank' : '' }}">
                                                                            {{ $subChild->label == 'gallery' ? __('gallery') : $subChild->label }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="container main-container">
    <div class="row">
        <div class="col-12">
            @if (session('error'))
                <div id="error_m" class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div id="success_m" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @isset($errors)
                @if ($errors->any())
                    <div class="alert alert-danger" id="error_m">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endisset
        </div>
    </div>
</div>

@include('site.partials.ads', ['ads' => $headerWidgets])
