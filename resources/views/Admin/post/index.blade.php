@extends('admin.layouts.base')

@section('content')

    {{-- eliminazione con successo --}}
    @if (session('delete'))
      <div class="alert alert-danger">
        {{ session('delete') }}
      </div>
    @endif

    <div class="container">
        <h1 class="text-center mb-5">Tabella dei post </h1>

        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary mb-2">Aggiungi nuovo post</a>

        {{-- tabella --}}
        <table class="table">
            {{-- tabella head --}}
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Contenuto</th>
                <th scope="col">Slug</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tags</th>
                <th scope="col">Azioni</th>
              </tr>
            </thead>
            {{-- tabella body --}}
            <tbody>
                {{-- ciclo i posts per ognuno creo riga tabella --}}
              @foreach ($posts as $post )
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    {{-- il contenuto mostro solo i primi 30 caratteri usando la funzione substr di php --}}
                    <td>{{ substr($post->content, 0, 30) }}</td>
                    <td>{{ $post->slug }}</td>
                    {{-- laravel sa già a cosa riferirsi, gestisco con operatore caso null --}}
                    <td>{{  ($post->category) ? $post->category->name : 'Nessuna categoria definita!' }}</td>
                    <td>
                      @foreach ($post->tags as $tag)
                        <span class="badge rounded-pill bg-primary">{{ $tag->name }}</span>  
                      @endforeach
                    </td>
                    <td class="d-flex gap-1">
                      {{-- show --}}
                      <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-success">Vedi</a>
                      {{-- edit --}}
                      <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">Modifica</a>
                      {{-- destroy --}}
                      <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                        
                        {{-- token sicurezza --}}
                        @csrf

                        {{-- metodo delete --}}
                        @method('DELETE')

                        <button class="btn btn-danger">Elimina</button>
                      
                      </form>

                    </td>
                </tr>
              @endforeach  
            </tbody>
        </table>
    </div>
@endsection