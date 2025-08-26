<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
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
