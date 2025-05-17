<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // RoleSeeder::class,
            // User::factory(10)->create();
            // UserSeeder::class,
            // OrderSeeder::class,
            // SliderSeeder::class,
            // NewsSeeder::class,
            // BrandSeeder::class,
            // ShippingProviderSeeder::class,
            // WebsiteSettingSeeder::class,

            // $this->call([
            //     RoleSeeder::class, // Gọi trước
            //     UserSeeder::class,
            //     OrderSeeder::class,
            //     PaymentMethodSeeder::class,
            //     PaymentSeeder::class,
            // ]);

            $this->call([
                UserSeeder::class,
                NewsSeeder::class,
                ProductSeeder::class,
                CommentSeeder::class,
            ]),
        ]);
    }
}