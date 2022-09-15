<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Zapato con tacon',
            'price' => 10.00,
            'image' => 'https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/mg/gm/3pp/asr/804e5626-a480-4edd-bcda-05bd6a58c993.a4ab541589b6d8b44af0972328603988.jpeg?odnHeight=2000&odnWidth=2000&odnBg=ffffff',
            'description' => 'Zapato de tacon hecho de piel de vaca',
        ]);
    }
}
