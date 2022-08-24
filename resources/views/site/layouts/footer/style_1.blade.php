<style>
    .nav li a i {
        transition: .4s;
    }

    .nav li a i:hover {
        color: var(--primary-color);
        transform: translateY(-5px);
    }

    .footer-top {
        background-color: var(--primary-color);
    }
</style>

<div class="footer footer-style-1" style="padding-bottom: 40px">
    <div class="footer-bottom">
        <div class="row">
            <div class="col-sm-3">
                <div style="max-width: 150px">
                    <a href="{{url('/')}}">
                        <img src="{{ static_asset(settingHelper('logo')) }}" alt="" style="aspect-ratio:unset !important">
                    </a>
                </div>
            </div>
            <div class="col-sm-6" style="display: flex;align-items: center;justify-content: center">
                <div>
                    <div class="col-sm-12 mb-2">
                        <ul id="footer-menu-box" class="nav text-center" style="justify-content: center">
                            @php
                                $footer_menu_items = \DB::table('footer_menu_items')
                                    ->orderBy('rank')
                                    ->get();
                            @endphp
                            <li style="margin-right: unset;margin-left: 6px;padding-left: 6px;border-left: solid 1px white">
                                <a href="{{ url('/') }}" target="_blank">
                                    صفحه اصلی
                                </a>
                            </li>
                            @foreach ($footer_menu_items as $footer_menu_item)
                                <li style="margin-right: unset;margin-left: 6px;padding-left: 6px;border-left: solid 1px white">
                                    <a href="{{ url('page/' . $footer_menu_item->url) }}" target="_blank">
                                        {{ $footer_menu_item->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-12">
                        <ul class="nav text-center" style="justify-content: center">
                            @foreach ($socialMedias as $socialMedia)
                                <li>
                                    <a href="{{ $socialMedia->url }}" target="_blank" name="{{ $socialMedia->name }}">
                                        <i class="{{ $socialMedia->icon }}" aria-hidden="true" style="font-size: 25px"></i>
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ url('feed') }}" name="{{ __('feed') }}">
                                    <i class="fa fa-rss" aria-hidden="true" style="font-size: 25px"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-12" style="font-size: 13px;text-align: center">
                        {{ settingHelper('copyright_text') }}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

            </div>
        </div>
    </div>
</div><!-- /.footer -->
