<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\Url;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [];

        if ($user->role === User::ROLE_SUPERADMIN) {

            $stats = [
                'total_urls' => Url::count(),
                'total_users' => User::count(),
                'total_companies' => Company::count(),
            ];

        } elseif ($user->role === User::ROLE_ADMIN) {

            $stats = [
                'total_urls' => Url::where(
                    'company_id',
                    $user->company_id
                )->count(),

                'total_users' => User::where(
                    'company_id',
                    $user->company_id
                )->count(),

                'pending_invitations' => Invitation::where(
                    'company_id',
                    $user->company_id
                )
                    ->whereNull('accepted_at')
                    ->where('expires_at', '>', now())
                    ->count(),
            ];

        } elseif ($user->role === User::ROLE_MEMBER) {

            $stats = [
                'my_urls' => Url::where(
                    'user_id',
                    $user->id
                )->count(),
            ];

        } else {
            abort(403);
        }

        return view('dashboard', compact('stats'));
    }
}
