{{-- Estructura de la vista - Donde se ve el listado de usuarios --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lista de Usuarios') }}
            </h2>
            <a href="{{ route('register') }}"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold text-xs rounded-md hover:bg-indigo-700 transition">
                + Crear Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false, deleteUrl: '', userEmail: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div
                    class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/50 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Correo</th>
                            <th scope="col" class="px-6 py-3">Rol</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->role === 'Instructor' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $user->role === 'Coordinador Académico' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->role === 'Coordinador Administrativo' ? 'bg-green-100 text-green-800' : '' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if (auth()->id() !== $user->id)
                                        <button
                                            @click="openModal = true; deleteUrl = '{{ route('users.destroy', $user) }}'; userEmail = '{{ $user->email }}'"
                                            class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                            Eliminar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Confirmar eliminación</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Para confirmar la eliminación, escribe el correo exacto del usuario (<strong
                        x-text="userEmail"></strong>):
                </p>

                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <input type="email" name="confirm_email" required placeholder="Escribe el correo aquí"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 mb-4 text-sm">

                    @error('confirm_email')
                        <p class="text-red-500 text-xs mb-4">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-xs font-semibold hover:bg-red-700">
                            Eliminar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
