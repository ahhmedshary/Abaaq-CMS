<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );

        $categories = ['عروض', 'عينات', 'بخور', 'عود', 'مباخر'];
        $catModels  = [];
        foreach ($categories as $i => $name) {
            $catModels[] = Category::firstOrCreate(
                ['slug' => Str::slug($name) ?: 'cat-' . $i],
                ['name' => $name, 'sort_order' => $i]
            );
        }

        $products = [
            ['name' => 'عطر توم فورد عود وود', 'price' => 200, 'compare_price' => 260, 'featured' => true,  'offer' => false],
            ['name' => 'بخور الصندل الفاخر',    'price' => 180, 'compare_price' => null, 'featured' => true,  'offer' => true],
            ['name' => 'مبخرة فضية يدوية',       'price' => 320, 'compare_price' => 400,  'featured' => false, 'offer' => true],
            ['name' => 'عيدان عود كمبودي',       'price' => 550, 'compare_price' => null, 'featured' => true,  'offer' => false],
            ['name' => 'دهن عود ملكي',            'price' => 410, 'compare_price' => 480,  'featured' => true,  'offer' => true],
            ['name' => 'معطر هواء شرقي',          'price' => 95,  'compare_price' => null, 'featured' => false, 'offer' => false],
        ];

        foreach ($products as $i => $p) {
            Product::firstOrCreate(
                ['slug' => Str::slug($p['name']) ?: 'product-' . $i],
                [
                    'category_id'  => $catModels[array_rand($catModels)]->id,
                    'name'         => $p['name'],
                    'description'  => 'منتج فاخر مصنوع من أجود الخامات الطبيعية.',
                    'price'        => $p['price'],
                    'compare_price'=> $p['compare_price'],
                    'stock'        => 100,
                    'is_featured'  => $p['featured'],
                    'is_on_offer'  => $p['offer'],
                    'is_published' => true,
                    'sort_order'   => $i,
                ]
            );
        }

        // Page sections
        foreach (PageSection::defaultSections() as $s) {
            PageSection::firstOrCreate(
                ['page' => 'home', 'type' => $s['type']],
                ['label' => $s['label'], 'sort_order' => $s['sort_order'], 'is_visible' => $s['is_visible'], 'settings' => $s['settings']]
            );
        }
    }
}
