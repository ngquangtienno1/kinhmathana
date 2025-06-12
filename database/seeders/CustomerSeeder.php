<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users with customer role
        $users = User::where('role_id', 3)->get();

        foreach ($users as $user) {
            // Create customer for each user
            $customer = Customer::factory()->create([
                'user_id' => $user->id,
            ]);

            // Update customer statistics based on their orders
            $totalOrders = $user->orders()->count();
            $totalSpent = $user->orders()->sum('total_amount');
            $lastOrder = $user->orders()->latest()->first();

            $customer->update([
                'total_orders' => $totalOrders,
                'total_spent' => $totalSpent,
                'last_order_at' => $lastOrder ? $lastOrder->created_at : null,
            ]);

            // Update customer type based on spending
            $customer->updateCustomerType();
        }
    }
}