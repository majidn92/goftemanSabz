<div class="modal fade" id="change_author" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تغییر نویسنده خبر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_change_author" action="{{url('post/change-author')}}" method="post">
                    @csrf
                    <input type="hidden" name="post_id">
                    <div class="form-group">
                        @php
                            $users = Sentinel::getUserRepository()->get();
                        @endphp
                        <select name="author_id" class="form-control">
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}} ({{__($user->roles->first()->name)}})</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="submit" class="btn btn-primary" form="form_change_author">ذخیره</button>
            </div>
        </div>
    </div>
</div>
