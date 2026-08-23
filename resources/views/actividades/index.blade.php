<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Actividades de Proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        openDeleteModal: false,
        deleteUrl: '',
        selectedDescripcion: '',
        countdown: 5,
        timer: null,
    
        openEditModal: false,
        editUrl: '',
        editDescripcion: '',
    
        startDelete(url, descripcion) {
            this.deleteUrl = url;
            this.selectedDescripcion = descripcion;
            this.openDeleteModal = true;
            this.countdown = 5;
    
            if (this.timer) clearInterval(this.timer);
    
            this.timer = setInterval(() => {
                if (this.countdown > 0) {
                    this.countdown--;
                } else {
                    clearInterval(this.timer);
                }
            }, 1000);
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes de Estado y Error -->
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
                    Registrar Nueva Actividad de Proyecto
                </h3>

                <form method="POST" action="{{ route('actividades.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="descripcion" value="Descripción de la Actividad" />
                        <textarea id="descripcion" name="descripcion" rows="3" required
                            placeholder="Escribe la descripción de la actividad..."
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">{{ old('descripcion') }}</textarea>
                    </div>

                    <div>
                        <x-primary-button>
                            {{ __('Guardar Actividad') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Registros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Actividades Registradas
                </h3>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3 w-48">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actividades as $actividad)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-pre-line">
                                    {{ $actividad->descripcion }}
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button
                                        @click="
                                            openEditModal = true; 
                                            editUrl = '{{ route('actividades.update', $actividad) }}'; 
                                            editDescripcion = '{{ addslashes($actividad->descripcion) }}';
                                        "
                                        class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded hover:bg-yellow-600 transition">
                                        Editar
                                    </button>

                                    <button
                                        @click="startDelete('{{ route('actividades.destroy', $actividad) }}', '{{ addslashes($actividad->descripcion) }}')"
                                        class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                    No hay actividades de proyecto registradas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $actividades->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Editar -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-lg w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Editar Actividad de Proyecto</h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea name="descripcion" x-model="editDescripcion" rows="4" required
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm"></textarea>
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

        <!-- Modal Eliminar con Conteo Reversivo -->
        <div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-red-600 dark:text-red-400 mb-2">¿Eliminar actividad de proyecto?</h3>

                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 bg-gray-100 dark:bg-gray-900 p-3 rounded text-xs italic max-h-32 overflow-y-auto"
                    x-text="selectedDescripcion"></p>

                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openDeleteModal = false; if(timer) clearInterval(timer);"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-400">
                            Cancelar
                        </button>

                        <button type="submit" :disabled="countdown > 0"
                            :class="countdown > 0 ? 'opacity-50 cursor-not-allowed bg-red-400' : 'bg-red-600 hover:bg-red-700'"
                            class="px-4 py-2 text-white rounded-md text-xs font-semibold transition flex items-center gap-1">
                            <span>Sí, eliminar</span>
                            <template x-if="countdown > 0">
                                <span x-text="'(' + countdown + 's)'"></span>
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
