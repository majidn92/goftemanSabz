@extends('common::layouts.master')

@section('section-aria-expanded')
    aria-expanded=true
@endsection
@section('footer_menu_item')
    active
@endsection
@section('section-show')
    show
@endsection
@section('section')
    active
@endsection

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <div class="admin-section">
                <div class="row clearfix m-t-30">
                    <div class="col-12">
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
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
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="block-header col-6">
                                        <h2>لیست آیتم های منوی فوتر</h2>
                                    </div>
                                    <div class="col-6 text-left">
                                        <a href="#" id="new-menu-item" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create-menu-footer"><i class="m-l-10 fa fa-th-list"></i>افزودن آیتم جدید</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive all-pages">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>نام لینک</th>
                                            <th>مسیر لینک</th>
                                            <th>جایگاه نمایش</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $i => $item)
                                            <tr role="row" id="row_{{ $item->id }}" class="odd">
                                                <td class="sorting_1">{{ $i + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->url }}</td>
                                                <td>{{ $item->rank }}</td>
                                                <td>
                                                    <span class="fa fa-edit btn btn-warning edit-menu-btn" data-id="{{ $item->id }}" title="ویرایش"></span>
                                                    <span class="fa fa-trash btn btn-danger mr-2 delete-menu-btn" onclick="footer_menu_delete({{ $item->id }})" title="حذف"></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="block-header">
                                        <h2>{{ __('showing') }} {{ $items->firstItem() }} {{ __('to') }} {{ $items->lastItem() }} {{ __('of') }} {{ $items->total() }} {{ __('entries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $items->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- پاپ اپ ایجاد منوی فوتر --}}
    <div class="modal fade" id="modal-create-menu-footer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ایجاد منوی جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-create-menu-footer-form" class="row" action="{{ url('footer-menu-store') }}" method="post">
                        @csrf
                        <div class="form-group col-sm-4">
                            <label for="recipient-name" class="col-form-label">نام</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="recipient-name" class="col-form-label">لینک</label>
                            <input type="text" name="url" class="form-control">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="recipient-name" class="col-form-label">جایگاه نمایش</label>
                            <input type="text" name="rank" class="form-control" min="1">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                        <button type="submit" form="modal-create-menu-footer-form" class="btn btn-primary">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- پاپ اپ ویرایش منوی فوتر --}}
    <div class="modal fade" id="modal-edit-menu-footer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش منوی فوتر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-edit-menu-footer-form" class="row" action="{{ url('footer-menu-update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label">نام</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group col-sm-5">
                            <label class="col-form-label">لینک</label>
                            <input name="url" type="text" class="form-control">
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label">جایگاه نمایش</label>
                            <input name="rank" type="text" class="form-control" min="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                    <button type="submit" form="modal-edit-menu-footer-form" class="btn btn-primary">ذخیره</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".edit-menu-btn").click(function(e) {
            e.preventDefault();
            $('#modal-edit-menu-footer').modal('show');
            parent_tag = $(this).parents('tr');
            id = $(this).data('id');
            name = parent_tag.children().eq(1).html();
            url = parent_tag.children().eq(2).html();
            rank = parent_tag.children().eq(3).html();
            modal = $("#modal-edit-menu-footer");
            modal.find("input[name='id']").val(id);
            modal.find("input[name='name']").val(name);
            modal.find("input[name='url']").val(url);
            modal.find("input[name='rank']").val(rank);
        });
    </script>

    <script>
        function footer_menu_delete(id) {
            swal({
                title: "{{ __('are_you_sure?') }}",
                text: "{{ __('it_will_be_deleted_permanently') }}",
                icon: "warning",
                buttons: true,
                buttons: ["{{ __('cancel') }}", "{{ __('delete') }}"],
                dangerMode: true,
                closeOnClickOutside: false
            }).then(function(confirmed) {
                if (confirmed) {
                    $.ajax({
                            url: "{{url('footer-menu-delete')}}",
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id : id
                            }
                        })
                        .done(function(response) {
                            swal.stopLoading();
                            if (response.status == "success") {
                                swal("{{ __('deleted') }}!", response.message, response.status);
                                location.reload();
                            } else {
                                swal("خطا", response.message, response.status);
                            }
                        })
                        .fail(function() {
                            swal('خطا', '{{ __('something_went_wrong_with_ajax') }}', 'error');
                        })
                }
            })
        }
    </script>
@endsection
