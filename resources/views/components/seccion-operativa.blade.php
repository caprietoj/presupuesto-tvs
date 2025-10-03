<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="budget-section">
                        <h5 id="table-{{ $slug }}">{{ strtoupper($nombreSeccion) }}</h5>
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
                                        <td class="number-cell">${{ number_format($info['presupuesto_aprobado'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($info['ejecutado'], 0, ',', '.') }}</td>
                                        <td class="number-cell">${{ number_format($info['presupuesto_por_ejecutar'], 0, ',', '.') }}</td>
                                        <td class="number-cell">{{ number_format($info['porcentaje_restante'], 1) }}%</td>
                                        @php
                                            $meses = ['julio' => 7, 'agosto' => 8, 'septiembre' => 9, 'octubre' => 10, 
                                                     'noviembre' => 11, 'diciembre' => 12, 'enero' => 1, 'febrero' => 2, 
                                                     'marzo' => 3, 'abril' => 4, 'mayo' => 5, 'junio' => 6];
                                            $currentYear = date('Y');
                                        @endphp
                                        @foreach($meses as $mesNombre => $mesNumero)
                                            @php
                                                $year = $mesNumero >= 7 ? $currentYear : $currentYear + 1;
                                            @endphp
                                            <td class="number-cell clickable-cell {{ $info[$mesNombre] < 0 ? 'negative-value' : '' }}" 
                                                data-seccion="{{ $concepto }}"
                                                data-mes="{{ $mesNumero }}" 
                                                data-year="{{ $year }}"
                                                data-mes-nombre="{{ ucfirst($mesNombre) }}"
                                                onclick="mostrarDetalleMovimientos(this)"
                                                style="cursor: pointer;">
                                                ${{ number_format($info[$mesNombre], 0, ',', '.') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal para mostrar movimientos detallados -->
                    <div id="modalMovimientos" class="modal" style="display: none;">
                        <div class="modal-content">
                            <span class="close" onclick="cerrarModal()">&times;</span>
                            <h3 id="modalTitulo">Movimientos Detallados</h3>
                            <div id="modalContenido" style="max-height: 500px; overflow-y: auto;">
                                <p class="text-center py-4">Cargando...</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="{{ asset('css/budget-sections.css') }}">
    
    <style>
        .clickable-cell {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .clickable-cell:hover {
            background-color: #f0f0f0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .movimiento-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .movimiento-table th,
        .movimiento-table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .movimiento-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .movimiento-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>

    <script>
        function mostrarDetalleMovimientos(elemento) {
            const seccion = elemento.getAttribute('data-seccion');
            const mes = elemento.getAttribute('data-mes');
            const year = elemento.getAttribute('data-year');
            const mesNombre = elemento.getAttribute('data-mes-nombre');
            
            // Mostrar modal
            const modal = document.getElementById('modalMovimientos');
            const titulo = document.getElementById('modalTitulo');
            const contenido = document.getElementById('modalContenido');
            
            titulo.textContent = `Movimientos de ${seccion} - ${mesNombre} ${year}`;
            contenido.innerHTML = '<p class="text-center py-4">Cargando...</p>';
            modal.style.display = 'block';
            
            // Hacer petición AJAX
            fetch(`/api/secciones/movimientos-operativas?seccion=${encodeURIComponent(seccion)}&mes=${mes}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    if (data.movimientos && data.movimientos.length > 0) {
                        let html = `
                            <div style="margin-bottom: 15px;">
                                <strong>Total: $${new Intl.NumberFormat('es-CO').format(data.total)}</strong>
                                <span style="margin-left: 20px; color: #666;">${data.movimientos.length} movimiento(s)</span>
                            </div>
                            <table class="movimiento-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Documento</th>
                                        <th>Descripción</th>
                                        <th>Centro Costo</th>
                                        <th>Cuenta</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;
                        
                        data.movimientos.forEach(mov => {
                            const valor = Math.abs(mov.valor);
                            html += `
                                <tr>
                                    <td>${new Date(mov.fecha).toLocaleDateString('es-CO')}</td>
                                    <td>${mov.documento || 'N/A'}</td>
                                    <td>${mov.descripcion || 'Sin descripción'}</td>
                                    <td>${mov.centro_costo || 'N/A'}</td>
                                    <td>${mov.cuenta || 'N/A'}</td>
                                    <td>$${new Intl.NumberFormat('es-CO').format(valor)}</td>
                                </tr>
                            `;
                        });
                        
                        html += '</tbody></table>';
                        contenido.innerHTML = html;
                    } else {
                        contenido.innerHTML = '<p class="text-center py-4">No hay movimientos para este período.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    contenido.innerHTML = '<p class="text-center py-4 text-red-600">Error al cargar los movimientos.</p>';
                });
        }
        
        function cerrarModal() {
            document.getElementById('modalMovimientos').style.display = 'none';
        }
        
        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('modalMovimientos');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</x-app-layout>
