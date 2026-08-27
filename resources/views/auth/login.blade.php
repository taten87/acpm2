<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs backdrop-blur-md">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-100">Iniciar Sesión</h2>
        <p class="text-xs text-slate-400 mt-1">Ingresa tus credenciales para acceder al sistema</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Correo') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="correo@ejemplo.com"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">{{ __('Contraseña') }}</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <!-- Selección de Rol -->
        <div>
            <label for="role" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Selecciona tu Rol para ingresar</label>
            <select name="role" id="role" required
                class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 transition-all">
                <option value="" disabled {{ old('role') ? '' : 'selected' }} class="bg-slate-900 text-slate-500">-- Elige un rol --</option>
                <option value="Instructor" {{ old('role') == 'Instructor' ? 'selected' : '' }} class="bg-slate-900 text-slate-100">Instructor</option>
                <option value="Coordinador Académico" {{ old('role') == 'Coordinador Académico' ? 'selected' : '' }} class="bg-slate-900 text-slate-100">Coordinador Académico</option>
                <option value="Coordinador Administrativo" {{ old('role') == 'Coordinador Administrativo' ? 'selected' : '' }} class="bg-slate-900 text-slate-100">Coordinador Administrativo</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded bg-slate-950 border-slate-800 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-900">
                <span class="ms-2 text-xs text-slate-400 select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-cyan-400 hover:text-cyan-300 transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Botón de Entrar -->
        <div class="pt-2">
            <button type="submit" 
                class="w-full px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-sm rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center justify-center gap-2">
                <span>{{ __('Entrar') }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>
</x-guest-layout>