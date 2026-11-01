<?php
namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;

class ShortUrlService{
     public function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (Url::where('short_code', $code)->exist());
        return  $code;
    }
}
?>