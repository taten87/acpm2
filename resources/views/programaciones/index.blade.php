<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Programaciones Mensuales') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="{ openModal: false }">

        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Historial de Fichas Mensuales
            </h3>
            <button @click="openModal = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow transition">
                + Crear Nueva Programación Mensual
            </button>
        </div>

        <!-- TABLA DE PROGRAMACIONES -->
        <div
            class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Mes Programado</th>
                        <th class="px-6 py-3">Instructor</th>
                        <th class="px-6 py-3 text-center">Total Horas Acumuladas</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($programaciones as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white uppercase">
                                {{ $p->mes_anio }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $p->user->name }}
                            </td>
                            <td class="px-6 py-4 text-center font-extrabold text-indigo-600 dark:text-indigo-400">
                                {{ $p->total_horas ?? 0 }} hrs
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-3">
                                <!-- Botón Ver -->
                                <a href="{{ route('programaciones.show', $p) }}"
                                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded shadow">
                                    Ver / Gestionar Ficha 👁️
                                </a>

                                <!-- Botón Eliminar con Fetch Naitvo -->
                                <button type="button"
                                    onclick="eliminarProgramacion('{{ route('programaciones.destroy', $p->id) }}')"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded shadow">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No has creado ninguna programación mensual. Haz clic en el botón superior para iniciar
                                una.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MODAL PARA CREAR NUEVO MES -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full space-y-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Seleccionar Mes de Programación</h3>

                <form action="{{ route('programaciones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-1">Mes y
                            Año</label>
                        <input type="month" name="mes_anio" required
                            class="w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm dark:text-white">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-gray-500 text-white text-xs rounded">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded">Crear Ficha</button>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script>
        function eliminarProgramacion(url) {
            if (!confirm('¿Seguro que deseas eliminar esta programación mensual completa?')) {
                return;
            }

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();

                    if (response.ok && data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'No se pudo eliminar la programación.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al intentar eliminar.');
                });
        }
    </script>



</x-app-layout>
