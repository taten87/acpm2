{{-- NO COMENTAR ESTA VISTA --}}
{{-- TODO: Organizar esta vista --}}

<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            {{-- Titulo de la página --}}
            <h2 class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 leading-tight flex items-center gap-2">

                <span>{{ __('Ficha de Programación Mensual') }}</span>
                <span class="text-slate-600 font-normal">|</span>
                <span class="uppercase text-cyan-400">{{ $programacion->mes_anio }}</span>

            </h2>

            {{-- Btn para volver al listado --}}
            <a href="{{ route('programaciones.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold rounded-xl border border-slate-700/60 transition-all flex items-center gap-1.5 shadow-sm">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Volver al Listado</span>

            </a>

        </div>

    </x-slot>

    
    {{-- Cuerpo de la vista --}}
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 min-h-screen text-slate-100" 
        x-data="{
            openCreateModal: false,
            openEditModal: false,
            editActi: '',
            editUrl: '',
            editData: {}
        }">

        <!-- DATOS DEL INSTRUCTOR -->
        <div class="bg-slate-900/60 backdrop-blur-xl p-5 rounded-2xl shadow-xl border border-slate-800 relative overflow-hidden">

            {{-- <div class="absolute -top-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div> --}} {{-- OJO: COMENTADO POR QUE NO SE CONOCE EL FUNCIONAMIENTO --}}

            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 text-center">

                {{-- Normbre del Instructor --}}
                <div class="bg-slate-950/60 border border-slate-800 p-3 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Nombre del Instructor</span>
                    <p class="font-semibold text-slate-200 text-xs truncate">{{ auth()->user()->name }}</p>
                </div>

                {{-- Documento del Instructor --}}
                <div class="bg-slate-950/60 border border-slate-800 p-3 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Documento de ID</span>
                    <p class="font-semibold text-slate-200 text-xs">{{ auth()->user()->documento ?? 'N/A' }}</p>
                </div>

                {{-- Correo del Instructor --}}
                <div class="bg-slate-950/60 border border-slate-800 p-3 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Correo Institucional</span>
                    <p class="font-semibold text-slate-200 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>

                {{-- Número de teléfono del Instructor  --}}
                <div class="bg-slate-950/60 border border-slate-800 p-3 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Número de Celular</span>
                    <p class="font-semibold text-slate-200 text-xs">{{ auth()->user()->telefono ?? 'N/A' }}</p>
                </div>

                {{-- Mes de la Programación Mensual --}}
                <div class="bg-cyan-950/30 border border-cyan-500/30 p-3 rounded-xl flex flex-col justify-center">
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider block mb-1">Mes Programado</span>
                    <p class="font-bold text-cyan-300 text-xs uppercase">{{ $programacion->mes_anio }}</p>
                </div>

            </div>

        </div>
        <!-- FIN -- DATOS DEL INSTRUCTOR -->

        
        <div class="flex justify-between items-center pt-2">

            {{-- Titulo "Actividades Planeadas" --}}
            <h3 class="text-base font-semibold text-slate-200 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Actividades Planeadas
            </h3>

            {{-- Btn -- AGREGAR REGISTRO --}}
            <button @click="openCreateModal = true" class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium text-xs rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 flex items-center gap-1.5">
                
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Agregar Registro</span>

            </button>
            {{-- FIN -- Btn -- AGREGAR REGISTRO --}}

        </div>

        <!-- TABLA TIPO EXCEL -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 shadow-xl rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">

                {{-- INICIO DE LA TABLA --}}
                <table class="w-full text-xs text-center border-collapse">

                    {{-- ENCABEZADO DE LA TABLA --}}
                    <thead class="bg-slate-950/80 text-slate-300 uppercase font-semibold tracking-wider">

                        {{-- TITULOS PRINCIPALES --}}
                        <tr class="border-b border-slate-800">
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Ficha</th>
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Programa</th>
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Actividad de Aprendizaje</th>
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Competencia</th>
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Resultado</th>
                            <th rowspan="2" class="p-3 border-r border-slate-800/60">Horas</th>
                            <th colspan="2" class="p-2 border-r border-b border-slate-800/60">Fecha</th>
                            <th rowspan="2" class="p-3">Acciones</th>
                        </tr>

                        <tr class="border-b border-slate-800 bg-slate-900/40 text-[10px] text-slate-400">
                            <th class="p-1.5 border-r border-slate-800/60">Inicio</th>
                            <th class="p-1.5 border-r border-slate-800/60">Final</th>
                        </tr>
                        {{-- FIN--TITULOS PRINCIPALES--}}

                    </thead>
                    {{-- FIN -- ENCABEZADO DE LA TABLA --}}

                    {{-- CUERPO DE LA TABLA --}}
                    <tbody class="divide-y divide-slate-800/60 bg-slate-900/20 text-slate-300">

                        {{-- INICIO DE LA CONDICIÓN --}}
                        @forelse ($programacion->detalles as $d)

                            <tr class="hover:bg-slate-800/40 transition-colors">
                                {{-- Mostrar Ficha --}}
                                <td class="p-3 border-r border-slate-800/60 font-bold text-cyan-400">{{ $d->numFicha }}</td>
                                {{-- Mostrar Programa --}}
                                <td class="p-3 border-r border-slate-800/60 text-left font-medium text-slate-200">{{ $d->programa->nombre ?? $d->codPrograma }}</td>
                                {{-- Mostrar Actividad De Aprendizaje --}}
                                <td class="p-3 border-r border-slate-800/60 text-left text-slate-400">{{ Str::limit($d->actividad_aprendizaje ?? '', 35) }}</td>
                                {{-- Mostrar Competencia --}}
                                <td class="p-3 border-r border-slate-800/60 text-left text-slate-400">{{ Str::limit($d->competencia->nombre ?? '', 30) }}</td>
                                {{-- Mostrar Resultado De Aprendizaje --}}
                                <td class="p-3 border-r border-slate-800/60 text-left text-slate-400">{{ Str::limit($d->resultadoAprendizaje->nombre ?? '', 30) }}</td>
                                {{-- Mostrar Horas "NO SE SABE PARA QUE SON ESTAS HORAS" --}}
                                {{-- TODO: MIRAR SI ESTE CAMPO DE HORAS SE DEJA O SE QUITA --}}
                                <td class="p-3 border-r border-slate-800/60 font-bold text-emerald-400">{{ $d->horas }}</td>
                                {{-- Mostrar Fecha Inicio --}}
                                <td class="p-3 border-r border-slate-800/60 whitespace-nowrap text-slate-400">{{ $d->fechaInicio }}</td>
                                {{-- Mostrar Fecha Fin --}}
                                <td class="p-3 border-r border-slate-800/60 whitespace-nowrap text-slate-400">{{ $d->fechaFin }}</td>
                                
                                {{-- SECCIÓN DE ACCIONES --}}
                                <td class="p-3">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- BTN DE EDITAR - MODAL --}}
                                        <button class="px-2.5 py-1 bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-white rounded-lg border border-amber-500/20 text-[11px] font-semibold transition-all" 
                                            @click="
                                                        editUrl = '{{ route('programaciones.detalles.update', $d) }}';
                                                        editData = {{ json_encode($d) }}; openEditModal = true;
                                                        editActi = '{{ $d->actividad_aprendizaje }}';
                                                        ">Editar
                                        </button>
                                        {{-- FIN - BTN DE EDITAR - MODAL --}}

                                        {{-- BTN DE ELIMINAR - MODAL --}}
                                        <form action="{{ route('programaciones.detalles.destroy', $d) }}" method="POST" onsubmit="return confirm('¿Eliminar registro?');">

                                            @csrf
                                            @method('DELETE')

                                            <button class="px-2.5 py-1 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg border border-rose-500/20 text-[11px] font-semibold transition-all" type="submit">
                                                Eliminar
                                            </button>

                                        </form>
                                        {{-- FIN - BTN DE ELIMINAR - MODAL --}}
                                        
                                    </div>

                                </td>
                                {{-- FIN - SECCIÓN DE ACCIONES --}}

                            </tr>

                        @empty
                            
                            {{-- EN CASO DE QUE NO HAYAN PROGRAMACIONES --}}
                            {{-- TODO: MIRAR SI ESTO ESTÁ HACIENDO ALGO --}}
                            <tr>
                                <td colspan="9" class="p-6 text-center text-slate-500">
                                    No hay registros para este mes. Haz clic en 
                                    <span class="text-cyan-400 font-semibold">"Agregar Registro"</span>.
                                </td>
                            </tr>

                        @endforelse
                        {{-- FIN DE LA CONDICIÓN --}}

                    </tbody>
                    {{-- FIN -- CUERPO DE LA TABLA --}}

                </table>
                {{-- FIN -- INICIO DE LA TABLA --}}

            </div>

        </div>
        <!-- FIN -- TABLA TIPO EXCEL -->

        <!-- TOTAL DE HORAS -->
        <div class="bg-slate-900/60 backdrop-blur-xl p-4 rounded-2xl shadow-xl border border-slate-800 flex justify-center items-center gap-4">

            <div class="bg-slate-950/60 border border-slate-800 px-5 py-2 rounded-xl font-semibold text-slate-400 uppercase text-xs tracking-wider">
                TOTAL HORAS MES
            </div>

            <div class="bg-cyan-950/30 border border-cyan-500/40 px-6 py-2 rounded-xl font-bold text-cyan-400 text-base shadow-[0_0_15px_rgba(6,182,212,0.15)] flex items-center gap-1.5">
                <span>{{ $programacion->detalles->sum('horas') }}</span>
                <span class="text-xs font-normal text-cyan-300/70">Horas</span>
            </div>

        </div>
        <!-- FIN -- TOTAL DE HORAS -->

        <!-- MODAL AGREGAR REGISTRO -->
        <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-2xl w-full space-y-4 relative overflow-hidden">

                {{-- TODO: Mirar si esto está haciendo algo o lo quitamos --}}
                {{-- <div class="absolute -top-10 -left-10 w-28 h-28 bg-cyan-500/10 rounded-full blur-xl pointer-events-none"></div> --}}

                {{-- Titulo de la programación --}}
                <h3 class="text-base font-bold text-slate-100 flex items-center gap-2 justify-center">Programación Mensual</h3>

                {{-- FORMULARIO DEL MODAL DE REGISTRO --}}
                <form action="{{ route('programaciones.detalles.store', ['programacion' => $programacion->getKey()]) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    
                    @csrf

                    {{-- SELECCIÓN DE FICHA --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Ficha</label>

                        <select name="numFicha" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            
                            <option value="" class="bg-slate-900 text-slate-500">Seleccionar Ficha</option>

                            @foreach ($fichas as $f)
                                <option value="{{ $f->numFicha }}" class="bg-slate-900 text-slate-100">{{ $f->numFicha }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- FIN - SELECCIÓN DE FICHA --}}

                    {{-- SELECCIÓN DE PROGRAMA --}}
                    <div>

                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Programa</label>

                        <select name="codPrograma" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            
                            <option value="" class="bg-slate-900 text-slate-500">Seleccionar Programa</option>
                            @foreach ($programas as $pr)
                                <option value="{{ $pr->codPrograma }}" class="bg-slate-900 text-slate-100">{{ $pr->nombre }}</option>
                            @endforeach

                        </select>

                    </div>
                    {{-- FIN - SELECCIÓN DE FICHA --}}
                    
                    {{-- SELECCIÓN DE COMPETENCIA --}}
                    <div x-data="{ horasCompetencia: '' }">

                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Competencia</label>


                        <select name="idCompetencia" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all"
                            @change="horasCompetencia = $event.target.options[$event.target.selectedIndex].dataset.horas || ''">

                            <option value="" class="bg-slate-900 text-slate-500">Seleccionar Competencia</option>

                            @foreach ($competencias as $c)
                                <option value="{{ $c->idCompetencia }}" data-horas="{{ $c->numHoras }}" class="bg-slate-900 text-slate-100">{{ $c->nombre }}</option>
                            @endforeach

                        </select>

                        {{-- Lugar donde se muestran las horas de las competencias --}}
                        <div x-show="horasCompetencia">
                            <p>Horas totales de la competencia:</p>
                            <p class="text-sm font-medium text-slate-300" x-text="horasCompetencia"></p>
                        </div>

                    </div>
                    {{-- FIN - SELECCIÓN DE COMPETENCIA --}}

                    {{-- SELECCIÓN DE RESULTADO DE APRENDIZAJE --}}
                    <div x-data="{ horasResultado: '' }">
                        
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Resultado de Aprendizaje</label>
                        
                        <select name="idResultadoAprendizaje" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all"
                            @change="horasResultado = $event.target.options[$event.target.selectedIndex].dataset.horas || ''">

                            <option value="" class="bg-slate-900 text-slate-500">Seleccionar Resultado</option>
                            
                            @foreach ($resultados as $r)
                                <option value="{{ $r->idResultadoAprendizaje }}" data-horas="{{ $r->horas }}" class="bg-slate-900 text-slate-100">{{ $r->nombre }}</option>
                            @endforeach

                        </select>

                        {{-- Lugar donde se muestran las horas de las competencias --}}
                        <div x-show="horasResultado">
                            <p>Horas totales del Resultado:</p>
                            <p class="text-sm font-medium text-slate-300" x-text="horasResultado"></p>
                        </div>

                    </div>
                    {{-- FIN - SELECCIÓN DE RESULTADO DE APRENDIZAJE --}}

                    {{-- SELECCIÓN DE ACTIVIDAD DE APRENDIZAJE --}}
                    <div class="md:col-span-2">
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Actividad de Aprendizaje</label>
                        <textarea name="actividad_aprendizaje" id="actividad_aprendizaje" rows="3" maxlength="700" class="form-control rounded-md border-gray-300 shadow-sm bg-white text-black" required></textarea>
                        <small class="text-muted">Máximo 700 caracteres.</small>
                    </div>
                    {{-- FIN - SELECCIÓN DE ACTIVIDAD DE APRENDIZAJE --}}

                    {{-- SELECCIÓN DE HORAS --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Horas</label>
                        <input type="number" name="horas" min="1" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- SELECCIÓN DE FECHA INICIO --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Fecha Inicio</label>
                        <input type="date" name="fechaInicio" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- SELECCIÓN DE FECHA FIN --}}
                    <div class="md:col-span-2">
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Fecha Fin</label>
                        <input type="date" name="fechaFin" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- SECCIÓN DE ACCIONES --}}
                    <div class="md:col-span-2 flex justify-end gap-3 pt-3">

                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold transition-colors">Cancelar</button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-medium rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all">Guardar</button>

                    </div>

                </form>
                {{-- FIN - FORMULARIO DEL MODAL DE REGISTRO --}}

            </div>
        </div>

        {{-- MODAL EDITAR REGISTRO --}}
        <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4" x-cloak>
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-2xl max-w-2xl w-full space-y-4 relative overflow-hidden">

                {{-- TODO: Mirar si esto sive para algo o lo quitamos --}}
                {{-- <div class="absolute -top-10 -left-10 w-28 h-28 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>--}} {{--  --}}

                {{-- TITULO GENERAL DEL MODAL DE EDICIÓN --}}
                <h3 class="text-base font-bold text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Programación
                </h3>
                {{-- FIN - TITULO GENERAL DEL MODAL DE EDICIÓN --}}

                {{-- FORMULARIO DEL MODAL DE EDITAR REGISTRO --}}
                <form :action="editUrl" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    
                    @csrf
                    @method('PUT')

                    {{-- EDITAR FICHA --}}
                    <div>

                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Ficha</label>

                        <select name="numFicha" x-model="editData.numFicha" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            @foreach ($fichas as $f)
                                <option value="{{ $f->numFicha }}" class="bg-slate-900 text-slate-100">{{ $f->numFicha }}</option>
                            @endforeach
                        </select>

                    </div>
                    {{-- FIN - EDITAR FICHA --}}

                    {{-- TODO: OJO CON ESTE POR QUE CREO QUE SE TIENE QUE QUITAR Y SOLO DEJAR PARA QUE SE PONGA POR EL TEMA DE LAS RELACIONES --}}
                    {{-- EDITAR PROGRAMA --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Programa</label>

                        <select name="codPrograma" x-model="editData.codPrograma" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            
                            @foreach ($programas as $pr)
                                <option value="{{ $pr->codPrograma }}" class="bg-slate-900 text-slate-100">
                                    {{ $pr->nombre }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                    {{-- FIN - EDITAR PROGRAMA --}}

                    {{-- EDITAR COMPETENECIA --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Competencia</label>
                        <select name="idCompetencia" x-model="editData.idCompetencia" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            
                            @foreach ($competencias as $c)
                                <option value="{{ $c->idCompetencia }}" class="bg-slate-900 text-slate-100">{{ $c->nombre }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- FIN - EDITAR COMPETENECIA --}}

                    {{-- EDITAR RESULTADO DE APRENDIZAJE --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Resultado de Aprendizaje</label>
                        <select name="idResultadoAprendizaje" x-model="editData.idResultadoAprendizaje" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                            
                            @foreach ($resultados as $r)
                                <option value="{{ $r->idResultadoAprendizaje }}" class="bg-slate-900 text-slate-100">{{ $r->nombre }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- FIN - EDITAR RESULTADO DE APRENDIZAJE --}}

                    {{-- EDITAR ACTIVIDAD DE APRENDIZAJE --}}
                    <div class="md:col-span-2">
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Actividad de Aprendizaje</label>
                        
                        <textarea name="actividad_aprendizaje" id="actividad_aprendizaje" x-model="editActi" rows="3" maxlength="700" class="form-control rounded-md border-gray-300 shadow-sm bg-white text-black" required></textarea>
                        <small class="text-muted">Máximo 700 caracteres.</small>
                    </div>
                    {{-- FIN - EDITAR ACTIVIDAD DE APRENDIZAJE --}}

                    {{-- EDITAR HORAS --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Horas</label>
                        <input type="number" name="horas" x-model="editData.horas" min="1" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- EDITAR FECHA INICIO --}}
                    <div>
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Fecha Inicio</label>
                        <input type="date" name="fechaInicio" x-model="editData.fechaInicio" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- EDITAR FECHA FIN --}}
                    <div class="md:col-span-2">
                        <label class="block font-semibold text-slate-300 uppercase tracking-wider mb-1">Fecha Fin</label>
                        <input type="date" name="fechaFin" x-model="editData.fechaFin" required class="w-full bg-slate-950/60 border border-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 rounded-xl px-3 py-2 text-slate-100 transition-all">
                    </div>

                    {{-- SECCIÓN DE ACCIONES | BTN DE "CANCELAR" Y "ACTUALIZAR" --}}
                    <div class="md:col-span-2 flex justify-end gap-3 pt-3">
                        
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold transition-colors">Cancelar</button>
                        <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl shadow-[0_0_15px_rgba(245,158,11,0.3)] transition-all">Actualizar</button>
                    
                    </div>

                </form>
                {{-- FIN - FORMULARIO DEL MODAL DE EDITAR REGISTRO --}}
            
            </div>

        </div>
        {{-- FIN - MODAL EDITAR REGISTRO --}}

    </div>
</x-app-layout>