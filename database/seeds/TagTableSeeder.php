<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Vegetariano', 'Vegano', 'Senza Lattosio', 'Senza Glutine', 'Carne', 'Pesce', 'Fit'];

        foreach($tags as $tag){
            $newTag = new Tag();
            $newTag->name = $tag;
            $newTag->slug= Str::slug($tag);
            $newTag->save();
        }
    }
}
