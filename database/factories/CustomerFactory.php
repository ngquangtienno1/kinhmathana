<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'default_address' => $this->faker->address(),
            'total_orders' => $this->faker->numberBetween(0, 50),
            'total_spent' => $this->faker->numberBetween(0, 10000000),
            'last_order_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            // Lấy ngày đăng ký từ user
            $customer->created_at = $customer->user->created_at;
            $customer->save();

            // Tự động cập nhật loại khách hàng dựa trên số đơn và tổng chi tiêu
            $customer->updateCustomerType();
        });
    }
}