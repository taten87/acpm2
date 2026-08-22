<x-guest-layout>

    <!-- Botón Volver al dashboard -->
    <div class="mb-4">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-black-100 transition duration-150 ease-in-out">
            ← Volver al Dashboard
        </a>
    </div>


    <!-- Mensaje de confirmación de registro -->
    @if (session('status'))
        <div
            class="mb-4 p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg dark:bg-green-900/50 dark:text-green-300 dark:border-green-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Selección de Rol -->
        <div class="mt-4">
            <x-input-label for="role" value="Rol" />

            <select name="role" id="role"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Selecciona un rol --</option>
                <option value="Instructor" {{ old('role') == 'Instructor' ? 'selected' : '' }}>Instructor</option>
                <option value="Coordinador Académico" {{ old('role') == 'Coordinador Académico' ? 'selected' : '' }}>
                    Coordinador Académico</option>
                <option value="Coordinador Administrativo"
                    {{ old('role') == 'Coordinador Administrativo' ? 'selected' : '' }}>Coordinador Administrativo
                </option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
