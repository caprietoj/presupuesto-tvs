<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Budget') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <label for="table-navigator" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por tabla:</label>
                        <select id="table-navigator" class="block w-full max-w-xs px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Mostrar todas las tablas</option>
                            <option value="resumen">RESUMEN</option>
                            <option value="ingresos">INGRESOS</option>
                            <option value="gastos">GASTOS</option>
                            <option value="ingresos-escolares">INGRESOS ESCOLARES</option>
                            <option value="otros-escolares">OTROS ESCOLARES</option>
                            <option value="salarios-academia">SALARIOS ACADEMIA</option>
                            <option value="salarios-administracion">SALARIOS ADMINISTRACIÓN</option>
                            <option value="rubros-institucionales">RUBROS INSTITUCIONALES</option>
                            <option value="membresias-convenios">MEMBRESIAS Y CONVENIOS</option>
                            <option value="servicios-publicos">SERVICIOS PUBLICOS</option>
                            <option value="otros-egresos">OTROS EGRESOS</option>
                            <option value="contratos-externos">CONTRATOS EXTERNOS</option>
                            <option value="secciones-academia-general">SECCIONES ACADEMIA GENERAL</option>
                            <option value="contratos-externos">CONTRATOS EXTERNOS</option>
                        </select>
                    </div>
                    <div class="budget-section filter-resumen" data-filter-category="resumen">
                        <h5 id="table-resumen">RESUMEN</h5>
                        <div class="table-wrapper">
                            <table id="resumen-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>TOTAL INGRESOS</strong></td>
                                        <td class="number-cell">$12.856.980.087</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosPorMes['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>UTILIDAD CAFETERIA</strong></td>
                                        <td class="number-cell">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['junio'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['julio'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['agosto'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['septiembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['octubre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['noviembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['diciembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['enero'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_cafeteria']['febrero'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_cafeteria" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['utilidad_cafeteria']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>UTILIDAD TRANSPORTE</strong></td>
                                        <td class="number-cell">${{ number_format($resumenDatosPorMes['utilidad_transporte']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['junio'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['julio'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['agosto'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['septiembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['octubre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['noviembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['diciembre'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['enero'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell {{ $resumenDatosPorMes['utilidad_transporte']['febrero'] < 0 ? 'negative-value' : '' }}" data-tipo="utilidad_transporte" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['utilidad_transporte']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ACTIVIDADES CURRICULARES</strong></td>
                                        <td class="number-cell">${{ number_format($resumenDatosPorMes['actividades_curriculares']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="actividades_curriculares" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($resumenDatosPorMes['actividades_curriculares']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL EGRESOS</strong></td>
                                        <td class="number-cell">$14.104.459.233</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($egresosPorMes['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL INGRESOS - GASTOS</strong></td>
                                        <td class="number-cell negative-value"><strong>$-1.247.479.146</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($utilidadPorMes['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-ingresos">RESUMEN INGRESOS</h5>
                        <div class="table-wrapper">
                            <table id="ingresos-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>INGRESOS ESCOLARES</strong></td>
                                        <td class="number-cell">$10.487.847.718</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['junio']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['julio']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['agosto']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['septiembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['octubre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['noviembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['diciembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['enero']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($ingresosEscolaresPorMes['febrero']['total'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INGRESOS OTROS ESCOLARES</strong></td>
                                        <td class="number-cell">$2.369.132.369</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['junio']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['julio']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['agosto']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['septiembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['octubre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['noviembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['diciembre']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['enero']['total'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['febrero']['total'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL INGRESOS</strong></td>
                                        <td class="number-cell"><strong>$12.856.980.087</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($ingresosPorMes['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-gastos">RESUMEN DE GASTOS</h5>
                        <div class="table-wrapper">
                            <table id="gastos-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>TOTAL SALARIOS, PRESTACIONES ACADEMIA</strong></td>
                                        <td class="number-cell">$6.600.720.784</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['junio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['julio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['agosto']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['septiembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['octubre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['noviembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['diciembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['enero']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAcademiaGeneralPorMes['febrero']['total'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL SALARIOS, PRESTACIONES ADMINISTRATIVOS Y SENA</strong></td>
                                        <td class="number-cell">$1.453.226.337</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['junio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['julio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['agosto']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['septiembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['octubre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['noviembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['diciembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['enero']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($salariosAdministracionPorMes['febrero']['total'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL RUBROS INSTITUCIONALES</strong></td>
                                        <td class="number-cell">$1.172.440.107</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['junio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['julio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['agosto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['septiembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['octubre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['noviembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['diciembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['enero'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['total']['febrero'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL SECCION ACADEMIA</strong></td>
                                        <td class="number-cell">$441.271.150</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['total'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['total'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL SERVICIOS PÚBLICOS Y OTROS EGRESOS</strong></td>
                                        <td class="number-cell">$2.594.069.715</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['junio'] ?? 0) + ($otrosEgresosPorMes['total']['junio'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['julio'] ?? 0) + ($otrosEgresosPorMes['total']['julio'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['agosto'] ?? 0) + ($otrosEgresosPorMes['total']['agosto'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['septiembre'] ?? 0) + ($otrosEgresosPorMes['total']['septiembre'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['octubre'] ?? 0) + ($otrosEgresosPorMes['total']['octubre'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['noviembre'] ?? 0) + ($otrosEgresosPorMes['total']['noviembre'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['diciembre'] ?? 0) + ($otrosEgresosPorMes['total']['diciembre'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['enero'] ?? 0) + ($otrosEgresosPorMes['total']['enero'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format(($serviciosPublicosPorMes['total']['febrero'] ?? 0) + ($otrosEgresosPorMes['total']['febrero'] ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL COSTOS CONTRATOS EXTERNOS</strong></td>
                                        <td class="number-cell">$1.831.454.774</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['junio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['julio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['agosto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['septiembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['octubre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['noviembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['diciembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['enero'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['total']['febrero'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL GASTOS</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($presupuestoEgresos, 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($egresosPorMes['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-ingresos-escolares">INGRESOS ESCOLARES</h5>
                        <div class="table-wrapper">
                            <table id="ingresos-escolares-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>MATRICULAS</strong></td>
                                        <td class="number-cell">$979.804.763</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['matriculas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="matriculas" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['matriculas'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PENSIONES</strong></td>
                                        <td class="number-cell">$8.816.286.570</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['pensiones'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pensiones" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['pensiones'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>SEGUROS ESTUDIANTILES</strong></td>
                                        <td class="number-cell">$33.922.844</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="seguros_estudiantiles" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['seguros_estudiantiles'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DESARROLLO CURRICULAR BILINGÜE / BIBLIOBANCO</strong></td>
                                        <td class="number-cell">$443.731.218</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="desarrollo_curricular" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['desarrollo_curricular'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>SISTEMATIZACIÓN DE NOTAS</strong></td>
                                        <td class="number-cell">$98.936.742</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="sistematizacion_notas" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['sistematizacion_notas'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MATERIALES GENERALES</strong></td>
                                        <td class="number-cell">$115.165.581</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['junio']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['julio']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['agosto']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['septiembre']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['octubre']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['noviembre']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($ingresosEscolaresPorMes['diciembre']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['enero']['materiales_generales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_generales" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($ingresosEscolaresPorMes['febrero']['materiales_generales'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL INGRESOS ESCOLARES</strong></td>
                                        <td class="number-cell"><strong>$10.487.847.718</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['junio']['matriculas'] + 
                                            $ingresosEscolaresPorMes['junio']['pensiones'] + 
                                            $ingresosEscolaresPorMes['junio']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['junio']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['junio']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['junio']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['julio']['matriculas'] + 
                                            $ingresosEscolaresPorMes['julio']['pensiones'] + 
                                            $ingresosEscolaresPorMes['julio']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['julio']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['julio']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['julio']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['agosto']['matriculas'] + 
                                            $ingresosEscolaresPorMes['agosto']['pensiones'] + 
                                            $ingresosEscolaresPorMes['agosto']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['agosto']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['agosto']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['agosto']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['septiembre']['matriculas'] + 
                                            $ingresosEscolaresPorMes['septiembre']['pensiones'] + 
                                            $ingresosEscolaresPorMes['septiembre']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['septiembre']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['septiembre']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['septiembre']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['octubre']['matriculas'] + 
                                            $ingresosEscolaresPorMes['octubre']['pensiones'] + 
                                            $ingresosEscolaresPorMes['octubre']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['octubre']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['octubre']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['octubre']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['noviembre']['matriculas'] + 
                                            $ingresosEscolaresPorMes['noviembre']['pensiones'] + 
                                            $ingresosEscolaresPorMes['noviembre']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['noviembre']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['noviembre']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['noviembre']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['diciembre']['matriculas'] + 
                                            $ingresosEscolaresPorMes['diciembre']['pensiones'] + 
                                            $ingresosEscolaresPorMes['diciembre']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['diciembre']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['diciembre']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['diciembre']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['enero']['matriculas'] + 
                                            $ingresosEscolaresPorMes['enero']['pensiones'] + 
                                            $ingresosEscolaresPorMes['enero']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['enero']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['enero']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['enero']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(
                                            $ingresosEscolaresPorMes['febrero']['matriculas'] + 
                                            $ingresosEscolaresPorMes['febrero']['pensiones'] + 
                                            $ingresosEscolaresPorMes['febrero']['seguros_estudiantiles'] + 
                                            $ingresosEscolaresPorMes['febrero']['desarrollo_curricular'] + 
                                            $ingresosEscolaresPorMes['febrero']['sistematizacion_notas'] + 
                                            $ingresosEscolaresPorMes['febrero']['materiales_generales'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-otros-escolares">OTROS ESCOLARES</h5>
                        <div class="table-wrapper">
                            <table id="otros-escolares-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>RENDIMIENTOS/INTERESES MORA/CERTIFICADOS</strong></td>
                                        <td class="number-cell">$114.862.936</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="rendimientos_intereses" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['rendimientos_intereses'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>AGENDA ESCOLAR</strong></td>
                                        <td class="number-cell">$9.252.798</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['agenda_escolar'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agenda_escolar" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['agenda_escolar'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ANUARIO</strong></td>
                                        <td class="number-cell">$38.371.950</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['anuario'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="anuario" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['anuario'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>EXAMENES DE ADMISIÓN</strong></td>
                                        <td class="number-cell">$6.424.511</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['examenes_admision'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_admision" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['examenes_admision'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INGRESOS POR SERVICIO DE CAFETERIA</strong></td>
                                        <td class="number-cell">$700.126.312</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_cafeteria" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['servicio_cafeteria'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INGRESOS SERVICIO DE TRANSPORTE</strong></td>
                                        <td class="number-cell">$1.500.093.862</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['junio']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['julio']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['agosto']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['septiembre']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['octubre']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['noviembre']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEscolaresPorMes['diciembre']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['enero']['servicio_transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="servicio_transporte" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEscolaresPorMes['febrero']['servicio_transporte'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL INGRESOS OTROS ESCOLARES</strong></td>
                                        <td class="number-cell"><strong>$2.369.132.369</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['junio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['julio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['agosto']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['septiembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['octubre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['noviembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['diciembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['enero']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEscolaresPorMes['febrero']['total'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">18,42%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['junio']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['julio']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['agosto']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['septiembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['octubre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['noviembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['diciembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['enero']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($otrosEscolaresPorMes['febrero']['impacto'], 2, ',', '.') }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-salarios-academia">SALARIOS Y PRESTACIONES SOCIALES ACADEMIA</h5>
                        <div class="table-wrapper">
                            <table id="salarios-academia-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>SALARIOS Y PRESTACIONES SOCIALES ACADEMIA</strong></td>
                                        <td class="number-cell">$6.600.720.784</td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="6" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['junio']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="7" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['julio']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="8" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['agosto']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="9" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['septiembre']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="10" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['octubre']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="11" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['noviembre']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="12" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['diciembre']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="1" 
                                            data-year="{{ date('Y') + 1 }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['enero']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_academia" 
                                            data-mes="2" 
                                            data-year="{{ date('Y') + 1 }}">
                                            ${{ number_format($salariosAcademiaGeneralPorMes['febrero']['salarios_academia'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL SALARIOS Y PRESTACIONES SOCIALES ACADEMIA</strong></td>
                                        <td class="number-cell"><strong>$6.600.720.784</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['junio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['julio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['agosto']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['septiembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['octubre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['noviembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['diciembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['enero']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAcademiaGeneralPorMes['febrero']['total'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr class="impact-row">
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell"><strong>51,34%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['junio']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['julio']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['agosto']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['septiembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['octubre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['noviembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['diciembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['enero']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAcademiaGeneralPorMes['febrero']['impacto'], 2) }}%</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-salarios-administracion">SALARIOS Y PRESTACIONES SOCIALES ADMINISTRACION</h5>
                        <div class="table-wrapper">
                            <table id="salarios-administracion-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>SALARIOS Y AUX DE TRANSPORTE- ADMINISTRACIÓN Y SERVICIOS GENERALES</strong></td>
                                        <td class="number-cell">$1.453.226.337</td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="6" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['junio']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="7" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['julio']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="8" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['agosto']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="9" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['septiembre']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="10" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['octubre']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="11" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['noviembre']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="12" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['diciembre']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="1" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['enero']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                        <td class="number-cell clickable-cell" 
                                            data-tipo="salarios_transporte" 
                                            data-mes="2" 
                                            data-year="{{ date('Y') }}">
                                            ${{ number_format($salariosAdministracionPorMes['febrero']['salarios_transporte'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL SALARIOS Y PRESTACIONES SOCIALES ADMINISTRACION</strong></td>
                                        <td class="number-cell"><strong>$1.453.226.337</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['junio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['julio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['agosto']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['septiembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['octubre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['noviembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['diciembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['enero']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($salariosAdministracionPorMes['febrero']['total'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr class="impact-row">
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell"><strong>11,30%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['junio']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['julio']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['agosto']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['septiembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['octubre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['noviembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['diciembre']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['enero']['impacto'], 2) }}%</strong></td>
                                        <td class="number-cell"><strong>{{ number_format($salariosAdministracionPorMes['febrero']['impacto'], 2) }}%</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-rubros-institucionales">RUBROS INSTITUCIONALES</h5>
                        <div class="table-wrapper">
                            <table id="rubros-institucionales-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>EQUIPOS Y DOTACION SALONES Y/O OFICINAS</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['equipos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="equipos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['equipos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>EXAMENES MÉDICOS (PERIODICOS Y DE CONTRATACION)</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="examenes_medicos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['examenes_medicos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TECNOLOGIA INSTITUCIONAL</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="tecnologia_institucional" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['tecnologia_institucional']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSUMOS ENFERMERIA ESCOLAR</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_enfermeria" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['insumos_enfermeria']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MERCADEO Y ADMISIONES</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mercadeo_admisiones" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['mercadeo_admisiones']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>EVENTOS INSTITUCIONALES DE COMUNIDAD</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_comunidad" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_comunidad']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MANTENIMIENTO GENERAL</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mantenimiento_general" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['mantenimiento_general']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>REPARACIONES MAYORES (CONSTRUCCIONES)</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparaciones_mayores" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['reparaciones_mayores']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>REPARACIÓN DE MUEBLES</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="reparacion_muebles" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['reparacion_muebles']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>UTILES DE OFICINA Y PAPELERIA (ABKA)</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="utiles_oficina" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['utiles_oficina']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ELEMENTOS DE ASEO Y CAFETERIA</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="elementos_aseo" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['elementos_aseo']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DOTACIÓN DE TRABAJO</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dotacion_trabajo" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['dotacion_trabajo']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>GASTOS DE AGASAJOS</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_agasajos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_agasajos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>BIENESTAR INSTITUCIONAL</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bienestar_institucional" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['bienestar_institucional']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>EVENTOS INSTITUCIONALES INTERNOS</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="eventos_internos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['eventos_internos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>GASTOS DE CONTRATACIÓN (PRUEBAS PSICOTECNICAS, PLATAFORMA DE COMPUTRABAJO, VISITAS Y POLIGRAFOS, ANUNCIOS EMPLEO)</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="gastos_contratacion" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['gastos_contratacion']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>AFILIACIONES E INSCRIPCIONES</strong></td>
                                        <td class="number-cell">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="afiliaciones_inscripciones" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($rubrosInstitucionalesPorMes['afiliaciones_inscripciones']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL INSTITUCIONAL</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['presupuesto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($rubrosInstitucionalesPorMes['total']['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['presupuesto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['junio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['julio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['agosto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['septiembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['octubre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['noviembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['diciembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['enero'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($rubrosInstitucionalesPorMes['impacto']['febrero'], 1) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-membresias-convenios">MEMBRESIAS Y CONVENIOS</h5>
                        <div class="table-wrapper">
                            <table id="membresias-convenios-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>BACHILLERATO INTERNACIONAL</strong></td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="bachillerato_internacional" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($membresiasYConveniosPorMes['bachillerato_internacional']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ACCBI</strong></td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['presupuesto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['junio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['julio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['agosto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['septiembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['octubre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['noviembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['diciembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['enero'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['accbi']['febrero'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>RED PAPAZ</strong></td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['presupuesto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['junio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['julio'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['agosto'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['septiembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['octubre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['noviembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['diciembre'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['enero'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($membresiasYConveniosPorMes['red_papaz']['febrero'] ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL MEMBRESIAS Y CONVENIOS</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['presupuesto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($membresiasYConveniosPorMes['total']['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['presupuesto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['junio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['julio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['agosto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['septiembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['octubre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['noviembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['diciembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['enero'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($membresiasYConveniosPorMes['impacto']['febrero'], 1) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-servicios-publicos">SERVICIOS PUBLICOS</h5>
                        <div class="table-wrapper">
                            <table id="servicios-publicos-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>AGUA</strong></td>
                                        <td class="number-cell">${{ number_format($serviciosPublicosPorMes['agua']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['agua']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['agua']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="agua" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['agua']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ENERGIA</strong></td>
                                        <td class="number-cell">${{ number_format($serviciosPublicosPorMes['energia']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['energia']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['energia']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="energia" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['energia']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TELÉFONO</strong></td>
                                        <td class="number-cell">${{ number_format($serviciosPublicosPorMes['telefono']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['telefono']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['telefono']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="telefono" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['telefono']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>VIGILANCIA (METROS CUADRADOS PORTERO)</strong></td>
                                        <td class="number-cell">${{ number_format($serviciosPublicosPorMes['vigilancia']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="vigilancia" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['vigilancia']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INTERNET/ ARRENDAMIENTOS TECNOLÓGICOS</strong></td>
                                        <td class="number-cell">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="internet_arrendamientos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($serviciosPublicosPorMes['internet_arrendamientos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL SERVICIOS PUBLICOS</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['presupuesto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($serviciosPublicosPorMes['total']['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['presupuesto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['junio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['julio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['agosto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['septiembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['octubre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['noviembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['diciembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['enero'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($serviciosPublicosPorMes['impacto']['febrero'], 1) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-otros-egresos">OTROS EGRESOS</h5>
                        <div class="table-wrapper">
                            <table id="otros-egresos-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>HONORARIOS</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['honorarios']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['honorarios']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['honorarios']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="honorarios" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['honorarios']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>LEGALES (SANCIONES UGPP) CÁMARA DE COMERCIO</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['legales_sanciones']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="legales_sanciones" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['legales_sanciones']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>COMISIONES BANCARIAS</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="comisiones_bancarias" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['comisiones_bancarias']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MENSAJERÍA Y ACARREOS</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="mensajeria_acarreos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['mensajeria_acarreos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPTO DE INDUSTRIA Y COMERCIO</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_industria_comercio" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['impto_industria_comercio']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PLAN DE SEGURIDAD Y SALUD EN EL TRABAJO</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="plan_seguridad_salud" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['plan_seguridad_salud']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>OTROS EGRESOS RETENCIÓN</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="otros_egresos_retencion" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['otros_egresos_retencion']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPTO DE RENTA</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['impto_renta']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['impto_renta']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['impto_renta']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="impto_renta" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['impto_renta']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>ARRENDAMIENTOS</strong></td>
                                        <td class="number-cell">${{ number_format($otrosEgresosPorMes['arrendamientos']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['junio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['julio'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['agosto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['septiembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['octubre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['noviembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['diciembre'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['enero'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="arrendamientos" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($otrosEgresosPorMes['arrendamientos']['febrero'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL OTROS EGRESOS</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['presupuesto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($otrosEgresosPorMes['total']['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['presupuesto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['junio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['julio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['agosto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['septiembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['octubre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['noviembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['diciembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['enero'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($otrosEgresosPorMes['impacto']['febrero'], 1) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-contratos-externos">CONTRATOS EXTERNOS</h5>
                        <div class="table-wrapper">
                            <table id="contratos-externos-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>CAFETERÍA</strong></td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['cafeteria']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['junio']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['julio']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['agosto']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['septiembre']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['octubre']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['noviembre']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['diciembre']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($contratosExternosPorMes['enero']['cafeteria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="cafeteria" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($contratosExternosPorMes['febrero']['cafeteria'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TRANSPORTE</strong></td>
                                        <td class="number-cell">${{ number_format($contratosExternosPorMes['transporte']['presupuesto'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['junio']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['julio']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['agosto']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['septiembre']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['octubre']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['noviembre']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($contratosExternosPorMes['diciembre']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($contratosExternosPorMes['enero']['transporte'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="transporte" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($contratosExternosPorMes['febrero']['transporte'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL CONTRATOS EXTERNOS</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['presupuesto']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['junio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['julio'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['agosto'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['septiembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['octubre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['noviembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['diciembre'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['enero'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($contratosExternosPorMes['total']['febrero'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['presupuesto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['junio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['julio'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['agosto'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['septiembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['octubre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['noviembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['diciembre'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['enero'], 1) }}%</td>
                                        <td class="number-cell">{{ number_format($contratosExternosPorMes['impacto']['febrero'], 1) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="budget-section filter-resumen" data-filter-category="resumen" style="margin-top: 2rem;">
                        <h5 id="table-secciones-academia-general">SECCIONES ACADEMIA GENERAL</h5>
                        <div class="table-wrapper">
                            <table id="secciones-academia-general-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>RESUMEN</th>
                                        <th>PRESUPUESTO APROBADO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>CAPACITACIÓN Y ADMINISTRACIÓN</strong></td>
                                        <td class="number-cell">${{ number_format(41682742, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="capacitacion_administracion" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['capacitacion_administracion'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MATERIAL IMPORTADO</strong></td>
                                        <td class="number-cell">${{ number_format(82399932, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['material_importado'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_importado" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['material_importado'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>BIBLIOTECA INSTITUCIONAL</strong></td>
                                        <td class="number-cell">${{ number_format(29456000, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="biblioteca_institucional" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['biblioteca_institucional'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MATERIALES PARA CLASES</strong></td>
                                        <td class="number-cell">${{ number_format(23461272, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['materiales_clases'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="materiales_clases" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['materiales_clases'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MATERIAL DEPORTIVO</strong></td>
                                        <td class="number-cell">${{ number_format(12613480, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['material_deportivo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="material_deportivo" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['material_deportivo'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>MUSICALES</strong></td>
                                        <td class="number-cell">${{ number_format(8129357, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['musicales'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="musicales" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['musicales'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PART TIME TEACHER- REEMPLAZOS</strong></td>
                                        <td class="number-cell">${{ number_format(4970700, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['part_time_teacher'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="part_time_teacher" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['part_time_teacher'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSUMOS INSTITUCIONALES DE SECCIÓN (TECNOLOGÍA)</strong></td>
                                        <td class="number-cell">${{ number_format(68800800, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="insumos_tecnologia" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['insumos_tecnologia'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PEP</strong></td>
                                        <td class="number-cell">${{ number_format(5271684, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['pep'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pep" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['pep'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DP</strong></td>
                                        <td class="number-cell">$0</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['dp'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="dp" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['dp'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PAI</strong></td>
                                        <td class="number-cell">${{ number_format(11309000, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['pai'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="pai" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['pai'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DEPARTAMENTO DE APOYO</strong></td>
                                        <td class="number-cell">$0</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['departamento_apoyo'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="departamento_apoyo" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['departamento_apoyo'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>CONSEJERÍA UNIVERSITARIA</strong></td>
                                        <td class="number-cell">${{ number_format(16000000, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="consejeria_universitaria" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['consejeria_universitaria'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>DIRECCIÓN GENERAL</strong></td>
                                        <td class="number-cell">${{ number_format(27308870, 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="6" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="7" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="8" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="9" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="10" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="11" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="12" data-year="{{ date('Y') }}">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="1" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['direccion_general'], 0, ',', '.') }}</td>
                                        <td class="number-cell clickable-cell" data-tipo="direccion_general" data-mes="2" data-year="{{ date('Y') + 1 }}">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['direccion_general'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL SECCIONES ACADEMIA GENERAL</strong></td>
                                        <td class="number-cell"><strong>${{ number_format(331403837, 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['junio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['julio']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['enero']['total'], 0, ',', '.') }}</strong></td>
                                        <td class="number-cell"><strong>${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['total'], 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>IMPACTO % FRENTE A INGRESOS TOTALES</strong></td>
                                        <td class="number-cell">2.58%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['junio']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['julio']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['agosto']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['septiembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['octubre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['noviembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['diciembre']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['enero']['impacto'], 2, ',', '.') }}%</td>
                                        <td class="number-cell">${{ number_format($seccionesAcademiaGeneralPorMes['febrero']['impacto'], 2, ',', '.') }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar detalles -->
    <div id="detalle-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Detalle del Ingreso</h3>
                <button class="modal-close" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="modal-loading" style="text-align: center; padding: 2rem;">
                    <div class="loading-spinner"></div>
                    <p>Cargando datos...</p>
                </div>
                <div id="modal-content-body" style="display: none;">
                    <div id="modal-summary" style="margin-bottom: 1rem; padding: 1rem; background-color: #f9fafb; border-radius: 6px;">
                        <p><strong>Concepto:</strong> <span id="summary-concepto"></span></p>
                        <p><strong>Período:</strong> <span id="summary-periodo"></span></p>
                        <p><strong>Total:</strong> <span id="summary-total"></span></p>
                        <p><strong>Registros encontrados:</strong> <span id="summary-count"></span></p>
                    </div>
                    <div id="detalle-tabla-container">
                        <table class="detail-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Documento</th>
                                    <th>Descripción</th>
                                    <th>Centro Costo</th>
                                    <th>Cuenta</th>
                                    <th class="amount">Valor</th>
                                </tr>
                            </thead>
                            <tbody id="detalle-tabla-body">
                            </tbody>
                        </table>
                    </div>
                    <div id="no-data-message" style="text-align: center; padding: 2rem; display: none;">
                        <p>No se encontraron registros para el período seleccionado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Esperar a que se cargue jQuery desde app.js
        window.addEventListener('DOMContentLoaded', function() {
            // Verificar si jQuery está disponible antes de usar DataTables
            function initDataTables() {
                if (typeof $ !== 'undefined' && $.fn.DataTable) {
                    $('#resumen-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#ingresos-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#gastos-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#ingresos-escolares-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#otros-escolares-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#salarios-academia-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#salarios-administracion-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#rubros-institucionales-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#membresias-convenios-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#servicios-publicos-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#otros-egresos-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#secciones-academia-general-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                    $('#contratos-externos-table').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": false,
                        "responsive": true
                    });
                } else {
                    // Si jQuery no está disponible, reintentar después de un breve delay
                    setTimeout(initDataTables, 100);
                }
            }

            // Inicializar DataTables
            initDataTables();

            // Filtro para mostrar/ocultar tablas
            document.getElementById('table-navigator').addEventListener('change', function(event) {
                var selectedTable = event.target.value;
                
                // Obtener todas las secciones budget
                var allSections = document.querySelectorAll('.budget-section');
                
                if (selectedTable === '') {
                    // Mostrar todas las tablas
                    allSections.forEach(function(section) {
                        section.style.display = 'block';
                    });
                } else {
                    // Ocultar todas las secciones
                    allSections.forEach(function(section) {
                        section.style.display = 'none';
                    });
                    
                    // Mostrar solo la tabla seleccionada
                    var targetTable = document.getElementById(selectedTable + '-table');
                    if (targetTable) {
                        // Encontrar la sección padre que contiene la tabla
                        var parentSection = targetTable.closest('.budget-section');
                        if (parentSection) {
                            parentSection.style.display = 'block';
                        }
                    }
                }
            });

            // Agregar event listeners para celdas clicables
            document.querySelectorAll('.clickable-cell').forEach(function(cell) {
                cell.addEventListener('click', function() {
                    var tipo = this.getAttribute('data-tipo');
                    var mes = this.getAttribute('data-mes');
                    var year = this.getAttribute('data-year');
                    mostrarDetalle(tipo, mes, year);
                });
            });
        });

        function mostrarDetalle(tipo, mes, year) {
            // Configurar nombres de tipos para mostrar
            var nombresTipos = {
                'matriculas': 'Matrículas',
                'pensiones': 'Pensiones',
                'seguros_estudiantiles': 'Seguros Estudiantiles',
                'desarrollo_curricular': 'Desarrollo Curricular Bilingüe / Bibliobanco',
                'sistematizacion_notas': 'Sistematización de Notas',
                'materiales_generales': 'Materiales Generales',
                'capacitacion_administracion': 'Capacitación y Administración',
                'material_importado': 'Material Importado',
                'biblioteca_institucional': 'Biblioteca Institucional',
                'materiales_clases': 'Materiales para Clases',
                'material_deportivo': 'Material Deportivo',
                'musicales': 'Musicales',
                'part_time_teacher': 'Part Time Teacher - Reemplazos',
                'insumos_tecnologia': 'Insumos Institucionales de Sección (Tecnología)',
                'pep': 'PEP',
                'dp': 'DP',
                'pai': 'PAI',
                'departamento_apoyo': 'Departamento de Apoyo',
                'consejeria_universitaria': 'Consejeria Universitaria',
                'direccion_general': 'Dirección General',
                'rendimientos_intereses': 'Rendimientos/Intereses Mora/Certificados',
                'agenda_escolar': 'Agenda Escolar',
                'anuario': 'Anuario',
                'examenes_admision': 'Examenes de Admisión',
                'servicio_cafeteria': 'Ingresos por Servicio de Cafetería',
                'servicio_transporte': 'Ingresos Servicio de Transporte',
                'salarios_academia': 'Salarios y Prestaciones Sociales Academia',
                'salarios_transporte': 'Salarios y Aux de Transporte - Administración y Servicios Generales',
                'capacitacion_admin': 'Capacitación Administración',
                'aprendices_sena': 'Aprendices SENA',
                'equipos': 'Equipos',
                'examenes_medicos': 'Exámenes Médicos',
                'tecnologia_institucional': 'Tecnología Institucional',
                'insumos_enfermeria': 'Insumos Enfermería Escolar',
                'mercadeo_admisiones': 'Mercadeo y Admisiones',
                'eventos_comunidad': 'Eventos Institucionales de Comunidad',
                'mantenimiento_general': 'Mantenimiento General',
                'reparaciones_mayores': 'Reparaciones Mayores (Construcciones)',
                'reparacion_muebles': 'Reparación de Muebles y Enseres',
                'utiles_oficina': 'Útiles de Oficina',
                'elementos_aseo': 'Elementos de Aseo',
                'gastos_agasajos': 'Gastos de Agasajos',
                'bienestar_institucional': 'Bienestar Institucional',
                'eventos_internos': 'Eventos Institucionales Internos',
                'gastos_contratacion': 'Gastos de Contratación',
                'afiliaciones_inscripciones': 'Afiliaciones e Inscripciones',
                'bachillerato_internacional': 'Bachillerato Internacional',
                'agua': 'Agua',
                'energia': 'Energía',
                'telefono': 'Teléfono',
                'vigilancia': 'Vigilancia (METROS CUADRADOS PORTERO)',
                'internet_arrendamientos': 'Internet/ Arrendamientos Tecnológicos',
                'honorarios': 'Honorarios',
                'legales_sanciones': 'Legales (Sanciones UGPP) Cámara de Comercio',
                'comisiones_bancarias': 'Comisiones Bancarias',
                'mensajeria_acarreos': 'Mensajería y Acarreos',
                'impto_industria_comercio': 'Impto de Industria y Comercio',
                'plan_seguridad_salud': 'Plan de Seguridad y Salud en el Trabajo',
                'otros_egresos_retencion': 'Otros Egresos Retención',
                'impto_renta': 'Impto de Renta',
                'arrendamientos': 'Arrendamientos',
                'capacitacion_administracion': 'Capacitación y Administración',
                'material_importado': 'Material Importado',
                'biblioteca_institucional': 'Biblioteca Institucional',
                'materiales_clases': 'Materiales para Clases',
                'material_deportivo': 'Material Deportivo',
                'musicales': 'Musicales',
                'part_time_teacher': 'Part Time Teacher - Reemplazos',
                'insumos_tecnologia': 'Insumos Institucionales de Sección (Tecnología)',
                'pep': 'PEP',
                'dp': 'DP',
                'pai': 'PAI',
                'departamento_apoyo': 'Departamento de Apoyo',
                'consejeria_universitaria': 'Consejería Universitaria',
                'direccion_general': 'Dirección General',
                'cafeteria': 'Cafetería',
                'transporte': 'Transporte',
                'utilidad_cafeteria': 'Utilidad Cafetería',
                'utilidad_transporte': 'Utilidad Transporte',
                'actividades_curriculares': 'Actividades Curriculares'
            };

            var nombresMeses = {
                '1': 'Enero', '2': 'Febrero', '3': 'Marzo', '4': 'Abril',
                '5': 'Mayo', '6': 'Junio', '7': 'Julio', '8': 'Agosto',
                '9': 'Septiembre', '10': 'Octubre', '11': 'Noviembre', '12': 'Diciembre'
            };

            // Mostrar modal y loading
            document.getElementById('detalle-modal').classList.add('show');
            document.getElementById('modal-loading').style.display = 'block';
            document.getElementById('modal-content-body').style.display = 'none';

            // Configurar título
            document.getElementById('modal-title').textContent = 
                'Detalle de ' + nombresTipos[tipo] + ' - ' + nombresMeses[mes] + ' ' + year;

            // Hacer petición AJAX
            var tiposSeccion = ['capacitacion_administracion', 'material_importado', 'biblioteca_institucional', 'materiales_clases', 'material_deportivo', 'musicales', 'part_time_teacher', 'insumos_tecnologia', 'pep', 'dp', 'pai', 'departamento_apoyo', 'consejeria_universitaria', 'direccion_general'];
            var tiposOtrosEscolares = ['rendimientos_intereses', 'agenda_escolar', 'anuario', 'examenes_admision', 'servicio_cafeteria', 'servicio_transporte'];
            var tiposSalariosAcademia = ['salarios_academia'];
            var tiposSalariosAdministracion = ['salarios_transporte', 'capacitacion_admin', 'aprendices_sena'];
            var tiposRubrosInstitucionales = ['equipos', 'examenes_medicos', 'tecnologia_institucional', 'insumos_enfermeria', 'mercadeo_admisiones', 'eventos_comunidad', 'mantenimiento_general', 'reparaciones_mayores', 'reparacion_muebles', 'utiles_oficina', 'elementos_aseo', 'gastos_agasajos', 'bienestar_institucional', 'eventos_internos', 'gastos_contratacion', 'afiliaciones_inscripciones'];
            var tiposMembresiasConvenios = ['bachillerato_internacional'];
            var tiposServiciosPublicos = ['agua', 'energia', 'telefono', 'vigilancia', 'internet_arrendamientos'];
            var tiposContratosExternos = ['cafeteria', 'transporte'];
            var tiposOtrosEgresos = ['honorarios', 'legales_sanciones', 'comisiones_bancarias', 'mensajeria_acarreos', 'impto_industria_comercio', 'plan_seguridad_salud', 'otros_egresos_retencion', 'impto_renta', 'arrendamientos'];
            var tiposUtilidadCafeteria = ['utilidad_cafeteria'];
            var tiposUtilidadTransporte = ['utilidad_transporte'];
            var tiposActividadesCurriculares = ['actividades_curriculares'];
            
            var endpoint;
            if (tiposSeccion.includes(tipo)) {
                endpoint = '/dashboard/seccion-academia-detalle';
            } else if (tiposOtrosEscolares.includes(tipo)) {
                endpoint = '/dashboard/otro-escolar-detalle';
            } else if (tiposSalariosAcademia.includes(tipo)) {
                endpoint = '/dashboard/salario-detalle';
            } else if (tiposSalariosAdministracion.includes(tipo)) {
                endpoint = '/dashboard/salario-administracion-detalle';
            } else if (tiposRubrosInstitucionales.includes(tipo)) {
                endpoint = '/dashboard/rubro-institucional-detalle';
            } else if (tiposMembresiasConvenios.includes(tipo)) {
                endpoint = '/dashboard/membresia-convenio-detalle';
            } else if (tiposServiciosPublicos.includes(tipo)) {
                endpoint = '/dashboard/servicio-publico-detalle';
            } else if (tiposContratosExternos.includes(tipo)) {
                endpoint = '/dashboard/contrato-externo-detalle';
            } else if (tiposOtrosEgresos.includes(tipo)) {
                endpoint = '/dashboard/otro-egreso-detalle';
            } else if (tiposUtilidadCafeteria.includes(tipo)) {
                endpoint = '/dashboard/utilidad-cafeteria-detalle';
            } else if (tiposUtilidadTransporte.includes(tipo)) {
                endpoint = '/dashboard/utilidad-transporte-detalle';
            } else if (tiposActividadesCurriculares.includes(tipo)) {
                endpoint = '/dashboard/actividades-curriculares-detalle';
            } else {
                endpoint = '/dashboard/ingreso-detalle';
            }
            
            var url = endpoint + '?tipo=' + encodeURIComponent(tipo) + 
                      '&mes=' + encodeURIComponent(mes) + 
                      '&year=' + encodeURIComponent(year);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Ocultar loading
                    document.getElementById('modal-loading').style.display = 'none';
                    document.getElementById('modal-content-body').style.display = 'block';

                    // Llenar resumen
                    document.getElementById('summary-concepto').textContent = nombresTipos[tipo];
                    document.getElementById('summary-periodo').textContent = nombresMeses[mes] + ' ' + year;
                    
                    // Determinar si es un tipo especial de utilidad
                    if (tiposUtilidadCafeteria.includes(tipo) || tiposUtilidadTransporte.includes(tipo)) {
                        // Para utilidades, mostrar la utilidad calculada
                        document.getElementById('summary-total').textContent = '$' + Number(data.utilidad).toLocaleString('es-CO');
                        
                        // Combinar ingresos y contratos para mostrar
                        var todosMovimientos = [];
                        if (data.ingresos) {
                            data.ingresos.forEach(function(ingreso) {
                                ingreso.tipo_mov = 'Ingreso';
                                todosMovimientos.push(ingreso);
                            });
                        }
                        if (data.contratos) {
                            data.contratos.forEach(function(contrato) {
                                contrato.tipo_mov = 'Contrato';
                                todosMovimientos.push(contrato);
                            });
                        }
                        
                        document.getElementById('summary-count').textContent = todosMovimientos.length;
                        var movimientosParaTabla = todosMovimientos;
                    } else {
                        // Para otros tipos, usar la estructura normal
                        document.getElementById('summary-total').textContent = '$' + Number(data.total).toLocaleString('es-CO');
                        document.getElementById('summary-count').textContent = data.movimientos.length;
                        var movimientosParaTabla = data.movimientos;
                    }

                    // Llenar tabla
                    var tbody = document.getElementById('detalle-tabla-body');
                    tbody.innerHTML = '';
                    
                    // Actualizar headers para tipos especiales
                    var tableContainer = document.getElementById('detalle-tabla-container');
                    var existingTable = tableContainer.querySelector('table');
                    
                    if (tiposUtilidadCafeteria.includes(tipo) || tiposUtilidadTransporte.includes(tipo)) {
                        // Para utilidades, incluir columna de Tipo
                        existingTable.innerHTML = `
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Documento</th>
                                    <th>Descripción</th>
                                    <th>Centro Costo</th>
                                    <th>Cuenta</th>
                                    <th>Tipo</th>
                                    <th class="amount">Valor</th>
                                </tr>
                            </thead>
                            <tbody id="detalle-tabla-body">
                            </tbody>
                        `;
                        tbody = document.getElementById('detalle-tabla-body'); // Re-obtener referencia
                    } else {
                        // Para otros tipos, usar estructura normal
                        existingTable.innerHTML = `
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Documento</th>
                                    <th>Descripción</th>
                                    <th>Centro Costo</th>
                                    <th>Cuenta</th>
                                    <th class="amount">Valor</th>
                                </tr>
                            </thead>
                            <tbody id="detalle-tabla-body">
                            </tbody>
                        `;
                        tbody = document.getElementById('detalle-tabla-body'); // Re-obtener referencia
                    }

                    if (movimientosParaTabla.length > 0) {
                        document.getElementById('detalle-tabla-container').style.display = 'block';
                        document.getElementById('no-data-message').style.display = 'none';

                        movimientosParaTabla.forEach(function(mov) {
                            var row = document.createElement('tr');
                            var tipoColumn = '';
                            
                            // Agregar columna de tipo para utilidades
                            if (tiposUtilidadCafeteria.includes(tipo) || tiposUtilidadTransporte.includes(tipo)) {
                                tipoColumn = '<td>' + (mov.tipo_mov || 'N/A') + '</td>';
                            }
                            
                            row.innerHTML = 
                                '<td>' + formatearFecha(mov.fecha) + '</td>' +
                                '<td>' + (mov.documento || 'N/A') + '</td>' +
                                '<td>' + (mov.descripcion || 'N/A') + '</td>' +
                                '<td>' + (mov.centro_costo || 'N/A') + '</td>' +
                                '<td>' + (mov.cuenta || 'N/A') + '</td>' +
                                tipoColumn +
                                '<td class="amount">$' + Number(Math.abs(mov.valor)).toLocaleString('es-CO') + '</td>';
                            tbody.appendChild(row);
                        });
                    } else {
                        document.getElementById('detalle-tabla-container').style.display = 'none';
                        document.getElementById('no-data-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Mostrar error
                    document.getElementById('modal-loading').style.display = 'none';
                    document.getElementById('modal-content-body').style.display = 'block';
                    document.getElementById('detalle-tabla-container').style.display = 'none';
                    document.getElementById('no-data-message').style.display = 'block';
                    document.getElementById('no-data-message').innerHTML = '<p>Error al cargar los datos. Inténtalo de nuevo.</p>';
                });
        }

        function cerrarModal() {
            document.getElementById('detalle-modal').classList.remove('show');
        }

        function formatearFecha(fechaISO) {
            if (!fechaISO) return 'N/A';
            
            try {
                // Crear la fecha tratándola como fecha local para evitar problemas de zona horaria
                let fecha;
                if (fechaISO.includes('T')) {
                    // Si viene con hora (formato ISO), extraer solo la fecha
                    const fechaSolo = fechaISO.split('T')[0];
                    const partes = fechaSolo.split('-');
                    // Crear fecha como local (año, mes-1, día)
                    fecha = new Date(parseInt(partes[0]), parseInt(partes[1]) - 1, parseInt(partes[2]));
                } else {
                    // Si ya es solo fecha
                    const partes = fechaISO.split('-');
                    fecha = new Date(parseInt(partes[0]), parseInt(partes[1]) - 1, parseInt(partes[2]));
                }
                
                // Verificar si la fecha es válida
                if (isNaN(fecha.getTime())) return 'N/A';
                
                // Formatear como DD/MM/YYYY
                const dia = fecha.getDate().toString().padStart(2, '0');
                const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                const año = fecha.getFullYear();
                
                return `${dia}/${mes}/${año}`;
            } catch (error) {
                return 'N/A';
            }
        }

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('detalle-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });
    </script>

    <style>
        .negative-value {
            color: #dc2626 !important;
            font-weight: bold;
        }
    </style>
</x-app-layout>
