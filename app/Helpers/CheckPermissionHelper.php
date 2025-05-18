<?php



use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists('canAccess')) {
    /**
     * Kiểm tra xem user hiện tại có quyền cụ thể không.
     *
     * @param string $permissionSlug
     * @return bool
     */
    function canAccess(string $permissionSlug): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user !== null && $user->hasPermission($permissionSlug);
    }
}