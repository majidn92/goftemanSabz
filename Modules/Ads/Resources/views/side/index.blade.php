@extends('common::layouts.master')
@section('ads-aria-expanded')
    aria-expanded="true"
@endsection
@section('ads-show')
    show
@endsection
@section('ads_side')
    active
@endsection
@section('ads')
    active
@endsection
@section('ads_active')
    active
@endsection

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid p-1 ">
            <!-- page info start-->
            <div class="admin-section">
                <div class="clearfix">
                    <div class="navigation-list bg-white p-20">
                        <div class="add-new-header clearfix m-b-20">
                            <div class="row">
                                <div class="col-6">
                                    <div class="block-header">
                                        <h2>تبلیغات نوار کناری</h2>
                                    </div>
                                </div>
                                @if (Sentinel::getUser()->hasAccess(['ads_write']))
                                    <div class="col-6 text-left">
                                        <a href="{{ route('side.create-ad') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                            {{ __('create_ad') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive all-pages">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>{{ __('ad_image') }}</th>
                                        <th>جایگاه نمایش</th>
                                        <th>{{ __('ad_url') }}</th>
                                        <th>زمان نمایش</th>
                                        @if (Sentinel::getUser()->hasAccess(['ads_write']) || Sentinel::getUser()->hasAccess(['ads_delete']))
                                            <th>{{ __('options') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ads as $i=>$ad)
                                        <tr role="row" id="row_{{ $ad->id }}" class="odd">
                                            <td class="sorting_1">{{ $i+1 }}</td>
                                            <td>
                                                @if ($ad->path)
                                                    <img src="{{ url($ad->path) }}" width="64" height="64" alt="image" class="img-responsive img-thumbnail">
                                                @else
                                                    <img src="{{ static_asset('default-image/default-100x100.png') }} " id="image_preview" width="64" height="64" alt="image" class="img-responsive img-thumbnail">
                                                @endif
                                            </td>
                                            <td> {{ $ad->rank }} </td>
                                            <td>{{ $ad->url }}</td>
                                            @if ($ad->set_date)
                                            <td>{{ miladi_to_jalali($ad->start_date, true) }} لغایت {{ miladi_to_jalali($ad->end_date, true) }}</td>
                                            @else
                                            <td>بدون محدودیت زمانی</td>
                                            @endif

                                            @if (Sentinel::getUser()->hasAccess(['ads_write']) || Sentinel::getUser()->hasAccess(['ads_delete']))
                                                <td>
                                                    @if (Sentinel::getUser()->hasAccess(['ads_write']))
                                                        <a class="btn btn-light active btn-xs" href="{{ route('side.edit-ad', ['id' => $ad->id]) }}"><i class="fa fa-edit"></i>
                                                            {{ __('edit') }}
                                                        </a>
                                                    @endif
                                                    @if (Sentinel::getUser()->hasAccess(['ads_delete']))
                                                        <a href="javascript:void(0)" class="btn btn-light active btn-xs" onclick="delete_item('side_ads','{{ $ad->id }}')"><i class="fa fa-trash"></i>
                                                            {{ __('delete') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="block-header">
                                    <h2>{{ __('showing') }} {{ $ads->firstItem() }} {{ __('to') }} {{ $ads->lastItem() }} {{ __('of') }} {{ $ads->total() }} {{ __('entries') }}</h2>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 text-right">
                                <div class="table-info-pagination float-right">
                                    {!! $ads->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>
@endsection
