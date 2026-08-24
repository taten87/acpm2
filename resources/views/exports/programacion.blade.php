<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table>
        <!-- Título Principal -->
        <tr>
            <td colspan="8" align="center" style="font-size: 14pt; font-weight: bold; background-color: #047857; color: #ffffff; height: 35px; vertical-align: middle;">
                REPORTE MENSUAL DE PROGRAMACIÓN DE INSTRUCTOR
            </td>
        </tr>
        <tr><td colspan="8"></td></tr>

        <!-- Datos del Instructor y Mes -->
        <tr>
            <td style="font-weight: bold; background-color: #E5E7EB; border: 1px solid #CCCCCC;">Instructor:</td>
            <td colspan="3" style="border: 1px solid #CCCCCC;">{{ $instructor->name }}</td>
            <td style="font-weight: bold; background-color: #E5E7EB; border: 1px solid #CCCCCC;">Mes:</td>
            <td colspan="3" style="border: 1px solid #CCCCCC;">{{ $mes }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #E5E7EB; border: 1px solid #CCCCCC;">Documento:</td>
            <td colspan="3" style="border: 1px solid #CCCCCC;" align="left">{{ $instructor->documento }}</td>
            <td style="font-weight: bold; background-color: #E5E7EB; border: 1px solid #CCCCCC;">Correo:</td>
            <td colspan="3" style="border: 1px solid #CCCCCC;" align="left">{{ $instructor->email }}</td>
        </tr>
        <tr><td colspan="8"></td></tr>

        <!-- Encabezados de la Tabla -->
        <thead>
            <tr>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000; height: 25px;">Ficha</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Programa</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Actividad de Proyecto</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Competencia</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Resultado de Aprendizaje</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Horas Ejecutadas</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Fecha Inicio</th>
                <th style="font-weight: bold; background-color: #047857; color: #ffffff; text-align: center; border: 1px solid #000000;">Fecha Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programaciones as $index => $p)
                <tr>
                    <td align="center" style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->numFicha }}</td>
                    <td style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->programa?->nombre ?? $p->codPrograma }}</td>
                    <td style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->actividadproyecto?->descripcion ?? $p->idActividadProyecto }}</td>
                    <td style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->competencia?->nombre ?? $p->idCompetencia }}</td>
                    <td style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->resultadoaprendizaje?->nombre ?? $p->idResultadoAprendizaje }}</td>
                    <td align="right" style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->horas }} Hrs</td>
                    <td align="center" style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->fechaInicio }}</td>
                    <td align="center" style="border: 1px solid #CCCCCC; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F9FAFB' }};">{{ $p->fechaFin }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="right" style="font-weight: bold; background-color: #D1FAE5; border: 1px solid #047857;">TOTAL HORAS MES:</td>
                <td align="right" style="font-weight: bold; background-color: #D1FAE5; border: 1px solid #047857;">{{ $programaciones->sum('horas') }} Hrs</td>
                <td colspan="2" style="background-color: #D1FAE5; border: 1px solid #047857;"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>