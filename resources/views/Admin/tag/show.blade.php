@extends('admin.layouts.base')

@section('content')
    <div class="container">
        <h1 class="text-center">Ecco il tag: {{ $tag->title }}</h1>
        <p> <strong>Slug:</strong>  {{ $tag->slug }}</p>
        <ul>
            <h4>Articoli correlati</h4>
            @foreach ($tag->posts as $post)
                <li>
                    <a href="{{ route('admin.posts.show', $post->id) }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
        <div class="d-flex justify-content-center">
            <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">Torna ai Post</a>
        </div>
    </div>

@endsection 