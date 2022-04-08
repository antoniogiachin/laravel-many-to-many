@extends('admin.layouts.base')

@section('content')
    <div class="container px-5">
        <h1 class="mb-3">Inserisci un nuovo post</h1>
        {{-- metodo POST e azione sullo store --}}
        <form method="POST" action="{{ route('admin.posts.store') }}">
    
            {{-- token sicurezza --}}
            @csrf
    
            {{-- titolo --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
            {{-- contenuto --}}
            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Inserisci il post qui" id="content" name="content" cols="50" rows="10">{{ old('content') }}</textarea>
                    <label for="content">Post</label>
                </div>
            </div>

            {{-- select per categoria, al controller ho passato tutte le categorie in variabile $categories, ciclo for per stampare la select--}}
            {{-- name e id category_id, ossia foreign_key --}}
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select class="form-select mb-3" name="category_id" id="category_id">
                    <option value="">Seleziona la categoria</option>
                    @foreach ($categories as $category)
                        <option {{old('category_id') == $category->id ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
    
            {{-- bottone submit --}}
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection