<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight">
            {{ __('Gestión de Resultados de Aprendizaje') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-slate-950 text-slate-100" x-data="{
        openDeleteModal: false,
        deleteUrl: '',
        selectedNombre: '',
        countdown: 5,
        timer: null,
    
        openEditModal: false,
        editUrl: '',
        editNombre: '',
    
        startDelete(url, nombre) {
            this.deleteUrl = url;
            this.selectedNombre = nombre;
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
                <div
                    class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm backdrop-blur-md flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm backdrop-blur-md">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <span class="text-rose-500">•</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de Registro -->
            <div
                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                <div
                    class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none">
                </div>

                <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Registrar Nuevo Resultado de Aprendizaje
                </h3>

                <form method="POST" action="{{ route('resultados.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nombre"
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nombre del
                            Resultado de Aprendizaje</label>
                        <input id="nombre" type="text" name="nombre" :value="old('nombre')" required
                            placeholder="Ej. Alcanzar los objetivos propuestos..."
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
                    </div>

                    <div class="flex justify-start pt-2">
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-sm rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Guardar Resultado</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Registros -->
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Resultados Registrados
                </h3>

                <div class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead
                            class="text-xs uppercase bg-slate-950/80 text-cyan-400 border-b border-slate-800 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nombre</th>
                                <th scope="col" class="px-6 py-4 w-48 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 bg-slate-900/30">
                            @forelse ($resultados as $resultado)
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-100">
                                        {{ $resultado->nombre }}
                                    </td>
                                    <td class="px-6 py-4 flex justify-end gap-2">
                                        <button
                                            @click="
                                                openEditModal = true; 
                                                editUrl = '{{ route('resultados.update', $resultado) }}'; 
                                                editNombre = '{{ addslashes($resultado->nombre) }}';
                                            "
                                            class="px-3 py-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Editar
                                        </button>

                                        <button
                                            @click="startDelete('{{ route('resultados.destroy', $resultado) }}', '{{ addslashes($resultado->nombre) }}')"
                                            class="px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/30 hover:bg-rose-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-slate-500 italic">
                                        No hay resultados de aprendizaje registrados aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $resultados->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Editar -->
        <div x-show="openEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-slate-100 mb-4">Editar Resultado de Aprendizaje</h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nombre</label>
                        <input type="text" name="nombre" x-model="editNombre" required
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-xs font-bold transition-colors">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Eliminar con Temporizador -->
        <div x-show="openDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-rose-400 mb-2">¿Eliminar resultado de aprendizaje?</h3>

                <p class="text-xs font-medium text-slate-300 mb-5 bg-slate-950/80 border border-slate-800/80 p-3 rounded-xl italic break-words"
                    x-text="selectedNombre"></p>

                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openDeleteModal = false; if(timer) clearInterval(timer);"
                            class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            Cancelar
                        </button>

                        <button type="submit" :disabled="countdown > 0"
                            :class="countdown > 0 ?
                                'opacity-40 cursor-not-allowed bg-rose-900/50 text-rose-300 border border-rose-800/50' :
                                'bg-rose-600 hover:bg-rose-500 text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]'"
                            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all flex items-center gap-1.5">
                            <span>Sí, eliminar</span>
                            <template x-if="countdown > 0">
                                <span x-text="'(' + countdown + 's)'" class="font-mono text-cyan-400"></span>
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
