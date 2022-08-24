@php
$footerWidgets = data_get($widgets, \Modules\Widget\Enums\WidgetLocation::FOOTER, []);
@endphp

@include('site.partials.ads', ['ads' => $footerWidgets])

@if (data_get(activeTheme(), 'options.footer_style') == 'footer_1')
    @include('site.layouts.footer.style_1', ['footerWidgets' => $footerWidgets])
@elseif(data_get(activeTheme(), 'options.footer_style') == 'footer_2')
    @include('site.layouts.footer.style_2', ['footerWidgets' => $footerWidgets])
@elseif(data_get(activeTheme(), 'options.footer_style') == 'footer_3')
    @include('site.layouts.footer.style_3', ['footerWidgets' => $footerWidgets])
@endif

{{-- اخبار فوری --}}
@php
$breaking_posts = \Modules\Post\Entities\Post::where('status', 1)
    ->where('visibility', 1)
    ->where('breaking', 1)
    ->orderBy('breaking_order', 'asc')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();
@endphp

<div style="position: fixed;z-index:1;bottom:0;width: 100%;height:40px;background: var(--primary-color);padding: 10px 5px;margin-top: 10px;line-height: 15px">
    <ul id="footer-ticker" dir="rtl">
        @foreach ($breaking_posts as $item)
            <li style="margin-left: 5px;display: inline-block">
                <a href="{{ route('article.detail', [$item->slug]) }}" class="main-title" style="color: white;font-weight: unset">
                    {{ $item->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
