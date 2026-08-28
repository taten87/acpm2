<x-app-layout> {{-- Plantilla --}}

    <x-slot name="header"> {{-- header de la página --}}

        <h2 {{-- Título de la página --}}
            class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight">
            {{ __('Gestión de Fichas SENA') }} {{-- Contenido del título --}}
        </h2>

    </x-slot>

    <div class="py-12 min-h-screen bg-slate-950 text-slate-100" 
    x-data="{
        openDeleteModal: false,
        deleteUrl: '',
        selectedFicha: '',
        openEditModal: false,
        editUrl: '',
        editNumFicha: '',
        currentNumFicha: ''
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensaje de confirmación de éxito -->
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

            <!-- Mensajes de errores de validación -->
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

            <!-- Formulario de Registro de Ficha -->
            <div
                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">

                {{-- Creo que esto no sirve para nada --}}
                {{-- <div 
                    class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none">
                </div> --}}

                {{-- Título del formulario --}}
                <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                    {{-- Icono del formulario --}}
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Registrar Nueva Ficha {{-- Contenido del título --}}
                </h3>

                {{-- Formulario de Registro de Ficha --}}
                <form method="POST" action="{{ route('fichas.store') }}" class="max-w-md space-y-4">
                    @csrf

                    <div>
                        <label for="numFicha"
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Número de
                            Ficha</label>
                        <input id="numFicha" type="number" name="numFicha" :value="old('numFicha')" required
                            placeholder="Ej. 2670123"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
                        <x-input-error :messages="$errors->get('numFicha')" class="mt-2 text-xs text-rose-400" />
                    </div>

                    <div>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-sm rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Guardar Ficha</span>
                        </button>
                    </div>

                </form>


            </div>

            <!-- Listado de Fichas Creadas -->
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl">

                {{-- Título del listado --}}
                <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                    {{-- Icono del listado --}}
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Fichas Registradas {{-- Contenido del título del listado --}}
                </h3>

                <div class="overflow-x-auto rounded-xl border border-slate-800">

                    <table class="w-full text-sm text-left text-slate-300">
                        
                        <thead class="text-xs uppercase bg-slate-950/80 text-cyan-400 border-b border-slate-800 tracking-wider">

                            <tr>
                                <th scope="col" class="px-6 py-4">Número de Ficha</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-800/60 bg-slate-900/30">

                            @forelse ($fichas as $ficha)

                                <tr class="hover:bg-slate-800/40 transition-colors">

                                    <td class="px-6 py-4 font-mono font-medium text-slate-100">
                                        {{ $ficha->numFicha }}
                                    </td>

                                    <td class="px-6 py-4 flex justify-end gap-2">

                                        <!-- Botón Editar -->
                                        <button
                                            @click="
                                                openEditModal = true; 
                                                editUrl = '{{ route('fichas.update', $ficha) }}'; 
                                                editNumFicha = '{{ $ficha->numFicha }}';
                                                currentNumFicha = '{{ $ficha->numFicha }}';
                                            "
                                            class="px-3 py-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Editar
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button
                                            @click="
                                                openDeleteModal = true; 
                                                deleteUrl = '{{ route('fichas.destroy', $ficha) }}'; 
                                                selectedFicha = '{{ $ficha->numFicha }}';
                                            "
                                            class="px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/30 hover:bg-rose-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Eliminar
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="2" class="px-6 py-8 text-center text-slate-500 italic">
                                        No hay fichas registradas aún.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-6">
                    {{ $fichas->links() }}
                </div>
            </div>

        </div>

        <!-- Modal de Edición de Ficha -->
        <div x-show="openEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-slate-100 mb-4">Editar Ficha</h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nuevo
                            Número de Ficha</label>
                        <input type="number" name="numFicha" x-model="editNumFicha" required
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100">
                    </div>

                    <!-- Confirmación por número de ficha actual -->
                    <div class="border-t border-slate-800 pt-4">
                        <p class="text-xs text-slate-400 mb-2">
                            Para aplicar los cambios, confirma escribiendo el <strong class="text-slate-200">número
                                actual</strong> de la ficha
                            (<span x-text="currentNumFicha" class="font-mono text-cyan-400 font-bold"></span>):
                        </p>
                        <input type="number" name="current_numFicha_confirm" required
                            placeholder="Escribe el número actual aquí"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600">
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

        <!-- Modal de Confirmación de Eliminación -->
        <div x-show="openDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-rose-400 mb-2">Confirmar eliminación</h3>
                <p class="text-sm text-slate-400 mb-4">
                    Para confirmar la eliminación, escribe el número exacto de la ficha (<strong
                        class="text-slate-200 font-mono" x-text="selectedFicha"></strong>):
                </p>

                <form :action="deleteUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <input type="number" name="confirm_numFicha" required
                        placeholder="Escribe el número de ficha aquí"
                        class="w-full bg-slate-950/60 border border-slate-800 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600">

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-colors">
                            Eliminar Ficha
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
