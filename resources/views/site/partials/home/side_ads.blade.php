<style>
    img {
        height: unset;
    }
</style>
@foreach ($side_ads as $item)
<div class="mb-1">
    <a href="{{ $item->url }}">
        <img src="{{ url($item->path) }}" class="ads-img" style="height: 100px;width:100%">
    </a>
</div>
@endforeach