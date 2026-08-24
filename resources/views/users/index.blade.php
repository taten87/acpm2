{{-- Estructura de la vista - Donde se ve el listado de usuarios --}}

<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center p-6 bg-slate-900/40 backdrop-blur-2xl border border-slate-800/80 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.36)] relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none">
            </div>

            {{-- Titulo de la página --}}
            <h2
                class="text-3xl sm:text-4xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-cyan-300 relative z-10">
                {{ __('Lista de Usuarios') }}
            </h2>

            <a href="{{ route('register') }}"
                class="relative z-10 inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 rounded-xl hover:from-cyan-400 hover:to-indigo-500 border border-cyan-300/30 shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] transition-all duration-300 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Crear Nuevo Usuario</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 relative min-h-screen w-full bg-[#030712] text-slate-100 overflow-hidden antialiased"
        x-data="{
            openDeleteModal: false,
            deleteUrl: '',
            userEmail: '',
            openEditModal: false,
            editUrl: '',
            editName: '',
            editEmail: '',
            editRole: '',
            currentEmail: ''
        }">
        <!-- Dynamic Glow Ambience Orbs -->
        <div
            class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-[140px] pointer-events-none">
        </div>
        <div
            class="fixed top-1/3 right-10 w-[450px] h-[450px] bg-indigo-600/10 rounded-full blur-[150px] pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            @if (session('status'))
                <div
                    class="mb-6 p-4 text-sm text-emerald-300 bg-emerald-500/10 border border-emerald-500/30 backdrop-blur-md rounded-2xl shadow-[0_0_15px_rgba(16,185,129,0.15)] flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-6 p-4 text-sm text-rose-300 bg-rose-500/10 border border-rose-500/30 backdrop-blur-md rounded-2xl shadow-[0_0_15px_rgba(244,63,94,0.15)]">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TABLA GLASSED -->
            <div
                class="bg-slate-900/40 backdrop-blur-2xl border border-slate-800/80 rounded-3xl shadow-[0_16px_48px_0_rgba(0,0,0,0.4)] overflow-hidden p-6 relative">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead>
                            <tr
                                class="text-xs uppercase tracking-wider text-slate-400 bg-slate-950/70 border-b border-slate-800/80">
                                <th scope="col" class="px-6 py-4 font-bold">ID</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nombre</th>
                                <th scope="col" class="px-6 py-4 font-bold">Correo</th>
                                <th scope="col" class="px-6 py-4 font-bold">Rol</th>
                                <th scope="col" class="px-6 py-4 font-bold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/40">
                            @foreach ($users as $user)
                                <tr class="hover:bg-slate-800/30 transition-colors duration-200">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">#{{ $user->id }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-100">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border backdrop-blur-md shadow-sm
                                            {{ $user->role === 'Instructor' ? 'bg-cyan-500/10 text-cyan-300 border-cyan-500/30 shadow-[0_0_12px_rgba(6,182,212,0.15)]' : '' }}
                                            {{ $user->role === 'Coordinador Académico' ? 'bg-purple-500/10 text-purple-300 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]' : '' }}
                                            {{ $user->role === 'Coordinador Administrativo' ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/30 shadow-[0_0_12px_rgba(16,185,129,0.15)]' : '' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full 
                                                {{ $user->role === 'Instructor' ? 'bg-cyan-400' : '' }}
                                                {{ $user->role === 'Coordinador Académico' ? 'bg-purple-400' : '' }}
                                                {{ $user->role === 'Coordinador Administrativo' ? 'bg-emerald-400' : '' }}"></span>
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            <!-- Botón Editar -->
                                            <button
                                                @click="
                                                    openEditModal = true; 
                                                    editUrl = '{{ route('users.update', $user) }}';
                                                    editName = '{{ $user->name }}';
                                                    editEmail = '{{ $user->email }}';
                                                    editRole = '{{ $user->role }}';
                                                    currentEmail = '{{ $user->email }}';
                                                "
                                                class="px-3.5 py-1.5 text-xs font-semibold text-amber-300 bg-amber-500/10 border border-amber-500/20 rounded-xl hover:bg-amber-500/20 hover:border-amber-500/40 transition-all duration-200">
                                                Editar
                                            </button>

                                            <!-- Botón Eliminar -->
                                            @if (auth()->id() !== $user->id)
                                                <button
                                                    @click="openDeleteModal = true; deleteUrl = '{{ route('users.destroy', $user) }}'; userEmail = '{{ $user->email }}'"
                                                    class="px-3.5 py-1.5 text-xs font-semibold text-rose-300 bg-rose-500/10 border border-rose-500/20 rounded-xl hover:bg-rose-500/20 hover:border-rose-500/40 transition-all duration-200">
                                                    Eliminar
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 border-t border-slate-800/80 pt-4 text-slate-400">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <!-- Modal de Edición (Glassmorphic) -->
        <div x-show="openEditModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
            <div
                class="bg-slate-900/90 border border-slate-800 backdrop-blur-2xl p-6 sm:p-8 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.7)] max-w-md w-full relative overflow-hidden">
                <div
                    class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/10 rounded-full blur-xl pointer-events-none">
                </div>

                <h3 class="text-xl font-extrabold text-white mb-5 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    Editar Usuario
                </h3>

                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nombre</label>
                        <input type="text" name="name" x-model="editName" required
                            class="w-full bg-slate-950/80 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nuevo
                            Correo</label>
                        <input type="email" name="email" x-model="editEmail" required
                            class="w-full bg-slate-950/80 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition-all outline-none">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Rol</label>
                        <select name="role" x-model="editRole" required
                            class="w-full bg-slate-950/80 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition-all outline-none">
                            <option value="Instructor" class="bg-slate-900 text-slate-200">Instructor</option>
                            <option value="Coordinador Académico" class="bg-slate-900 text-slate-200">Coordinador
                                Académico</option>
                            <option value="Coordinador Administrativo" class="bg-slate-900 text-slate-200">Coordinador
                                Administrativo</option>
                        </select>
                    </div>

                    <!-- Confirmación por correo actual -->
                    <div class="border-t border-slate-800/80 pt-4 mt-2">
                        <p class="text-xs text-slate-400 mb-2.5 leading-relaxed">
                            Para guardar los cambios, confirma escribiendo el <strong class="text-slate-200">correo
                                actual</strong> (<span x-text="currentEmail" class="font-mono text-cyan-300"></span>):
                        </p>
                        <input type="email" name="current_email_confirm" required
                            placeholder="Escribe el correo actual aquí"
                            class="w-full bg-slate-950/80 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition-all outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-3">
                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2.5 bg-slate-800/80 text-slate-300 border border-slate-700/50 rounded-xl text-xs font-semibold hover:bg-slate-700 transition-all">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 rounded-xl text-xs font-bold hover:from-amber-400 hover:to-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.2)] transition-all">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de Eliminación (Glassmorphic) -->
        <div x-show="openDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
            <div
                class="bg-slate-900/90 border border-slate-800 backdrop-blur-2xl p-6 sm:p-8 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.7)] max-w-md w-full relative overflow-hidden">
                <div
                    class="absolute -top-12 -right-12 w-32 h-32 bg-rose-500/10 rounded-full blur-xl pointer-events-none">
                </div>

                <h3 class="text-xl font-extrabold text-white mb-2 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                    Confirmar eliminación
                </h3>
                <p class="text-sm text-slate-400 mb-5 leading-relaxed">
                    Para confirmar la eliminación, escribe el correo exacto del usuario (<strong x-text="userEmail"
                        class="font-mono text-rose-300"></strong>):
                </p>

                <form :action="deleteUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <input type="email" name="confirm_email" required placeholder="Escribe el correo aquí"
                        class="w-full bg-slate-950/80 border border-slate-800 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition-all outline-none">

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="openDeleteModal = false"
                            class="px-4 py-2.5 bg-slate-800/80 text-slate-300 border border-slate-700/50 rounded-xl text-xs font-semibold hover:bg-slate-700 transition-all">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-rose-600 to-rose-700 text-white rounded-xl text-xs font-bold hover:from-rose-500 hover:to-rose-600 shadow-[0_0_15px_rgba(244,63,94,0.25)] transition-all">
                            Eliminar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
