<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with customer role
        $users = User::where('role_id', 3)->get();

        foreach ($users as $user) {
            // Create 1-5 orders for each customer
            $orders = Order::factory()->count(rand(1, 5))->create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'customer_address' => $user->address,
            ]);

            // Update customer statistics after creating orders
            $customer = $user->customer;
            if ($customer) {
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
}