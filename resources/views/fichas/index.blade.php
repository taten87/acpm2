<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Fichas SENA') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openDeleteModal: false, deleteUrl: '', selectedFicha: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensaje de confirmación de éxito -->
            @if (session('status'))
                <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Mensajes de errores de validación -->
            @if ($errors->any())
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/50 dark:text-red-300">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de Registro de Ficha -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Registrar Nueva Ficha
                </h3>

                <form method="POST" action="{{ route('fichas.store') }}" class="max-w-md">
                    @csrf

                    <div>
                        <x-input-label for="numFicha" value="Número de Ficha" />
                        <x-text-input id="numFicha" class="block mt-1 w-full" type="number" name="numFicha"
                            :value="old('numFicha')" required placeholder="Ej. 2670123" />
                        <x-input-error :messages="$errors->get('numFicha')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>
                            {{ __('Guardar Ficha') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Listado de Fichas Creadas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Fichas Registradas
                </h3>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Número de Ficha</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fichas as $ficha)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $ficha->numFicha }}
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        @click="
                                            openDeleteModal = true; 
                                            deleteUrl = '{{ route('fichas.destroy', $ficha) }}'; 
                                            selectedFicha = '{{ $ficha->numFicha }}';
                                        "
                                        class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                    No hay fichas registradas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $fichas->links() }}
                </div>
            </div>

        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Confirmar eliminación</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Para confirmar la eliminación, escribe el número exacto de la ficha (<strong
                        x-text="selectedFicha"></strong>):
                </p>

                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <input type="number" name="confirm_numFicha" required placeholder="Escribe el número de ficha aquí"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm mb-4">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-xs font-semibold hover:bg-red-700">
                            Eliminar Ficha
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
