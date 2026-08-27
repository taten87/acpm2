<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-slate-950 text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>

            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
