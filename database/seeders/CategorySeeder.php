<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;




class CategorySeeder extends Seeder
{


    public $category = ['Electronics', 'Life_Style', 'Decoration', 'Kitchen', 'Footwear', 'Automotive'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->category as $key => $value) {
            // print_r($this->product[$key]['images']) . "<br>";
            DB::table('categories')->insert([
                'category_Name' => $value
            ]);
        }
    }
}
