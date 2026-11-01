<?php

namespace App\Http\Controllers;

use App\Models\Url;

class UrlRedirectController extends Controller
{
    public function redirect(string $code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();

        // Allow only HTTP and HTTPS destinations
        $scheme = parse_url($url->original_url, PHP_URL_SCHEME);

        if (!in_array(strtolower($scheme ?? ''), ['http', 'https'], true)) {
            abort(400, 'Invalid destination URL.');
        }

        // Increment click count atomically
        $url->increment('clicks');

        return redirect()->away($url->original_url);
    }
}
