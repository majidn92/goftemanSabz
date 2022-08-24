@extends('common::layouts.master')

@section('post-aria-expanded')
    aria-expanded="true"
@endsection
@section('post-show')
    show
@endsection
@section('post')
    active
@endsection
@section('rss')
    active
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- page info start-->
            <div class="admin-section">
                <div class="row clearfix m-t-30">
                    <div class="col-12">
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="block-header">
                                            <h2>{{ __('RSS') }}</h2>
                                        </div>
                                    </div>
                                    @if (Sentinel::getUser()->hasAccess(['rss_write']))
                                        <div class="col-sm-6 text-left">
                                            <a href="{{ route('import-rss') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                افزودن منبع RSS
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive all-pages">
                                <!-- Table Filter -->
                                <div class="row table-filter-container m-b-20">
                                    <div class="col-sm-12">
                                        {!! Form::open(['route' => 'filter-rss', 'method' => 'GET']) !!}
                                        <div class="item-table-filter">
                                            <p class="text-muted"><small>{{ __('language') }}</small></p>
                                            <select class="form-control" name="language">
                                                <option value="">{{ __('all') }}</option>
                                                @foreach ($activeLang as $lang)
                                                    <option value="{{ $lang->code }}">{{ $lang->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="item-table-filter">
                                            <p class="text-muted"><small>{{ __('search') }}</small></p>
                                            <input name="search_key" class="form-control" placeholder="{{ __('search') }}" type="search" value="">
                                        </div>

                                        <div class="item-table-filter md-top-10 item-table-style">
                                            <button type="submit" class="btn bg-primary" style="margin-top: 23px">{{ __('filter') }}</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <!-- Table Filter -->
                                <table class="table table-bordered table-striped" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>نام RSS</th>
                                            <th>لینک RSS</th>
                                            <th>بخش یا صنعت</th>
                                            <th>{{ __('category') }}</th>
                                            <th>تعداد اخبار ورودی</th>
                                            <th>{{ __('auto_update') }}</th>
                                            <th></th>
                                            <th>{{ __('added_date') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['rss_write']) || Sentinel::getUser()->hasAccess(['rss_delete']))
                                                <th>{{ __('options') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feeds as $key => $feed)
                                            {{-- {{ dd($feeds[0]->section) }} --}}
                                            <tr id="row_{{ $feed->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $feed->name }}</td>
                                                <td style="max-width: 300px;overflow: auto;">{{ $feed->feed_url }}</td>
                                                <td>
                                                    @foreach ($feed->section as $item)
                                                        <label class="label bg-info label-table">{{ $item->name }}</label>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($feed->category as $item)
                                                        <label class="category-label m-r-5 label-table" id="breaking-post-bgc">
                                                            {{ $item->category_name }}
                                                        </label>
                                                    @endforeach
                                                </td>
                                                <td>{{ $feed->post_limit }}</td>
                                                <td class="justify-content-between">
                                                    @if ($feed->auto_update)
                                                        {{ __('yes') }}
                                                    @else
                                                        {{ __('no') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('manually-feeding', ['id' => $feed->id]) }}" class="btn btn-primary btn-sm btn-add-new"><i class="fa fa-refresh"></i>
                                                        {{ __('update') }}
                                                    </a>

                                                </td>
                                                <td>{{ miladi_to_jalali($feed->created_at, true) }}</td>
                                                @if (Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">
                                                                @if (Sentinel::getUser()->hasAccess(['rss_write']))
                                                                    <li>
                                                                        <a href="{{ route('edit-rss', ['id' => $feed->id]) }}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (Sentinel::getUser()->hasAccess(['rss_delete']))
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="delete_item('rss_feeds','{{ $feed->id }}')"><i class="fa fa-trash option-icon"></i>{{ __('delete') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
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
                                        <h2>{{ __('showing') }} {{ $feeds->firstItem() }} {{ __('to') }} {{ $feeds->lastItem() }} {{ __('of') }} {{ $feeds->total() }} {{ __('entries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $feeds->render() !!}
                                    </div>
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
@section('script')
    <script>
        $(document).ready(function() {

            $('.dynamic').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('subcategory-fetch') }}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            _token: _token
                        },
                        success: function(result) {
                            $('#' + dependent).html(result);
                        }

                    })
                }
            });

            $('#category').change(function() {
                $('#sub_category').val('');
            });


        });
    </script>
@endsection
