@extends('admin.layouts.base')

@section('content')

    {{-- eliminazione con successo --}}
    @if (session('delete'))
      <div class="alert alert-danger">
        {{ session('delete') }}
      </div>
    @endif

    <div class="container">
        <h1 class="text-center mb-5">Tabella dei tag </h1>

        {{-- tabella --}}
        <table class="table">
            {{-- tabella head --}}
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Slug</th>
                <th scope="col">Azioni</th>
              </tr>
            </thead>
            {{-- tabella body --}}
            <tbody>
                {{-- ciclo i posts per ognuno creo riga tabella --}}
              @foreach ($tags as $tag )
                <tr>
                    <th scope="row">{{ $tag->id }}</th>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td class="d-flex gap-1">
                      {{-- show --}}
                      <a href="{{ route('admin.tag.show', $tag->id) }}" class="btn btn-success">Vedi</a>
                    </td>  
                </tr>
              @endforeach  
            </tbody>
        </table>
    </div>
@endsection