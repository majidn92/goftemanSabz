@extends('common::layouts.master')
@section('settings')
    aria-expanded="true"
@endsection
@section('s-show')
    show
@endsection
@section('settings_active')
    active
@endsection
@section('setting-source')
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
            <div id="error_m" class="alert alert-danger" style="display: none"></div>
            <div id="success_m" class="alert alert-success" style="display: none"></div>


            <div class="row clearfix">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="add-new-page  bg-white p-0 m-b-20">

                                <nav>
                                    <div class="nav m-b-20 setting-tab" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link " id="themes-options-settings" href="{{ route('themes-options') }}" role="tab">تنظیمات ظاهری</a>
                                        <a class="nav-item nav-link" id="general-settings" href="{{ route('setting-general') }}" role="tab">{{ __('general_settings') }}</a>
                                        <a class="nav-item nav-link" id="contact-settings" href="{{ route('setting-company') }}" role="tab">{{ __('company_informations') }}</a>
                                        <a class="nav-item nav-link" id="mail-settings" href="{{ route('setting-email') }}" role="tab">{{ __('email_settings') }}</a>
                                        <a class="nav-item nav-link active" id="source-settings" href="{{ url('setting/sources') }}" role="tab">منابع خبری</a>
                                        <a class="nav-item nav-link" id="storage-settings" href="{{ route('setting-storage') }}" role="tab">{{ __('storage_settings') }}</a>
                                        <a class="nav-item nav-link" id="seo-settings" href="{{ route('setting-seo') }}" role="tab">{{ __('seo_settings') }}</a>
                                        <a class="nav-item nav-link" id="recaptcha-settings" href="{{ route('setting-recaptcha') }}" role="tab">{{ __('recaptcha_settings') }}</a>
                                        <a class="nav-item nav-link" id="setting-url" href="{{ route('settings-url') }}" role="tab">{{ __('url_settings') }}</a>
                                        <a class="nav-item nav-link" id="setting-ffmpeg" href="{{ route('settings-ffmpeg') }}" role="tab">{{ __('ffmpeg_settings') }}</a>
                                        <a class="nav-item nav-link" id="setting-custom" href="{{ route('setting-custom-header-footer') }}">{{ __('custom_header_footer') }}</a>
                                        <a class="nav-item nav-link" id="cron-information" href="{{ route('cron-information') }}">{{ __('cron_information') }}</a>
                                        <a class="nav-item nav-link" id="preference-control" href="{{ route('preferene-control') }}">{{ __('preference_setting') }}</a>
                                        <a class="nav-item nav-link" id="setting-social-login" href="{{ route('setting-social-login') }}">{{ __('social_login_settings') }}</a>
                                        <a class="nav-item nav-link" id="setting-config-cache" href="{{ route('cache') }}">{{ __('cache') }}</a>
                                        <a class="nav-item nav-link" id="update-database" href="{{ route('update-database') }}">{{ __('update') }}</a>
                                    </div>
                                </nav>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="tab-content mb-4">
                                    <!-- single tab content start -->
                                    <div class="tab-pane fade show active" id="recaptcha_settings" role="tabpanel">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="new-source" class="col-form-label">افزودن منبع خبری جدید</label>
                                                <input id="new-source" class="form-control" placeholder="نام منبع خبر را وارد نمائید">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <button id="add-source" class="btn btn-primary pull-right">
                                                <i class="m-l-10 mdi mdi-content-save-all"></i>
                                                {{ __('save') }}
                                            </button>
                                        </div>

                                    </div>
                                    <!-- single tab content end -->
                                </div>
                            </div>
                            @if ($sources->count())
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام منبع خبری</th>
                                            <th scope="col">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sources as $i => $source)
                                            <tr>
                                                <th scope="row">{{ $i + 1 }}</th>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $source->name }}">
                                                </td>
                                                <td>
                                                    <i class="fa fa-edit text-warning edit-source" style="cursor: pointer;font-size: 16px" title="ویرایش" data-id="{{ $source->id }}"></i>
                                                    <i class="fa fa-trash text-danger mr-2 delete-source" style="cursor: pointer;font-size: 16px" title="حذف" data-id="{{ $source->id }}"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-danger text-center" role="alert">
                                    منبع خبری یافت نشد
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--  tab end -->
                </div>
            </div>
            <!-- Main Content Section End -->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ static_asset('js/sweetalert.min.js') }}"></script>

    <script>
        $("#add-source").click(function() {
            let url = "{{ url('setting/sources/add') }}";
            let name = $("#new-source").val();
            let data = {
                "name": name,
            }

            $.ajax({
                type: "get",
                url: url,
                data: data,
                success: function(response) {
                    location.reload();
                    if (response == 'success') {
                        // $("#success_m").text('منبع خبری با موفقیت افزوده شد').slideDown(800).delay(3000).slideUp(800);
                    } else {
                        // $("#error_m").text('خطا در سیستم، دوباره تلاش نمائید').slideDown(800).delay(3000).slideUp(800);
                    }
                }
            });
        });


        $(".edit-source").click(function(e) {
            let id = $(this).data('id');
            let name = $(this).parents('tr').find('input').val();
            let data = {
                "id": id,
                "name": name,
                "_token": "{{ csrf_token() }}",
            }
            let url = "{{ url('setting/sources/edit') }}";
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    if (response == 'success') {
                        $("#success_m").text('منبع خبری با موفقیت ویرایش شد').slideDown(800).delay(3000).slideUp(800);
                    } else {
                        $("#error_m").text('خطا در سیستم، دوباره تلاش نمائید').slideDown(800).delay(3000).slideUp(800);
                    }
                }
            });
        });


        $(".delete-source").click(function(e) {
            let id = $(this).data('id');
            let tr = $(this).parents('tr');
            swal({
                    title: "{{ __('are_you_sure?') }}",
                    icon: "warning",
                    buttons: true,
                    buttons: ["{{ __('cancel') }}", "{{ __('delete') }}"],
                    dangerMode: true,
                    closeOnClickOutside: false
                })
                .then(function(confirmed) {
                    if (confirmed) {
                        let data = {
                            "id": id,
                            "_token": "{{ csrf_token() }}",
                        }
                        let url = "{{ url('setting/sources/delete') }}";
                        $.ajax({
                            type: "post",
                            url: url,
                            data: data,
                            success: function(response) {
                                if (response == 'success') {
                                    console.log();
                                    tr.remove();
                                    $("#success_m").text('منبع خبری با موفقیت حذف شد').slideDown(800).delay(3000).slideUp(800);
                                } else {
                                    $("#error_m").text('خطا در سیستم، دوباره تلاش نمائید').slideDown(800).delay(3000).slideUp(800);
                                }
                            }
                        });
                    }
                })
        });
    </script>
@endsection
