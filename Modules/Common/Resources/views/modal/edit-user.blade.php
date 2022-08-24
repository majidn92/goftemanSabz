@php
$user = Modules\User\Entities\User::find($param[0]);
@endphp

{!! Form::open(['route' => ['update-user-info', $param[0]], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">

    <div class="form-group">
        <label for="first_name" class="col-form-label">{{ __('first_name') }}</label>
        <input id="first_name" name="first_name" value="{{ $user->first_name }}" type="text" class="form-control">
    </div>
    @if ($user->hoghooghi == 0)
        <div class="form-group">
            <label for="last_name" class="col-form-label">{{ __('last_name') }}</label>
            <input id="last_name" name="last_name" value="{{ $user->last_name }}" type="text" class="form-control">
        </div>
    @endif
    <div class="form-group">
        <label for="phone" class="col-form-label">{{ __('phone') }}</label>
        <input id="phone" name="phone" value="{{ $user->phone }}" type="text" class="form-control">
    </div>
    {{-- <div class="form-group">
        <label for="dob" class="col-form-label">{{ __('dob') }}</label>
        <input id="dob" name="dob" value="{{ $user->dob }}" type="text" class="form-control example1">
    </div> --}}
    <div class="form-group">
        <label for="is_featured">ویژه</label>
        <input id="is_featured" name="is_featured" type="checkbox" @if ($user->is_featured) checked @endif style="transform: scale(1.5);margin-right: 8px;">
    </div>
    <div id="order_box" class="form-group col-4" @if($user->is_featured == 0) style='display:none'  @endif>
        <label for="featured_order" class="col-form-label">جایگاه نمایش</label>
        <input id="featured_order" name="featured_order" value="{{ $user->featured_order }}" type="number" class="form-control" min="1">
    </div>
    <div class="form-group">
        <label for="profile_image" class="upload-file-btn btn btn-primary"><i class="fa fa-folder input-file" aria-hidden="true"></i> {{ __('select_image') }}</label>
        <input id="profile_image" name="profile_image" onChange="swapImage(this)" data-index="0" type="file" class="form-control d-none" accept="image/*">
    </div>
    <div class="form-group text-center">
        @if (profile_exist($user->profile_image) && $user->profile_image != null)
            <img src="{{ static_asset($user->profile_image) }}" data-index="0" height="200" width="200" alt="img">
        @else
            <img src="{{ static_asset('default-image/user.jpg') }}" height="200" width="200" data-index="0" alt="user" class="img-responsive ">
        @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="m-l-10 fas fa-window-close"></i>{{ __('close') }}</button>
    <button type="submit" class="btn btn-primary"><i class="m-l-10 mdi mdi-content-save-all"></i>{{ __('save') }}</button>
</div>
{{ Form::close() }}
