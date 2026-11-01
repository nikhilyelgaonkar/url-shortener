
<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Accept Invitation
        </h2>

        <p class="text-sm text-gray-600 mt-2">
            Complete your details to create your account.
        </p>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">
            Invited Email
        </label>

        <input
            type="email"
            value="{{ $invitation->email }}"
            disabled
            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100"
        />
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">
            Company
        </label>

        <input
            type="text"
            value="{{ $invitation->company->name }}"
            disabled
            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100"
        />
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">
            Assigned Role
        </label>

        <input
            type="text"
            value="{{ ucfirst($invitation->role) }}"
            disabled
            class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100"
        />
    </div>

    <form method="POST"
        action="{{ route('invitations.accept.store', $token) }}">

        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">
                Your Name
            </label>

            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300"
            />

            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>

            <input
                type="password"
                name="password"
                id="password"
                required
                class="mt-1 block w-full rounded-md border-gray-300"
            />

            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation"
                class="block text-sm font-medium text-gray-700">
                Confirm Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                required
                class="mt-1 block w-full rounded-md border-gray-300"
            />
        </div>

        <button type="submit"
            class="w-full px-4 py-2 bg-gray-200 text-gray-800 hover:bg-indigo-700">
            Accept Invitation & Register
        </button>
    </form>
</x-guest-layout>
