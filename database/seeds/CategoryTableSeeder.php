<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //array con tutte le categorie
        $categories = ['Antipasti', 'Primi', 'Secondi', 'Contorni', 'Dolci'];
        //ciclo array e per ognuno creo una istanza di gategory
        foreach($categories as $category){
            $newCategory = new Category();
            $newCategory->name = $category;
            $newCategory->slug = Str::slug($category);
            $newCategory->save();
        }

    }
}
