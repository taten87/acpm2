<section
    class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
    <div class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <header class="mb-6">
        <h2 class="text-lg font-semibold text-slate-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-xs text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Nombre -->
        <div>
            <label for="name"
                class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                autofocus autocomplete="name"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email"
                class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs">
                    <p class="flex flex-col sm:flex-row gap-1 items-start sm:items-center">
                        <span>{{ __('Your email address is unverified.') }}</span>

                        <button form="send-verification"
                            class="underline text-xs text-cyan-400 hover:text-cyan-300 font-semibold focus:outline-none transition-colors">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-xs text-emerald-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Documento -->
        <div>
            <label for="documento"
                class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Documento de Identificación') }}</label>
            <input id="documento" name="documento" type="text" value="{{ old('documento', $user->documento) }}"
                required autocomplete="documento"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('documento')" />
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono"
                class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Número de Celular / Teléfono') }}</label>
            <input id="telefono" name="telefono" type="text" value="{{ old('telefono', $user->telefono) }}"
                required autocomplete="telefono"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('telefono')" />
        </div>

        <!-- Botón Guardar y Estado -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-sm rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center justify-center gap-2">
                <span>{{ __('Save') }}</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-semibold text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ __('Saved.') }}</span>
                </p>
            @endif
        </div>
    </form>
</section>
