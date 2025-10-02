<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Reparación Muebles") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="budget-section">
                        <h5>SECTION_Reparación Muebles</h5>
                        <div class="table-wrapper">
                            <table class="budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Ppto Aprobado</th>
                                        <th>Ejecutado</th>
                                        <th>Ppto a Ejec</th>
                                        <th>%Restante</th>
                                        <th>Julio</th>
                                        <th>Agosto</th>
                                        <th>Septiembre</th>
                                        <th>Octubre</th>
                                        <th>Noviembre</th>
                                        <th>Diciembre</th>
                                        <th>Enero</th>
                                        <th>Febrero</th>
                                        <th>Marzo</th>
                                        <th>Abril</th>
                                        <th>Mayo</th>
                                        <th>Junio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $concepto => $info)
                                    <tr>
                                        <td><strong>{{ $concepto }}</strong></td>
                                        <td class="number-cell">${{ number_format($info["presupuesto_aprobado"], 0, ",", ".") }}</td>
                                        <td class="number-cell">${{ number_format($info["ejecutado"], 0, ",", ".") }}</td>
                                        <td class="number-cell">${{ number_format($info["presupuesto_por_ejecutar"], 0, ",", ".") }}</td>
                                        <td class="number-cell">{{ number_format($info["porcentaje_restante"], 1) }}%</td>
                                        <td class="number-cell {{ $info["julio"] < 0 ? "negative-value" : "" }}">${{ number_format($info["julio"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["agosto"] < 0 ? "negative-value" : "" }}">${{ number_format($info["agosto"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["septiembre"] < 0 ? "negative-value" : "" }}">${{ number_format($info["septiembre"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["octubre"] < 0 ? "negative-value" : "" }}">${{ number_format($info["octubre"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["noviembre"] < 0 ? "negative-value" : "" }}">${{ number_format($info["noviembre"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["diciembre"] < 0 ? "negative-value" : "" }}">${{ number_format($info["diciembre"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["enero"] < 0 ? "negative-value" : "" }}">${{ number_format($info["enero"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["febrero"] < 0 ? "negative-value" : "" }}">${{ number_format($info["febrero"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["marzo"] < 0 ? "negative-value" : "" }}">${{ number_format($info["marzo"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["abril"] < 0 ? "negative-value" : "" }}">${{ number_format($info["abril"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["mayo"] < 0 ? "negative-value" : "" }}">${{ number_format($info["mayo"], 0, ",", ".") }}</td>
                                        <td class="number-cell {{ $info["junio"] < 0 ? "negative-value" : "" }}">${{ number_format($info["junio"], 0, ",", ".") }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="{{ asset("css/budget-sections.css") }}">
</x-app-layout>