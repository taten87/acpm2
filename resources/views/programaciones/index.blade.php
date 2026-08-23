<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planeación y Programación Mensual') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="{
        openCreateModal: false,
        openEditModal: false,
        editUrl: '',
        editData: {}
    }">

        <!-- 1. CABECERA CON DATOS DEL INSTRUCTOR Y MES -->
        <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-300 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 text-center">
                <div class="bg-white dark:bg-gray-900 p-3 rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-500 uppercase block">Nombre del Instructor</span>
                    <p class="font-bold text-gray-800 dark:text-gray-100 text-sm truncate">
                        {{ auth()->user()->name }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-3 rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-500 uppercase block">Documento de ID</span>
                    <p class="font-bold text-gray-800 dark:text-gray-100 text-sm">
                        {{ auth()->user()->documento ?? 'N/A' }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-3 rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-500 uppercase block">Correo Institucional</span>
                    <p class="font-bold text-gray-800 dark:text-gray-100 text-sm truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-3 rounded shadow-sm">
                    <span class="text-xs font-semibold text-gray-500 uppercase block">Número de Celular</span>
                    <p class="font-bold text-gray-800 dark:text-gray-100 text-sm">
                        {{ auth()->user()->telefono ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 p-3 rounded shadow-sm border-2 border-indigo-500 flex flex-col justify-center">
                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase block">Mes
                        Programado</span>
                    <input type="month"
                        class="w-full text-center border-none font-bold text-gray-800 dark:text-gray-100 p-0 focus:ring-0 text-sm bg-transparent"
                        value="2026-08">
                </div>
            </div>
        </div>

        <!-- BOTÓN DE ACCIÓN CREAR -->
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Actividades Planeadas
            </h3>
            <button @click="openCreateModal = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow transition flex items-center gap-2">
                + Agregar Registro a la Programación
            </button>
        </div>

        <!-- 2. TABLA TIPO EXCEL / PLANTILLA SENA -->
        <div
            class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto border border-gray-300 dark:border-gray-700">
            <table class="w-full text-xs text-center border-collapse">
                <thead class="bg-gray-300 dark:bg-gray-900 text-gray-800 dark:text-gray-200 uppercase font-bold">
                    <tr class="border-b border-gray-400 dark:border-gray-700">
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Ficha</th>
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Programa</th>
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Actividad de
                            Proyecto</th>
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Competencia</th>
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Resultado</th>
                        <th rowspan="2" class="p-2 border-r border-gray-400 dark:border-gray-700">Horas Ejecutadas
                        </th>
                        <th colspan="2" class="p-1 border-r border-b border-gray-400 dark:border-gray-700">Fecha</th>
                        <th rowspan="2" class="p-2">Acciones</th>
                    </tr>
                    <tr class="border-b border-gray-400 dark:border-gray-700 bg-gray-200 dark:bg-gray-800">
                        <th class="p-1 border-r border-gray-400 dark:border-gray-700">Inicio</th>
                        <th class="p-1 border-r border-gray-400 dark:border-gray-700">Final</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-700 bg-gray-50 dark:bg-gray-800">
                    @forelse ($programaciones as $p)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <td
                                class="p-2 border-r border-gray-300 dark:border-gray-700 font-bold text-red-600 dark:text-red-400">
                                {{ $p->numFicha }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 text-left">
                                {{ $p->programa->nombre ?? 'N/A' }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 text-left">
                                {{ Str::limit($p->actividadProyecto->descripcion ?? 'N/A', 35) }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 text-left">
                                {{ Str::limit($p->competencia->nombre ?? 'N/A', 30) }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 text-left">
                                {{ Str::limit($p->resultadoAprendizaje->nombre ?? 'N/A', 30) }}
                            </td>
                            <td
                                class="p-2 border-r border-gray-300 dark:border-gray-700 font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $p->horas }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 whitespace-nowrap">
                                {{ $p->fechaInicio }}
                            </td>
                            <td class="p-2 border-r border-gray-300 dark:border-gray-700 whitespace-nowrap">
                                {{ $p->fechaFin }}
                            </td>
                            <td class="p-2 flex justify-center gap-2 items-center">
                                <!-- Botón Editar -->
                                <button
                                    @click="
                                        editUrl = '{{ route('programaciones.update', $p) }}';
                                        editData = {{ json_encode($p) }};
                                        openEditModal = true;
                                    "
                                    class="text-amber-500 hover:text-amber-700 font-bold p-1 transition" title="Editar">
                                    ✎
                                </button>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('programaciones.destroy', $p) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este registro de la programación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-bold p-1 transition"
                                        title="Eliminar">✕</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">
                                No hay registros cargados para este mes. Haz clic en "Agregar Registro".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 3. PIE DE TABLA CON TOTAL ACUMULADO DE HORAS -->
        <div
            class="bg-gray-200 dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-300 dark:border-gray-700 flex justify-center items-center gap-4">
            <div
                class="bg-white dark:bg-gray-900 px-6 py-2 rounded font-bold text-gray-700 dark:text-gray-200 uppercase text-xs">
                TOTAL HORAS MES
            </div>
            <div
                class="bg-white dark:bg-gray-900 px-8 py-2 rounded font-extrabold text-indigo-600 dark:text-indigo-400 text-lg border-2 border-indigo-500">
                {{ $programaciones->sum('horas') }} Hours
            </div>
        </div>

        <!-- MODAL FORMULARIO DE INSERCIÓN -->
        <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-2xl w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Añadir Bloque a Programación Mensual
                </h3>

                <form action="{{ route('programaciones.store') }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    @csrf
                    <input type="hidden" name="idUsuario" value="{{ auth()->user()->id }}">

                    <div>
                        <label class="block font-semibold">Ficha</label>
                        <select name="numFicha" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            <option value="">Seleccionar Ficha</option>
                            @foreach ($fichas as $f)
                                <option value="{{ $f->numFicha }}">{{ $f->numFicha }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Programa</label>
                        <select name="codPrograma" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            <option value="">Seleccionar Programa</option>
                            @foreach ($programas as $pr)
                                <option value="{{ $pr->codPrograma }}">{{ $pr->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Competencia</label>
                        <select name="idCompetencia" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            <option value="">Seleccionar Competencia</option>
                            @foreach ($competencias as $c)
                                <option value="{{ $c->idCompetencia }}">{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Resultado de Aprendizaje</label>
                        <select name="idResultadoAprendizaje" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            <option value="">Seleccionar Resultado</option>
                            @foreach ($resultados as $r)
                                <option value="{{ $r->idResultadoAprendizaje }}">{{ $r->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">Actividad de Proyecto</label>
                        <select name="idActividadProyecto" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            <option value="">Seleccionar Actividad</option>
                            @foreach ($actividades as $a)
                                <option value="{{ $a->idActividadProyecto }}">{{ $a->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Horas del Bloque</label>
                        <input type="number" name="horas" min="1" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha Inicio</label>
                        <input type="date" name="fechaInicio" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha Fin</label>
                        <input type="date" name="fechaFin" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-2 mt-4">
                        <button type="button" @click="openCreateModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded font-bold">Guardar en
                            Programación</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL FORMULARIO DE EDICIÓN -->
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-2xl w-full">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Editar Registro de Programación</h3>

                <form :action="editUrl" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idUsuario" :value="editData.idUsuario">

                    <div>
                        <label class="block font-semibold">Ficha</label>
                        <select name="numFicha" x-model="editData.numFicha" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            @foreach ($fichas as $f)
                                <option value="{{ $f->numFicha }}">{{ $f->numFicha }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Programa</label>
                        <select name="codPrograma" x-model="editData.codPrograma" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            @foreach ($programas as $pr)
                                <option value="{{ $pr->codPrograma }}">{{ $pr->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Competencia</label>
                        <select name="idCompetencia" x-model="editData.idCompetencia" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            @foreach ($competencias as $c)
                                <option value="{{ $c->idCompetencia }}">{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Resultado de Aprendizaje</label>
                        <select name="idResultadoAprendizaje" x-model="editData.idResultadoAprendizaje" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            @foreach ($resultados as $r)
                                <option value="{{ $r->idResultadoAprendizaje }}">{{ $r->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">Actividad de Proyecto</label>
                        <select name="idActividadProyecto" x-model="editData.idActividadProyecto" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                            @foreach ($actividades as $a)
                                <option value="{{ $a->idActividadProyecto }}">{{ $a->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Horas del Bloque</label>
                        <input type="number" name="horas" x-model="editData.horas" min="1" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha Inicio</label>
                        <input type="date" name="fechaInicio" x-model="editData.fechaInicio" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha Fin</label>
                        <input type="date" name="fechaFin" x-model="editData.fechaFin" required
                            class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 text-xs">
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-2 mt-4">
                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded font-bold">Actualizar
                            Cambios</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
