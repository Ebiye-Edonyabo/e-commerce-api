<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\LinkFactory;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $links = Link::factory()->count(3)->create();
        $products = Product::factory(5)->create();

        User::factory(6)->has(Link::factory()->count(3)->hasAttached($products))->create();


        // Link::factory()->hasAttached($products)->create();


        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'is_admin' => 1
        // ]);

        // Schema::disableForeignKeyConstraints();
        // DB::table('links')->truncate();
        // Schema::enableForeignKeyConstraints();

    }
}
