<section
    class="bg-slate-900/60 backdrop-blur-xl border border-rose-500/20 rounded-2xl p-6 shadow-xl relative overflow-hidden">
    <div class="absolute -top-12 -left-12 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <header class="mb-6">
        <h2 class="text-lg font-semibold text-rose-400 flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-xs text-slate-400 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 bg-rose-600/10 text-rose-400 border border-rose-500/30 hover:bg-rose-600 hover:text-white font-medium text-xs rounded-xl shadow-[0_0_15px_rgba(225,29,72,0.2)] hover:shadow-[0_0_20px_rgba(225,29,72,0.4)] transition-all duration-300">
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-6 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl relative">
            <h2 class="text-lg font-bold text-rose-400 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-xs text-slate-400 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-5">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}"
                    class="w-full sm:w-3/4 bg-slate-950/60 border border-slate-800 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-rose-400 text-xs" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-all shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
