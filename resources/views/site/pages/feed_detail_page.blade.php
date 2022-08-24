@extends('site.layouts.app')
@php
    // dd($post->read_more_link)
@endphp
@section('content')
    <iframe src="{{ $post->read_more_link }}" frameborder="0" style="height: 100vh">
        
    </iframe>
@endsection
