@if ($gallery_images->count())
    <section style="background: {{ $section->color }};margin: 0;padding: 15px">
        <div style="width: 90%;margin: auto">
            <h2 class="section-title text-light">{{ $section->name }}</h2>
            <div class="section-box" style="border-top-color: white">
                <div class="row">
                    @if (!empty($gallery_images[0]))
                        <div class="col-sm-6 text-center">
                            <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                <img src="{{ static_asset($gallery_images[0]->original_image) }}" data-caption="{{ $gallery_images[0]->title }}" class="lightboxed" rel="img-{{ $gallery_images[0]->id }}" alt="" width="100%">
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($gallery_images[0]->title, 190) !!}
                                </div>
                            </div>
                            @foreach ($gallery_images[0]->gallery_images as $image)
                                <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $gallery_images[0]->title }}" class="lightboxed" rel="img-{{ $gallery_images[0]->id }}" style="display: none">
                            @endforeach
                            <span class="count-img" style="left: 25px">
                                <span class="mr-1">{{ $gallery_images[0]->gallery_images->count() }}</span>
                                <i class="fa fa-camera"></i>
                            </span>
                        </div>
                    @endif
                    @if (!empty($gallery_images[1]))
                        <div class="col-sm-6 text-center">
                            <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                <img src="{{ static_asset($gallery_images[1]->original_image) }}" data-caption="{{ $gallery_images[1]->title }}" class="lightboxed" rel="img-{{ $gallery_images[1]->id }}" alt="" width="100%">
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($gallery_images[1]->title, 190) !!}
                                </div>
                            </div>
                            @foreach ($gallery_images[1]->gallery_images as $image)
                                <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $image->title }}" class="lightboxed" rel="img-{{ $gallery_images[1]->id }}" style="display: none">
                            @endforeach
                            <span class="count-img" style="left: 25px">
                                <span class="mr-1">{{ $gallery_images[1]->gallery_images->count() }}</span>
                                <i class="fa fa-camera"></i>
                            </span>
                        </div>
                    @endif
                    @if (!empty($gallery_images[2]))
                        <div class="col-sm-4">
                            <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                <img src="{{ static_asset($gallery_images[2]->original_image) }}" data-caption="{{ $gallery_images[2]->title }}" class="lightboxed" rel="img-{{ $gallery_images[2]->id }}" alt="" width="100%">
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($gallery_images[2]->title, 100) !!}
                                </div>
                            </div>
                            @foreach ($gallery_images[2]->gallery_images as $image)
                                <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $image->title }}" class="lightboxed" rel="img-{{ $gallery_images[2]->id }}" style="display: none">
                            @endforeach
                            <span class="count-img" style="left: 25px">
                                <span class="mr-1">{{ $gallery_images[2]->gallery_images->count() }}</span>
                                <i class="fa fa-camera"></i>
                            </span>
                        </div>
                    @endif
                    @if (!empty($gallery_images[3]))
                        <div class="col-sm-4">
                            <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                <img src="{{ static_asset($gallery_images[3]->original_image) }}" data-caption="{{ $gallery_images[3]->title }}" class="lightboxed" rel="img-{{ $gallery_images[3]->id }}" alt="" width="100%">
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($gallery_images[3]->title, 100) !!}
                                </div>
                            </div>
                            @foreach ($gallery_images[3]->gallery_images as $image)
                                <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $image->title }}" class="lightboxed" rel="img-{{ $gallery_images[3]->id }}" style="display: none">
                            @endforeach
                            <span class="count-img" style="left: 25px">
                                <span class="mr-1">{{ $gallery_images[3]->gallery_images->count() }}</span>
                                <i class="fa fa-camera"></i>
                            </span>
                        </div>
                    @endif
                    @if (!empty($gallery_images[4]))
                        <div class="col-sm-4">
                            <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                <img src="{{ static_asset($gallery_images[4]->original_image) }}" data-caption="{{ $gallery_images[4]->title }}" class="lightboxed" rel="img-{{ $gallery_images[4]->id }}" alt="" width="100%">
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($gallery_images[4]->title, 100) !!}
                                </div>
                            </div>
                            @foreach ($gallery_images[4]->gallery_images as $image)
                                <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $image->title }}" class="lightboxed" rel="img-{{ $gallery_images[4]->id }}" style="display: none">
                            @endforeach
                            <span class="count-img" style="left: 25px">
                                <span class="mr-1">{{ $gallery_images[4]->gallery_images->count() }}</span>
                                <i class="fa fa-camera"></i>
                            </span>
                        </div>
                    @endif
                </div>
                <div style="display: flex;justify-content: flex-end">
                    <a href="{{ url('albums') }}" target="_blank" class="show-more-btn float-left" style="font-size: 14px">نمایش بیشتر</a>
                </div>
            </div>
        </div>
    </section>
@endif
