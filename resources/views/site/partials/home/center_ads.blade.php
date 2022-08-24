<div class="mt-3 top-center-ad">
    <h4 style="color: {{ $color }};font-size:20px;font-weight:bold">وب گردی</h4>
    <div style="padding-top: 15px;border-top: solid {{ $color }};border-radius: 5px">
        <div class="center-ads" dir="rtl">
            @foreach ($center_ads as $center_ads)
            <a href="{{ $center_ads->url }}">
                <img src="{{ url($center_ads->path) }}" alt="">
            </a>
            @endforeach
        </div>
    </div>
</div>
