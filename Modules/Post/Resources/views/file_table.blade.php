<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">افزودن فایل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $files = DB::table('files')
                        ->get()
                        ->SortByDesc('id');
                @endphp
                <div class="row">
                    <div class="col-sm-12">
                        <h3>لیست فایل ها</h3>
                        @if ($files->count())
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام فایل</th>
                                        <th scope="col">نوع فایل</th>
                                        <th scope="col">لینک دانلود</th>
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
                                                <button class="btn btn-info btn-sm url" data-url="{{ $file->url }}">کپی لینک</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger" role="alert">
                                فایلی جهت نمایش وجود ندارد
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>

