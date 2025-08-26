<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user)
    {
        // Tự động tạo customer khi user có role_id = 3
        if ($user->role_id == 3) {
            Customer::create([
                'user_id' => $user->id,
                'customer_type' => 'new',
                'total_orders' => 0,
                'total_spent' => 0,
            ]);
        }
    }

    public function updated(User $user)
    {
        // Log any update to users to help trace unexpected writes
        $dirty = $user->getDirty();
        if (!empty($dirty)) {
            Log::info('User model updated (observer)', [
                'user_id' => $user->id,
                'dirty' => $dirty,
            ]);
        }
    }
}
