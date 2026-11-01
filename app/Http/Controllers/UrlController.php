<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{


    public function index()
    {
        $user = auth()->user();

        if ($user->role === User::ROLE_ADMIN) {
            // Admin can see all URLs of their company
            $urls = Url::with('user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->paginate(10);
        } elseif ($user->role === User::ROLE_MEMBER) {
            // Member can see only URLs created by them
            $urls = Url::with('user')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            abort(403);
        }

        return view('urls.index', compact('urls'));
    }


    // Display URL creation form
    public function create()
    {
        return view('urls.create');
    }

    // Store short URL
    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless(
            in_array($user->role, [
                User::ROLE_SUPERADMIN,
                User::ROLE_MEMBER
            ]),
            403
        );

        $validated = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
        ]);

        do {
            $shortCode = Str::random(8);
        } while (Url::where('short_code', $shortCode)->exists());

        // SuperAdmin selects a company.
        // Member automatically uses their own company.
        if ($user->role === User::ROLE_SUPERADMIN) {

            $companyId = $request->validate([
                'company_id' => ['required', 'exists:companies,id'],
            ])['company_id'];
        } else {

            abort_unless($user->company_id, 403);

            $companyId = $user->company_id;
        }

        $url = Url::create([
            'user_id' => $user->id,
            'company_id' => $companyId,
            'original_url' => $validated['original_url'],
            'short_code' => $shortCode,
        ]);

        return redirect()
            ->route('urls.index')
            ->with('success', 'Short URL created successfully!');
    }
}
