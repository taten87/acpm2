<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight">
            {{ __('Gestión de Programas SENA') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen bg-slate-950 text-slate-100" x-data="{
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

            <!-- Formulario de Registro de Programa -->
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
                    Registrar Nuevo Programa
                </h3>

                <form method="POST" action="{{ route('programas.store') }}"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div>
                        <label for="nombre"
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nombre del
                            Programa</label>
                        <input id="nombre" type="text" name="nombre" :value="old('nombre')" required
                            placeholder="Ej. Análisis y Desarrollo de Software"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
                    </div>

                    <div>
                        <label for="version"
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Versión</label>
                        <input id="version" type="text" name="version" :value="old('version')" required
                            placeholder="Ej. v1.0 / 1"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 transition-all">
                    </div>

                    <div class="md:col-span-2 flex justify-start pt-2">
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-sm rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Guardar Programa</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Registros -->
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Programas Registrados
                </h3>

                <div class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead
                            class="text-xs uppercase bg-slate-950/80 text-cyan-400 border-b border-slate-800 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nombre</th>
                                <th scope="col" class="px-6 py-4">Versión</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 bg-slate-900/30">
                            @forelse ($programas as $programa)
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-100">
                                        {{ $programa->nombre }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-300">
                                        <span
                                            class="px-2.5 py-1 rounded-md bg-slate-800 border border-slate-700/60 text-xs text-cyan-300">
                                            {{ $programa->version }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex justify-end gap-2">
                                        <!-- Botón Editar -->
                                        <button
                                            @click="
                                                openEditModal = true; 
                                                editUrl = '{{ route('programas.update', $programa) }}'; 
                                                editNombre = '{{ $programa->nombre }}';
                                                editVersion = '{{ $programa->version }}';
                                                currentNombre = '{{ $programa->nombre }}';
                                            "
                                            class="px-3 py-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Editar
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button
                                            @click="
                                                openDeleteModal = true; 
                                                deleteUrl = '{{ route('programas.destroy', $programa) }}'; 
                                                selectedNombre = '{{ $programa->nombre }}';
                                            "
                                            class="px-3 py-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/30 hover:bg-rose-500/20 rounded-lg text-xs font-semibold transition-all">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500 italic">
                                        No hay programas registrados aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $programas->links() }}
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
                <h3 class="text-lg font-bold text-slate-100 mb-4">Editar Programa</h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nombre
                            del Programa</label>
                        <input type="text" name="nombre" x-model="editNombre" required
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Versión</label>
                        <input type="text" name="version" x-model="editVersion" required
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-4 py-2.5 text-sm text-slate-100">
                    </div>

                    <div class="border-t border-slate-800 pt-4">
                        <p class="text-xs text-slate-400 mb-2">
                            Confirma escribiendo el <strong class="text-slate-200">nombre actual</strong> del programa
                            (<span x-text="currentNombre" class="font-semibold text-cyan-400"></span>):
                        </p>
                        <input type="text" name="confirm_nombre" required
                            placeholder="Escribe el nombre actual aquí"
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

        <!-- Modal Eliminar -->
        <div x-show="openDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-md w-full relative">
                <h3 class="text-lg font-bold text-rose-400 mb-2">Confirmar eliminación</h3>
                <p class="text-sm text-slate-400 mb-4">
                    Para confirmar la eliminación, escribe el nombre exacto del programa
                    (<strong x-text="selectedNombre" class="text-slate-200"></strong>):
                </p>

                <form :action="deleteUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <input type="text" name="confirm_nombre" required
                        placeholder="Escribe el nombre del programa aquí"
                        class="w-full bg-slate-950/60 border border-slate-800 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 rounded-xl px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600">

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-colors">
                            Eliminar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
