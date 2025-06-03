<?php
namespace App\Helpers;

use App\Models\BadWord;

class ProfanityFilter
{
    public static function containsBadWords($text)
{
    $badWords = BadWord::pluck('word')->toArray();

    foreach ($badWords as $word) {
        if (stripos($text, $word) !== false) {
            return true;
        }
    }
    return false;
}

}
