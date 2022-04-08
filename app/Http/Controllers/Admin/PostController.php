<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
//per usare funzione per lo slug
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //preleva i dati sui post
        $posts = Post::all();

        // passa dati alla vista
        return view('Admin.post.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //prelevo le categorie
        $categories = Category::all();

        //prelevo i tag
        $tags = Tag::all();

        return view('Admin.post.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        //validazioni
        $request->validate(

            [
                "title" => 'required|min:2',
                "content"=> 'required|min:10',
                // accetto category_id se  esiste nella tabella categories alla colonna id
                "category_id"=>'nullable|exists:categories,id',
                // array ricevuto deve contenere valori nullable e presenti nella tabella tags alla colonna id
                "tagsId" => 'nullable|exists:tags,id',
            ]

        );

        // prelevo dati dal form
        $data = $request->all();

        //definisco lo slug - funzione laravel di STR (in alto: use Illuminate\Support\Str;)
        $slug = Str::slug($data['title']);

        //definisco funzione che fa si che lo slug non sia lo stesso se due titoli sono simili
        //imposto un counter, poi ciclo while: query sugli slug di post se trova corrispondenza fa un append allo slug del contatore, incrementa il contatore. Se non trova corrispondenza esce dal ciclo while.
        $counter = 1;

        //potrei togliere "=" e sarebbe comunque un operatore di uguaglianza
        while(Post::where('slug', '=',  $slug)->first()){
            
            $slug = Str::slug($data['title']) . '-' . $counter;
            $counter++;

        }

        // inserisco lo slug dentro data
        $data['slug'] = $slug;

        //fill su post
        $post->fill($data);
        // salvo
        $post->save();

        $post->tags()->sync($data['tagsId']);


        //decido il redirect
        return redirect()->route('admin.posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view ('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //prelevo le categorie dal db
        $categories = Category::all();

        //recupero e passo i tags
        $tags = Tag::all();

        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // inserisco validazioni
        $request->validate(
            [
                "title" => 'required|min:2',
                "content"=> 'required|min:10',
                "category_id"=>'nullable|exists:categories,id',
                "tagsId" => 'nullable|exists:tags,id',
            ]
        );
        //salvo in data il contenuto form
        $data = $request->all();

        //gestisco lo slug
        $slug = Str::slug($data['title']);

        //qualora lo slug sia diverso da quello originale del post allora eseguo il ciclo while come per store
        if($post->slug != $slug){
            $counter =1;
            while(Post::where('slug', $slug)->first()){
                $slug = Str::slug($data['title']) . "-". $counter;
                $counter++;
            };
            $data['slug']=$slug;
        }

        $post->fill($data);
        $post->save();

        //sync-> richiamo public function post sync con id dei tag presenti con lo store dentro $data
        $post->tags()->sync($data['tagsId']);

        return redirect()-> route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('delete', 'Eliminazione avvenuta con successo!');
    }
}
