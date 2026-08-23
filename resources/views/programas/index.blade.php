<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Programas SENA') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        openDeleteModal: false,
        deleteUrl: '',
        selectedNombre: '',
        openEditModal: false,
        editUrl: '',
        editNombre: '',
        editVersion: '',
        currentNombre: ''
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes de éxito y error -->
            @if (session('status'))
                <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/50 dark:text-red-300">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de Registro -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Registrar Nuevo Programa
                </h3>

                <form method="POST" action="{{ route('programas.store') }}"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div>
                        <x-input-label for="nombre" value="Nombre del Programa" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                            :value="old('nombre')" required placeholder="Ej. Análisis y Desarrollo de Software" />
                    </div>

                    <div>
                        <x-input-label for="version" value="Versión" />
                        <x-text-input id="version" class="block mt-1 w-full" type="text" name="version"
                            :value="old('version')" required placeholder="Ej. v1.0 / 1" />
                    </div>

                    <div class="md:col-span-2">
                        <x-primary-button>
                            {{ __('Guardar Programa') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Registros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Programas Registrados
                </h3>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Versión</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programas as $programa)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $programa->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $programa->version }}
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button
                                        @click="
                                            openEditModal = true; 
                                            editUrl = '{{ route('programas.update', $programa) }}'; 
                                            editNombre = '{{ $programa->nombre }}';
                                            editVersion = '{{ $programa->version }}';
                                            currentNombre = '{{ $programa->nombre }}';
                                        "
                                        class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded hover:bg-yellow-600 transition">
                                        Editar
                                    </button>

                                    <button
                                        @click="
                                            openDeleteModal = true; 
                                            deleteUrl = '{{ route('programas.destroy', $programa) }}'; 
                                            selectedNombre = '{{ $programa->nombre }}';
                                        "
                                        class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    No hay programas registrados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $programas->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Editar -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Editar Programa</h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Nombre del
                            Programa</label>
                        <input type="text" name="nombre" x-model="editNombre" required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Versión</label>
                        <input type="text" name="version" x-model="editVersion" required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div class="border-t pt-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                            Confirma escribiendo el <strong>nombre actual</strong> del programa (<span
                                x-text="currentNombre" class="font-bold"></span>):
                        </p>
                        <input type="text" name="confirm_nombre" required placeholder="Escribe el nombre actual aquí"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md text-xs font-semibold hover:bg-yellow-600">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Confirmar eliminación</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Para confirmar la eliminación, escribe el nombre exacto del programa (<strong
                        x-text="selectedNombre"></strong>):
                </p>

                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <input type="text" name="confirm_nombre" required
                        placeholder="Escribe el nombre del programa aquí"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm mb-4">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-xs font-semibold hover:bg-red-700">
                            Eliminar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
