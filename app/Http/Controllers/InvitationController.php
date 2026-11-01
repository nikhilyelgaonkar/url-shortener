<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    // Display invitations
    public function index()
    {
        $user = auth()->user();

        $query = Invitation::with(['company', 'inviter'])
            ->latest();

        // SuperAdmin can see all invitations
        if ($user->hasRole(User::ROLE_SUPERADMIN)) {
            $invitations = $query->paginate(10);
        } else {
            // Admin can see only invitations in their company
            abort_if(!$user->company_id, 403, 'You are not assigned to a company.');

            $invitations = $query
                ->where('company_id', $user->company_id)
                ->paginate(10);
        }

        return view('invitations.index', compact('invitations'));
    }

    // Show invitation form
    public function create()
    {
        $user = auth()->user();

        $companies = $user->hasRole(User::ROLE_SUPERADMIN)
            ? Company::orderBy('name')->get()
            : collect();

        if ($user->hasRole(User::ROLE_ADMIN) && !$user->company_id) {
            abort(403, 'You are not assigned to a company.');
        }

        return view('invitations.create', compact('companies'));
    }

    // Create invitation
    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasRole(User::ROLE_SUPERADMIN) ||
                $user->hasRole(User::ROLE_ADMIN),
            403,
            'You are not allowed to send invitations.'
        );

        if ($user->hasRole(User::ROLE_SUPERADMIN)) {
            // SuperAdmin can invite Admin only
            $validated = $request->validate([
                'company_id' => ['required', 'exists:companies,id'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'role' => ['required', Rule::in([User::ROLE_ADMIN])],
            ]);

            $companyId = $validated['company_id'];
        } else {
            // Admin can invite Admin or Member in their own company
            abort_if(!$user->company_id, 403, 'You are not assigned to a company.');

            $validated = $request->validate([
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'role' => [
                    'required',
                    Rule::in([
                        User::ROLE_ADMIN,
                        User::ROLE_MEMBER,
                    ]),
                ],
            ]);

            $companyId = $user->company_id;
        }

        // Prevent another active invitation for the same email and company
        $alreadyInvited = Invitation::where('email', $validated['email'])
            ->where('company_id', $companyId)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->exists();

        if ($alreadyInvited) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'An active invitation already exists for this email.',
                ]);
        }

        // Generate a secure random token
        $plainToken = Str::random(64);

        Invitation::create([
            'company_id' => $companyId,
            'invited_by' => $user->id,
            'email' => $validated['email'],
            'role' => $validated['role'],
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addDays(7),
        ]);

        // Temporary development link. Email delivery will be added next.
        $invitationUrl = url('/invitations/' . $plainToken . '/accept');

        return redirect()
            ->route('invitations.index')
            ->with('success', 'Invitation created successfully.')
            ->with('invitation_url', $invitationUrl);
    }

    // Display invitation acceptance form
    public function showAcceptForm(string $token)
    {
        $invitation = Invitation::where(
            'token',
            hash('sha256', $token)
        )->firstOrFail();

        if ($invitation->accepted_at || $invitation->expires_at->isPast()) {
            abort(410, 'This invitation has already been accepted or has expired.');
        }

        if (User::where('email', $invitation->email)->exists()) {
            abort(409, 'An account already exists with this email address.');
        }

        return view('invitations.accept', compact('invitation', 'token'));
    }

    // Accept invitation and register user
    public function accept(Request $request, string $token)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated, $token) {

            // Lock the invitation while it is being accepted
            $invitation = Invitation::where(
                'token',
                hash('sha256', $token)
            )->lockForUpdate()->firstOrFail();

            if ($invitation->accepted_at || $invitation->expires_at->isPast()) {
                abort(410, 'This invitation has already been accepted or has expired.');
            }

            if (User::where('email', $invitation->email)->exists()) {
                abort(409, 'An account already exists with this email address.');
            }

            // Create the invited user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $invitation->email,
                'password' => $validated['password'],
            ]);

            // Assign role and company from the invitation, never from the form
            $user->role = $invitation->role;
            $user->company_id = $invitation->company_id;
            $user->save();

            // Mark invitation as accepted
            $invitation->accepted_at = now();
            $invitation->save();
        });

        return redirect()
            ->route('login')
            ->with('success', 'Your account has been created successfully. You can now log in.');
    }
}
