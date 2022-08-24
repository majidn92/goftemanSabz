<form action="{{ url('test-upload') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">send</button>
</form>
