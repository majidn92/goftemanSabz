@extends('common::layouts.master')

@section('files')
    active
@endsection

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            <div class="row clearfix">
                <div class="col-12">
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
                        <!-- Main Content section start -->
                        <div class="col-12">
                            <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="add-new-page  bg-white p-20 m-b-20">
                                    <div class="add-new-header clearfix m-b-20">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="block-header">
                                                    <h2>???????????? ????????</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="file" class="upload-file-btn btn btn-primary">
                                                    <i class="fa fa-folder input-file" aria-hidden="true"></i> ???????????? ????????
                                                </label>
                                                <input id="file" name="file" type="file" style="display: none">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 m-t-20">
                                            <div class="form-group form-float form-group-sm text-right">
                                                <button type="submit" name="btnsubmit" class="btn btn-primary"><i class="m-l-10 fa fa-save"></i>??????????</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- {!! Form::close() !!} --}}

                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>???????? ???????? ????</h3>
                                    @if ($files->count())
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">?????? ????????</th>
                                                    <th scope="col">?????? ????????</th>
                                                    <th scope="col">???????? ????????????</th>
                                                    <th scope="col">????????????</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($files as $file)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $file->name }}</td>
                                                        <td>{{ $file->ext }}</td>
                                                        <td>
                                                            {{ $file->url }}
                                                            <button class="btn btn-info btn-sm url" data-url="{{ $file->url }}">?????? ????????</button>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url("gallery/files/delete/$file->id") }}"><i class="fa fa-trash btn btn-danger"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            ?????????? ?????? ?????????? ???????? ??????????
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Main Content section end -->

                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".url").click(function(e) {
            var url = $(this).data('url');
            node = $(this);

            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).html('?????? ????');
            $(this).removeClass('btn-info');
            $(this).addClass('btn-success');
            $(this).css("cursor", "auto");
            
            setTimeout(function() {
                node.html('?????? ????????');
                node.removeClass('btn-success');
                node.addClass('btn-info');
                node.css("cursor", "pointer");
            }, 3000);

        });
    </script>
@endsection
