@extends('admin.layouts.base')

@section('content')
    <div class="container">
        <h1 class="mb-3">Modifica {{ $post->title }}</h1>
        {{-- metodo POST e azione sullo store --}}
        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}">
    
            {{-- token sicurezza --}}
            @csrf

            {{-- method put --}}
            @method('PUT')
    
            {{-- titolo --}}
            {{-- Le old anche il value di base --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
            </div>
            {{-- contenuto --}}
            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Inserisci il post qui" id="content" name="content" cols="50" rows="10">{{ old('content', $post->content) }}</textarea>
                    <label for="content">Post</label>
                </div>
            </div>

            {{-- select category --}}
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select class="form-select mb-3" name="category_id" id="category_id">
                    <option value="">Seleziona la categoria</option>
                    @foreach ($categories as $category)
                        <option {{(old('category_id', $post->category_id) == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
    
            {{-- bottone submit --}}
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection