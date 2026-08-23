<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Programación Mensual') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        openDeleteModal: false,
        deleteUrl: '',
        countdown: 5,
        timer: null,
    
        openEditModal: false,
        editUrl: '',
        editData: {},
    
        startDelete(url) {
            this.deleteUrl = url;
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
        },
    
        setEdit(url, item) {
            this.editUrl = url;
            this.editData = item;
            this.openEditModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes -->
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

            <!-- Formulario de Registro con Listas Desplegables -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Registrar Programación
                </h3>

                <form method="POST" action="{{ route('programaciones.store') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf

                    <div>
                        <x-input-label for="idUsuario" value="Instructor / Usuario" />
                        <select id="idUsuario" name="idUsuario" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Instructor</option>
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('idUsuario') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="numFicha" value="Número de Ficha" />
                        <select id="numFicha" name="numFicha" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Ficha</option>
                            @foreach ($fichas as $ficha)
                                <option value="{{ $ficha->numFicha }}"
                                    {{ old('numFicha') == $ficha->numFicha ? 'selected' : '' }}>{{ $ficha->numFicha }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="codPrograma" value="Programa de Formación" />
                        <select id="codPrograma" name="codPrograma" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Programa</option>
                            @foreach ($programas as $prog)
                                <option value="{{ $prog->codPrograma }}"
                                    {{ old('codPrograma') == $prog->codPrograma ? 'selected' : '' }}>
                                    {{ $prog->nombre }} ({{ $prog->version }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="idCompetencia" value="Competencia" />
                        <select id="idCompetencia" name="idCompetencia" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Competencia</option>
                            @foreach ($competencias as $comp)
                                <option value="{{ $comp->idCompetencia }}"
                                    {{ old('idCompetencia') == $comp->idCompetencia ? 'selected' : '' }}>
                                    {{ $comp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="idResultadoAprendizaje" value="Resultado de Aprendizaje" />
                        <select id="idResultadoAprendizaje" name="idResultadoAprendizaje" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Resultado</option>
                            @foreach ($resultados as $res)
                                <option value="{{ $res->idResultadoAprendizaje }}"
                                    {{ old('idResultadoAprendizaje') == $res->idResultadoAprendizaje ? 'selected' : '' }}>
                                    {{ $res->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="idActividadProyecto" value="Actividad de Proyecto" />
                        <select id="idActividadProyecto" name="idActividadProyecto" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            <option value="">Seleccione Actividad</option>
                            @foreach ($actividades as $act)
                                <option value="{{ $act->idActividadProyecto }}"
                                    {{ old('idActividadProyecto') == $act->idActividadProyecto ? 'selected' : '' }}>
                                    {{ Str::limit($act->descripcion, 40) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="horas" value="Horas" />
                        <x-text-input id="horas" class="block mt-1 w-full" type="number" name="horas"
                            :value="old('horas')" min="1" required />
                    </div>

                    <div>
                        <x-input-label for="fechaInicio" value="Fecha de Inicio" />
                        <x-text-input id="fechaInicio" class="block mt-1 w-full" type="date" name="fechaInicio"
                            :value="old('fechaInicio')" required />
                    </div>

                    <div>
                        <x-input-label for="fechaFin" value="Fecha de Fin" />
                        <x-text-input id="fechaFin" class="block mt-1 w-full" type="date" name="fechaFin"
                            :value="old('fechaFin')" required />
                    </div>

                    <div class="md:col-span-3">
                        <x-primary-button>
                            {{ __('Guardar Programación') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Listado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Programaciones Mensuales Registradas
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Instructor</th>
                                <th scope="col" class="px-4 py-3">Ficha</th>
                                <th scope="col" class="px-4 py-3">Programa</th>
                                <th scope="col" class="px-4 py-3">Competencia</th>
                                <th scope="col" class="px-4 py-3">Horas</th>
                                <th scope="col" class="px-4 py-3">Fechas</th>
                                <th scope="col" class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programaciones as $p)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                        {{ $p->usuario->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $p->numFicha }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">
                                        {{ $p->programa->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">
                                        {{ Str::limit($p->competencia->nombre ?? 'N/A', 30) }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $p->horas }}h</td>
                                    <td class="px-4 py-3 text-xs text-gray-900 dark:text-white">{{ $p->fechaInicio }} /
                                        {{ $p->fechaFin }}</td>
                                    <td class="px-4 py-3 flex gap-2">
                                        <button
                                            @click="setEdit('{{ route('programaciones.update', $p) }}', {{ json_encode($p) }})"
                                            class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded hover:bg-yellow-600 transition">
                                            Editar
                                        </button>

                                        <button @click="startDelete('{{ route('programaciones.destroy', $p) }}')"
                                            class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No hay programaciones mensuales registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $programaciones->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Editar -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-2xl w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Editar Programación Mensual</h3>

                <form :action="editUrl" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Instructor</label>
                        <select name="idUsuario" x-model="editData.idUsuario" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Ficha</label>
                        <select name="numFicha" x-model="editData.numFicha" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($fichas as $ficha)
                                <option value="{{ $ficha->numFicha }}">{{ $ficha->numFicha }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Programa</label>
                        <select name="codPrograma" x-model="editData.codPrograma" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($programas as $prog)
                                <option value="{{ $prog->codPrograma }}">{{ $prog->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Competencia</label>
                        <select name="idCompetencia" x-model="editData.idCompetencia" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($competencias as $comp)
                                <option value="{{ $comp->idCompetencia }}">{{ $comp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Resultado
                            Aprendizaje</label>
                        <select name="idResultadoAprendizaje" x-model="editData.idResultadoAprendizaje" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($resultados as $res)
                                <option value="{{ $res->idResultadoAprendizaje }}">{{ $res->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Actividad
                            Proyecto</label>
                        <select name="idActividadProyecto" x-model="editData.idActividadProyecto" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                            @foreach ($actividades as $act)
                                <option value="{{ $act->idActividadProyecto }}">
                                    {{ Str::limit($act->descripcion, 30) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Horas</label>
                        <input type="number" name="horas" x-model="editData.horas" min="1" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                        <input type="date" name="fechaInicio" x-model="editData.fechaInicio" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                        <input type="date" name="fechaFin" x-model="editData.fechaFin" required
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-2 mt-2">
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

        <!-- Modal Eliminar con Conteo de 5 segundos -->
        <div x-show="openDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-bold text-red-600 dark:text-red-400 mb-2">¿Eliminar esta programación?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Esta acción no se puede deshacer.</p>

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
