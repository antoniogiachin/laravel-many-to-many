@extends('admin.layouts.base')

@section('content')
    <div class="container">
        <h1 class="text-center">Ecco il post: {{ $post->title }}</h1>
        <p> <strong>Categoria: </strong>{{ ($post->category) ? $post->category->name : 'Nessuna categoria definita!'}} </p>
        <p> <strong>Slug:</strong>  {{ $post->slug }}</p>
        <p> <strong>Contenuto:</strong> {{ $post->content }}</p>
        <ul>
            <h4>Tags</h4>
            @foreach ($post->tags as $tag)
                <li>
                    <span class="badge rounded-pill bg-primary">{{ $tag->name }}</span>    
                </li>
            @endforeach
        </ul>
        <div class="d-flex justify-content-center">
            <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">Torna ai Post</a>
        </div>
    </div>

@endsection 