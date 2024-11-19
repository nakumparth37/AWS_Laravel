<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;




class SubcategorySeeder  extends Seeder
{


    public $sub_category = [
        ['Sub_category_Name' => 'smartphones', 'category_id' => 1],
        ['Sub_category_Name' => 'laptops', 'category_id' => 1],
        ['Sub_category_Name' => 'fragrances', 'category_id' => 2],
        ['Sub_category_Name' => 'skincare', 'category_id' => 2],
        ['Sub_category_Name' => 'groceries', 'category_id' => 2],
        ['Sub_category_Name' => 'home-decoration', 'category_id' => 3],
        ['Sub_category_Name' => 'tops', 'category_id' => 2],
        ['Sub_category_Name' => 'womens-dresses', 'category_id' => 2],
        ['Sub_category_Name' => 'womens-shoes', 'category_id' => 5],
        ['Sub_category_Name' => 'mens-shoes', 'category_id' => 5],
        ['Sub_category_Name' => 'mens-shirts', 'category_id' => 2],
        ['Sub_category_Name' => 'womens-watches', 'category_id' => 2],
        ['Sub_category_Name' => 'mens-watches', 'category_id' => 2],
        ['Sub_category_Name' => 'womens-bags', 'category_id' => 2],
        ['Sub_category_Name' => 'womens-jewellery', 'category_id' => 2],
        ['Sub_category_Name' => 'sunglasses', 'category_id' => 2],
        ['Sub_category_Name' => 'automotive', 'category_id' => 6],
        ['Sub_category_Name' => 'motorcycle', 'category_id' => 6],
        ['Sub_category_Name' => 'lighting', 'category_id' => 3],
        ['Sub_category_Name' => 'furniture', 'category_id' => 3],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->sub_category as $key => $value) {
            DB::table('sub_categories')->insert([
                'Sub_category_Name' => $value['Sub_category_Name'],
                'category_id' => $value['category_id']
            ]);
        }
    }
}
