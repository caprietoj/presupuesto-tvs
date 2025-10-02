<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detallado Secciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Filtros -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="filter-seccion" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Sección:</label>
                                <select id="filter-seccion" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" onchange="aplicarFiltrosAutomaticos()">
                                    <option value="">Todas las secciones</option>
                                    @foreach($secciones as $seccion)
                                        <option value="{{ $seccion }}">{{ $seccion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="filter-centro-costo" class="block text-sm font-medium text-gray-700 mb-2">Centro de Costo:</label>
                                <input type="text" 
                                       id="filter-centro-costo" 
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Buscar centro de costo..."
                                       oninput="aplicarFiltrosAutomaticos()">
                            </div>
                            
                            <div class="flex items-end space-x-2">
                                <button onclick="limpiarFiltros()" 
                                        style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; width: 100%;"
                                        onmouseover="this.style.backgroundColor='#4b5563'"
                                        onmouseout="this.style.backgroundColor='#6b7280'">
                                    🗑️ Limpiar
                                </button>
                            </div>
                        </div>
                        
                        <!-- Información de filtros aplicados -->
                        <div id="info-filtros" class="mt-4 text-sm text-gray-600" style="display: none;">
                            <strong>Filtros aplicados:</strong> <span id="filtros-activos"></span>
                        </div>
                    </div>

                    <!-- Tabla de Detallado -->
                    <div class="budget-section">
                        <h5 id="table-detallado-secciones" class="flex justify-between items-center mb-4">
                            <span>DETALLE DE MOVIMIENTOS POR SECCIONES</span>
                            <span class="text-sm font-normal text-gray-600" id="total-registros">Total de registros: 0</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="detallado-secciones-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Fuente</th>
                                        <th>Documento</th>
                                        <th>Fecha</th>
                                        <th>Cuenta</th>
                                        <th>Sección</th>
                                        <th>Rubro</th>
                                        <th>Descripción</th>
                                        <th>Valor</th>
                                        <th id="col-valor-moneda" class="columna-condicional">ValorMoneda</th>
                                        <th id="col-cliente-proveedor" class="columna-condicional">Cliente / Proveedor</th>
                                        <th id="col-nombre-cliente-proveedor" class="columna-condicional">Nombre Cliente / Proveedor</th>
                                        <th>Tercero</th>
                                        <th>Nombre Tercero</th>
                                        <th id="col-auxiliar" class="columna-condicional">Auxiliar</th>
                                        <th>Centro Costo</th>
                                    </tr>
                                </thead>
                                <tbody id="detallado-tbody">
                                    <!-- Los datos se cargarán aquí dinámicamente -->
                                    <tr>
                                        <td colspan="15" class="text-center py-8 text-gray-500">
                                            Cargando datos...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Mostrando <span id="registros-inicio">0</span> a <span id="registros-fin">0</span> de <span id="total-registros-bottom">0</span> registros
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="cambiarPagina('anterior')" id="btn-anterior" class="px-3 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 disabled:opacity-50" disabled>
                                Anterior
                            </button>
                            <span id="pagina-actual" class="px-3 py-2 bg-blue-500 text-white rounded-md">1</span>
                            <button onclick="cambiarPagina('siguiente')" id="btn-siguiente" class="px-3 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 disabled:opacity-50">
                                Siguiente
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar detalles del movimiento -->
    <div id="detalle-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Detalle del Movimiento</h3>
                <button class="modal-close" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="modal-loading" style="text-align: center; padding: 2rem;">
                    <div class="loading-spinner"></div>
                    <p>Cargando datos...</p>
                </div>
                <div id="modal-content-body" style="display: none;">
                    <div id="modal-summary" style="margin-bottom: 1rem; padding: 1rem; background-color: #f9fafb; border-radius: 6px;">
                        <div class="grid grid-cols-2 gap-4">
                            <p><strong>Fecha:</strong> <span id="summary-fecha"></span></p>
                            <p><strong>Documento:</strong> <span id="summary-documento"></span></p>
                            <p><strong>Centro de Costo:</strong> <span id="summary-centro-costo"></span></p>
                            <p><strong>Cuenta:</strong> <span id="summary-cuenta"></span></p>
                            <p><strong>Sección:</strong> <span id="summary-seccion"></span></p>
                            <p><strong>Rubro:</strong> <span id="summary-rubro"></span></p>
                        </div>
                        <div class="mt-3">
                            <p><strong>Descripción:</strong> <span id="summary-descripcion"></span></p>
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-lg"><strong>Valor:</strong> <span id="summary-valor" class="text-2xl font-bold"></span></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <p><strong>Cliente/Proveedor:</strong> <span id="summary-cliente"></span></p>
                            <p><strong>Tercero:</strong> <span id="summary-tercero"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos específicos para mantener consistencia con otras tablas */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .data-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .data-table thead th {
            color: #1f2937;
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .data-table tbody tr:nth-child(even):hover {
            background-color: #edf2f7;
        }

        .data-table td {
            padding: 0.875rem 0.75rem;
            font-size: 0.875rem;
            color: #374151;
            vertical-align: top;
        }

        .number-cell {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 500;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .budget-section {
            margin-bottom: 2rem;
        }

        .budget-section h5 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .data-table {
                font-size: 0.75rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 0.5rem 0.25rem;
            }
        }

        /* Estilos para valores negativos */
        .negative-value {
            color: #dc2626;
            font-weight: bold;
        }

        .positive-value {
            color: #059669;
        }

        /* Estilos para columnas condicionales */
        .columna-condicional.oculta {
            display: none;
        }

        .celda-cliente-proveedor.oculta,
        .celda-nombre-cliente-proveedor.oculta,
        .celda-valor-moneda.oculta,
        .celda-auxiliar.oculta {
            display: none;
        }

        /* Estilos del modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal-overlay.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.3s ease-in-out;
            min-width: 600px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #374151;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            padding: 0.5rem;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Hacer los valores clicables */
        .clickable-value {
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: underline;
        }

        .clickable-value:hover {
            background-color: #dbeafe !important;
            color: #1d4ed8;
            transform: scale(1.02);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(-50px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .modal-content {
                min-width: 95%;
                padding: 1rem;
            }
        }

        /* Loading spinner */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        let paginaActual = 1;
        let registrosPorPagina = 5;
        let totalRegistros = 0;
        let datosCompletos = [];

        // Cargar datos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarDatos();
        });

        function mostrarError(mensaje) {
            const tbody = document.getElementById('detallado-tbody');
            const colspan = obtenerColspanCorreto();
            tbody.innerHTML = `
                <tr>
                    <td colspan="${colspan}" class="text-center py-8 text-red-500">
                        ${mensaje}
                    </td>
                </tr>
            `;
            // Ocultar columnas condicionales cuando hay error
            document.getElementById('col-cliente-proveedor').classList.add('oculta');
            document.getElementById('col-nombre-cliente-proveedor').classList.add('oculta');
            document.getElementById('col-valor-moneda').classList.add('oculta');
            document.getElementById('col-auxiliar').classList.add('oculta');
        }

        function generarDatosEjemplo() {
            // Función removida - no generar datos de ejemplo
            return [];
        }

        function mostrarCargando() {
            const tbody = document.getElementById('detallado-tbody');
            const colspan = obtenerColspanCorreto();
            tbody.innerHTML = `
                <tr>
                    <td colspan="${colspan}" class="text-center py-8">
                        <div class="loading"></div>
                        <span class="ml-2">Cargando datos...</span>
                    </td>
                </tr>
            `;
            // Ocultar columnas condicionales mientras carga
            document.getElementById('col-cliente-proveedor').classList.add('oculta');
            document.getElementById('col-nombre-cliente-proveedor').classList.add('oculta');
            document.getElementById('col-valor-moneda').classList.add('oculta');
            document.getElementById('col-auxiliar').classList.add('oculta');
        }

        function mostrarDatos() {
            const tbody = document.getElementById('detallado-tbody');
            
            if (datosCompletos.length === 0) {
                const colspan = obtenerColspanCorreto();
                tbody.innerHTML = `
                    <tr>
                        <td colspan="${colspan}" class="text-center py-8 text-gray-500">
                            No se encontraron registros con los filtros aplicados.
                        </td>
                    </tr>
                `;
                // También ocultar las columnas cuando no hay datos
                document.getElementById('col-cliente-proveedor').classList.add('oculta');
                document.getElementById('col-nombre-cliente-proveedor').classList.add('oculta');
                document.getElementById('col-valor-moneda').classList.add('oculta');
                document.getElementById('col-auxiliar').classList.add('oculta');
                return;
            }

            // Verificar si hay datos en las diferentes columnas condicionales
            const tieneClienteProveedor = tieneClienteProveedorData();
            const tieneValorMoneda = tieneValorMonedaData();
            const tieneAuxiliar = tieneAuxiliarData();

            // Ocultar/mostrar columnas según los datos disponibles
            const colClienteProveedor = document.getElementById('col-cliente-proveedor');
            const colNombreClienteProveedor = document.getElementById('col-nombre-cliente-proveedor');
            const colValorMoneda = document.getElementById('col-valor-moneda');
            const colAuxiliar = document.getElementById('col-auxiliar');
            
            // Cliente/Proveedor
            if (tieneClienteProveedor) {
                colClienteProveedor.classList.remove('oculta');
                colNombreClienteProveedor.classList.remove('oculta');
            } else {
                colClienteProveedor.classList.add('oculta');
                colNombreClienteProveedor.classList.add('oculta');
            }
            
            // ValorMoneda
            if (tieneValorMoneda) {
                colValorMoneda.classList.remove('oculta');
            } else {
                colValorMoneda.classList.add('oculta');
            }
            
            // Auxiliar
            if (tieneAuxiliar) {
                colAuxiliar.classList.remove('oculta');
            } else {
                colAuxiliar.classList.add('oculta');
            }

            tbody.innerHTML = datosCompletos.map((registro, index) => `
                <tr>
                    <td>${registro.fuente || ''}</td>
                    <td>${registro.documento || ''}</td>
                    <td>${registro.fecha || ''}</td>
                    <td>${registro.cuenta || ''}</td>
                    <td>${registro.seccion || ''}</td>
                    <td>${registro.rubro || ''}</td>
                    <td>${registro.descripcion || ''}</td>
                    <td class="number-cell clickable-value ${parseFloat(registro.valor) < 0 ? 'negative-value' : 'positive-value'}" 
                        onclick="mostrarDetalleMovimiento(${index})" 
                        title="Clic para ver detalles completos">
                        $${new Intl.NumberFormat('es-CO').format(Math.abs(parseFloat(registro.valor) || 0))}
                    </td>
                    <td class="number-cell celda-valor-moneda ${tieneValorMoneda ? '' : 'oculta'}">
                        $${new Intl.NumberFormat('es-CO').format(Math.abs(parseFloat(registro.valorMoneda) || 0))}
                    </td>
                    <td class="celda-cliente-proveedor ${tieneClienteProveedor ? '' : 'oculta'}">${registro.clienteProveedor || ''}</td>
                    <td class="celda-nombre-cliente-proveedor ${tieneClienteProveedor ? '' : 'oculta'}">${registro.nombreClienteProveedor || ''}</td>
                    <td>${registro.tercero || ''}</td>
                    <td>${registro.nombreTercero || ''}</td>
                    <td class="celda-auxiliar ${tieneAuxiliar ? '' : 'oculta'}">${registro.auxiliar || ''}</td>
                    <td>${registro.centroCosto || ''}</td>
                </tr>
            `).join('');
        }

        function actualizarPaginacion() {
            const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
            const inicio = totalRegistros > 0 ? ((paginaActual - 1) * registrosPorPagina) + 1 : 0;
            const fin = Math.min(paginaActual * registrosPorPagina, totalRegistros);
            
            document.getElementById('total-registros').textContent = `Total de registros: ${totalRegistros}`;
            document.getElementById('registros-inicio').textContent = inicio;
            document.getElementById('registros-fin').textContent = fin;
            document.getElementById('total-registros-bottom').textContent = totalRegistros;
            document.getElementById('pagina-actual').textContent = paginaActual;
            
            document.getElementById('btn-anterior').disabled = paginaActual <= 1;
            document.getElementById('btn-siguiente').disabled = paginaActual >= totalPaginas || totalPaginas === 0;
        }

        function cambiarPagina(direccion) {
            const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
            
            if (direccion === 'anterior' && paginaActual > 1) {
                paginaActual--;
            } else if (direccion === 'siguiente' && paginaActual < totalPaginas) {
                paginaActual++;
            }
            
            // Obtener filtros actuales sin resetear la página
            const seccion = document.getElementById('filter-seccion').value;
            const centroCosto = document.getElementById('filter-centro-costo').value;
            
            // Cargar datos con la nueva página
            cargarDatos(seccion, '', centroCosto);
        }

        function aplicarFiltrosAutomaticos() {
            const seccion = document.getElementById('filter-seccion').value;
            const centroCosto = document.getElementById('filter-centro-costo').value;
            
            // Resetear a página 1 cuando se aplican filtros
            paginaActual = 1;
            
            // Mostrar información de filtros aplicados
            mostrarFiltrosAplicados(seccion, centroCosto);
            
            // Cargar datos con los filtros aplicados
            cargarDatos(seccion, '', centroCosto);
        }

        function mostrarFiltrosAplicados(seccion, centroCosto) {
            const filtrosActivos = [];
            
            if (seccion) filtrosActivos.push(`Sección: ${seccion}`);
            if (centroCosto) filtrosActivos.push(`Centro de Costo: ${centroCosto}`);
            
            const infoFiltros = document.getElementById('info-filtros');
            const filtrosActivosSpan = document.getElementById('filtros-activos');
            
            if (filtrosActivos.length > 0) {
                filtrosActivosSpan.textContent = filtrosActivos.join(' | ');
                infoFiltros.style.display = 'block';
            } else {
                infoFiltros.style.display = 'none';
            }
        }

        function limpiarFiltros() {
            document.getElementById('filter-seccion').value = '';
            document.getElementById('filter-centro-costo').value = '';
            
            // Ocultar información de filtros
            document.getElementById('info-filtros').style.display = 'none';
            
            // Recargar todos los datos
            aplicarFiltrosAutomaticos();
        }

        function cargarDatos(seccion = '', rubro = '', centroCosto = '') {
            const params = new URLSearchParams({
                pagina: paginaActual,
                ...(seccion && { seccion }),
                ...(rubro && { rubro }),
                ...(centroCosto && { centro_costo: centroCosto })
            });

            // Mostrar estado de carga en la tabla
            mostrarCargando();

            fetch(`/secciones/movimientos-detallado?${params}`)
                .then(response => response.json())
                .then(data => {
                    datosCompletos = data.datos;
                    totalRegistros = data.totalRegistros;
                    mostrarDatos();
                    actualizarPaginacion();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarError('Error al cargar los datos. Verifique la conexión.');
                });
        }

        // Aplicar filtros cuando se cargan las secciones opcionales
        function aplicarFiltros() {
            aplicarFiltrosAutomaticos();
        }

        // Funciones auxiliares
        function obtenerColspanCorreto() {
            // 15 columnas base - restar las que estén ocultas
            let colspan = 15;
            
            if (document.getElementById('col-cliente-proveedor').classList.contains('oculta')) {
                colspan -= 2; // Cliente y Nombre Cliente
            }
            if (document.getElementById('col-valor-moneda').classList.contains('oculta')) {
                colspan -= 1; // ValorMoneda
            }
            if (document.getElementById('col-auxiliar').classList.contains('oculta')) {
                colspan -= 1; // Auxiliar
            }
            
            return colspan.toString();
        }

        function tieneClienteProveedorData() {
            return datosCompletos.some(registro => 
                (registro.clienteProveedor && registro.clienteProveedor.trim() !== '') ||
                (registro.nombreClienteProveedor && registro.nombreClienteProveedor.trim() !== '')
            );
        }

        function tieneValorMonedaData() {
            return datosCompletos.some(registro => {
                const valor = parseFloat(registro.valorMoneda || 0);
                return valor !== 0 && !isNaN(valor);
            });
        }

        function tieneAuxiliarData() {
            return datosCompletos.some(registro => 
                registro.auxiliar && registro.auxiliar.toString().trim() !== ''
            );
        }

        // Funciones del modal
        function mostrarDetalleMovimiento(index) {
            const registro = datosCompletos[index];
            
            // Mostrar modal y loading
            document.getElementById('detalle-modal').classList.add('show');
            document.getElementById('modal-loading').style.display = 'block';
            document.getElementById('modal-content-body').style.display = 'none';
            
            // Simular carga (puedes cambiar esto por una llamada real a la API si necesitas más datos)
            setTimeout(() => {
                // Llenar los datos del modal
                document.getElementById('summary-fecha').textContent = registro.fecha || 'No disponible';
                document.getElementById('summary-documento').textContent = registro.documento || 'No disponible';
                document.getElementById('summary-centro-costo').textContent = registro.centroCosto || 'No disponible';
                document.getElementById('summary-cuenta').textContent = registro.cuenta || 'No disponible';
                document.getElementById('summary-seccion').textContent = registro.seccion || 'No disponible';
                document.getElementById('summary-rubro').textContent = registro.rubro || 'No disponible';
                document.getElementById('summary-descripcion').textContent = registro.descripcion || 'No disponible';
                
                // Solo mostrar información de cliente/proveedor si hay datos disponibles globalmente
                const tieneClienteData = tieneClienteProveedorData();
                const clienteProveedor = registro.nombreClienteProveedor || registro.clienteProveedor || 'No disponible';
                const tercero = registro.nombreTercero || registro.tercero || 'No disponible';
                
                if (tieneClienteData) {
                    document.getElementById('summary-cliente').textContent = clienteProveedor;
                } else {
                    // Ocultar la información de cliente/proveedor en el modal si no hay datos
                    document.getElementById('summary-cliente').parentElement.style.display = 'none';
                }
                
                document.getElementById('summary-tercero').textContent = tercero;
                
                // Formatear el valor con color
                const valor = parseFloat(registro.valor) || 0;
                const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                const valorElement = document.getElementById('summary-valor');
                valorElement.textContent = valorFormateado;
                valorElement.className = valor < 0 ? 'text-2xl font-bold text-red-600' : 'text-2xl font-bold text-green-600';
                
                // Ocultar loading y mostrar contenido
                document.getElementById('modal-loading').style.display = 'none';
                document.getElementById('modal-content-body').style.display = 'block';
            }, 500);
        }

        function cerrarModal() {
            document.getElementById('detalle-modal').classList.remove('show');
        }

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('detalle-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });
    </script>
</x-app-layout>