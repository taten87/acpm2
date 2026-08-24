<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight">
            {{ __('Mis Programaciones Mensuales') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-slate-950 text-slate-100" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="flex justify-between items-center bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                <div
                    class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none">
                </div>

                <h3 class="text-lg font-semibold text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Historial de Fichas Mensuales
                </h3>

                <button @click="openModal = true"
                    class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-xs rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Crear Nueva Programación Mensual</span>
                </button>
            </div>

            <!-- TABLA DE PROGRAMACIONES -->
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl">
                <div class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead
                            class="text-xs uppercase bg-slate-950/80 text-cyan-400 border-b border-slate-800 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Mes Programado</th>
                                <th scope="col" class="px-6 py-4">Instructor / Responsable</th>
                                <th scope="col" class="px-6 py-4 text-center">Total Horas Acumuladas</th>
                                <th scope="col" class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 bg-slate-900/30">
                            @forelse($programaciones as $p)
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-100 uppercase tracking-wide">
                                        {{ $p->mes_anio }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-300 font-medium">
                                        {{ $p->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">
                                            {{ $p->total_horas ?? 0 }} hrs
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center flex justify-center items-center gap-2">
                                        <!-- Botón Ver -->
                                        <a href="{{ route('programaciones.show', $p->id) }}"
                                            class="px-3 py-1.5 bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Gestionar
                                        </a>

                                        <!-- Botón Eliminar con Fetch Nativo -->
                                        <button type="button"
                                            onclick="eliminarProgramacion('{{ route('programaciones.destroy', $p->id) }}')"
                                            class="px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/30 hover:bg-rose-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Eliminar
                                        </button>

                                        {{-- Botón Exportar Excel --}}
                                        <a href="{{ route('programaciones.exportar', $p->id) }}"
                                            class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/20 rounded-lg text-xs font-semibold transition-all inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Exportar Excel
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">
                                        No has creado ninguna programación mensual. Haz clic en el botón superior para
                                        iniciar una.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- MODAL PARA CREAR NUEVO MES -->
        <div x-show="openModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Seleccionar Mes de Programación
                </h3>

                <form action="{{ route('programaciones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Mes y
                            Año</label>
                        <input type="month" name="mes_anio" required
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 transition-all">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white rounded-xl text-xs font-bold transition-all shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                            Crear Ficha
                        </button>
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
