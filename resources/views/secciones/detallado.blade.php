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
                                        @if($canReclassify)
                                        <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="detallado-tbody">
                                    <!-- Los datos se cargarán aquí dinámicamente -->
                                    <tr>
                                        <td colspan="{{ $canReclassify ? '16' : '15' }}" class="text-center py-8 text-gray-500">
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

    <!-- Modal para Reclasificar Movimiento -->
    <div id="reclasificar-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 class="modal-title">🔄 Reclasificar Movimiento</h3>
                <button class="modal-close" onclick="cerrarModalReclasificar()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Información del movimiento actual -->
                <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem; margin-bottom: 1.5rem; border-radius: 6px;">
                    <h4 style="font-weight: 600; color: #92400e; margin-bottom: 0.5rem;">📋 Movimiento Actual</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <p><strong>Centro de Costo:</strong> <span id="reclass-centro-actual"></span></p>
                        <p><strong>Valor:</strong> <span id="reclass-valor"></span></p>
                        <p><strong>Sección:</strong> <span id="reclass-seccion-actual"></span></p>
                        <p><strong>Rubro:</strong> <span id="reclass-rubro-actual"></span></p>
                    </div>
                    <p class="mt-2"><strong>Descripción:</strong> <span id="reclass-descripcion"></span></p>
                </div>

                <!-- Formulario de reclasificación -->
                <form id="form-reclasificar" onsubmit="confirmarReclasificacion(event)">
                    <input type="hidden" id="reclass-movimiento-id">
                    
                    <div class="mb-4">
                        <label for="reclass-buscar" class="block text-sm font-medium text-gray-700 mb-2">
                            🔍 Buscar Centro de Costo Destino
                        </label>
                        <input type="text" 
                               id="reclass-buscar" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Buscar por centro, sección o rubro..."
                               oninput="filtrarCentrosCosto()"
                               autocomplete="off">
                        <!-- Contador de resultados -->
                        <div id="contador-resultados" 
                             style="margin-top: 0.5rem; padding: 0.5rem; background-color: #f3f4f6; border-radius: 4px; font-size: 0.875rem; display: none;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="reclass-centro-nuevo" class="block text-sm font-medium text-gray-700 mb-2">
                            📍 Seleccionar Centro de Costo Destino <span class="text-red-500">*</span>
                        </label>
                        <select id="reclass-centro-nuevo" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                required
                                onchange="mostrarInfoDestino()">
                            <option value="">Seleccione un centro de costo...</option>
                        </select>
                    </div>

                    <!-- Información del destino -->
                    <div id="info-destino" style="background-color: #d1fae5; border-left: 4px solid #10b981; padding: 1rem; margin-bottom: 1.5rem; border-radius: 6px; display: none;">
                        <h4 style="font-weight: 600; color: #065f46; margin-bottom: 0.5rem;">✅ Destino Seleccionado</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <p><strong>Centro de Costo:</strong> <span id="destino-centro"></span></p>
                            <p><strong>Sección:</strong> <span id="destino-seccion"></span></p>
                            <p colspan="2"><strong>Rubro:</strong> <span id="destino-rubro"></span></p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" 
                                onclick="cerrarModalReclasificar()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                            🔄 Reclasificar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Excluir Gasto 2024-2025 -->
    <div id="excluir-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 class="modal-title">📅 Marcar como Gasto 2024-2025</h3>
                <button class="modal-close" onclick="cerrarModalExcluir()">&times;</button>
            </div>
            
            <form id="form-excluir" onsubmit="confirmarExclusion(event)">
                <div class="modal-body">
                    <!-- Información del movimiento -->
                    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 0.75rem; margin-bottom: 1rem; border-radius: 6px;">
                        <h4 style="font-weight: 600; color: #92400e; margin-bottom: 0.5rem; font-size: 0.9rem;">⚠️ Gasto a Excluir</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <p><strong>Centro de Costo:</strong> <span id="excluir-centro"></span></p>
                            <p><strong>Valor:</strong> <span id="excluir-valor" class="font-bold"></span></p>
                            <p><strong>Sección:</strong> <span id="excluir-seccion"></span></p>
                            <p><strong>Rubro:</strong> <span id="excluir-rubro"></span></p>
                            <p><strong>Fecha:</strong> <span id="excluir-fecha"></span></p>
                            <p><strong>Documento:</strong> <span id="excluir-documento"></span></p>
                        </div>
                        <p class="mt-2 text-xs"><strong>Descripción:</strong> <span id="excluir-descripcion"></span></p>
                    </div>

                    <!-- Explicación -->
                    <div style="background-color: #dbeafe; border-left: 4px solid #3b82f6; padding: 0.75rem; margin-bottom: 1rem; border-radius: 6px;">
                        <h4 style="font-weight: 600; color: #1e40af; margin-bottom: 0.5rem; font-size: 0.9rem;">ℹ️ ¿Qué significa esto?</h4>
                        <p class="text-xs text-gray-700">
                            Al marcar este gasto como <strong>2024-2025</strong>, se excluirá de los cálculos del presupuesto actual 
                            (2025-2026) ya que corresponde al año fiscal anterior. El gasto se moverá a la vista "Gastos 2024-2025" 
                            donde podrá ser consultado y revertido si es necesario.
                        </p>
                    </div>

                    <input type="hidden" id="excluir-movimiento-id">
                    
                    <div class="mb-3">
                        <label for="excluir-motivo" class="block text-sm font-medium text-gray-700 mb-1">
                            📝 Motivo de la exclusión (opcional)
                        </label>
                        <textarea id="excluir-motivo" 
                                  rows="2"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 text-sm"
                                  placeholder="Ej: Gasto correspondiente al cierre fiscal 2024-2025..."></textarea>
                    </div>
                </div>

                <!-- Botones FUERA del modal-body para que siempre sean visibles -->
                <div style="padding: 1rem 1.5rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" 
                            onclick="cerrarModalExcluir()" 
                            style="padding: 0.5rem 1rem; background-color: #d1d5db; color: #374151; border: none; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; cursor: pointer;">
                        Cancelar
                    </button>
                    <button type="submit" 
                            style="padding: 0.5rem 1rem; background-color: #d97706; color: white; border: none; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; cursor: pointer;">
                        📅 Marcar como 2024-2025
                    </button>
                </div>
            </form>
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
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            animation: fadeIn 0.3s ease-in-out;
            overflow-y: auto;
            padding: 2rem 0;
        }

        .modal-overlay.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Cuando se usa style="display: flex" directamente */
        .modal-overlay[style*="display: flex"] {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            width: 90%;
            max-width: 650px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-in-out;
            margin: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
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
            max-height: calc(90vh - 120px);
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        /* Estilos para los botones del modal */
        .modal-body button[type="submit"],
        .modal-body button[type="button"] {
            flex-shrink: 0;
            min-height: 40px;
        }

        /* Estilos para el scrollbar del modal */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* SweetAlert2 por encima de los modales */
        .swal2-container {
            z-index: 99999 !important;
        }

        /* Estilos para botones de acción */
        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-reclasificar {
            background-color: #3b82f6;
            color: white;
        }

        .btn-reclasificar:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .btn-excluir-2024 {
            background-color: #f59e0b;
            color: white;
        }

        .btn-excluir-2024:hover {
            background-color: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
        }

        .action-cell {
            text-align: center;
            white-space: nowrap;
        }

        /* Estilos para el campo de búsqueda con feedback */
        #reclass-buscar {
            transition: all 0.3s;
        }

        #reclass-buscar:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #contador-resultados {
            animation: fadeIn 0.3s ease-in;
        }

        /* Estilos para el select con mejoras visuales */
        #reclass-centro-nuevo {
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }

        #reclass-centro-nuevo:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #reclass-centro-nuevo option {
            padding: 0.5rem;
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

        /* Responsive para pantallas pequeñas */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                max-width: 95%;
                padding: 1.5rem 1rem;
                max-height: 90vh;
            }

            .modal-overlay {
                padding: 1rem 0;
            }

            .modal-body {
                max-height: calc(90vh - 120px);
            }
        }

        /* Responsive para pantallas muy pequeñas */
        @media (max-width: 480px) {
            .modal-content {
                width: 98%;
                padding: 1rem;
                border-radius: 8px;
            }

            .modal-title {
                font-size: 1.25rem;
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
        
        // Permisos del usuario - solo usuarios con acceso total pueden reclasificar
        const canReclassify = {{ $canReclassify ? 'true' : 'false' }};

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
                    ${canReclassify ? `
                        <td class="action-cell">
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <button class="btn-action btn-reclasificar" 
                                        onclick="abrirModalReclasificar(${index})"
                                        title="Reclasificar este movimiento">
                                    🔄 Reclasificar
                                </button>
                                <button class="btn-action btn-excluir-2024" 
                                        onclick="abrirModalExcluir(${index})"
                                        title="Marcar como gasto 2024-2025">
                                    📅 2024-2025
                                </button>
                            </div>
                        </td>
                    ` : ''}
                </tr>
            `).join('');
        }

        function actualizarPaginacion() {
            const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
            const inicio = totalRegistros > 0 ? ((paginaActual - 1) * registrosPorPagina) + 1 : 0;
            const fin = Math.min(paginaActual * registrosPorPagina, totalRegistros);
            
            console.log('Actualizando paginación:', {
                totalRegistros,
                totalPaginas,
                paginaActual,
                registrosPorPagina
            });
            
            document.getElementById('total-registros').textContent = `Total de registros: ${totalRegistros}`;
            document.getElementById('registros-inicio').textContent = inicio;
            document.getElementById('registros-fin').textContent = fin;
            document.getElementById('total-registros-bottom').textContent = totalRegistros;
            document.getElementById('pagina-actual').textContent = `${paginaActual} de ${totalPaginas}`;
            
            // Habilitar/deshabilitar botones
            const btnAnterior = document.getElementById('btn-anterior');
            const btnSiguiente = document.getElementById('btn-siguiente');
            
            btnAnterior.disabled = paginaActual <= 1;
            btnSiguiente.disabled = paginaActual >= totalPaginas || totalPaginas === 0;
            
            // Agregar estilos visuales adicionales
            if (btnAnterior.disabled) {
                btnAnterior.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnAnterior.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            if (btnSiguiente.disabled) {
                btnSiguiente.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnSiguiente.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function cambiarPagina(direccion) {
            const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
            
            console.log('Cambiar página:', {
                direccion,
                paginaActual,
                totalPaginas,
                totalRegistros
            });
            
            if (direccion === 'anterior' && paginaActual > 1) {
                paginaActual--;
            } else if (direccion === 'siguiente' && paginaActual < totalPaginas) {
                paginaActual++;
            } else {
                console.log('No se puede cambiar de página');
                return; // No hacer nada si no se puede cambiar
            }
            
            // Obtener filtros actuales sin resetear la página
            const seccion = document.getElementById('filter-seccion').value;
            const centroCosto = document.getElementById('filter-centro-costo').value;
            
            console.log('Cargando página:', paginaActual);
            
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

            console.log('Cargando datos con params:', {
                pagina: paginaActual,
                seccion,
                rubro,
                centroCosto
            });

            // Mostrar estado de carga en la tabla
            mostrarCargando();

            fetch(`/secciones/movimientos-detallado?${params}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Datos recibidos:', {
                        cantidadDatos: data.datos.length,
                        totalRegistros: data.totalRegistros,
                        pagina: data.pagina,
                        registrosPorPagina: data.registrosPorPagina
                    });
                    
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
            // Columnas base (sin Acciones)
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
            
            // Si NO puede reclasificar, ya está correcto (15 - ocultas)
            // Si puede reclasificar, sumar 1 por la columna Acciones
            if (canReclassify) {
                colspan += 1;
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

        // =====================================================
        // FUNCIONES DE RECLASIFICACIÓN
        // =====================================================
        
        let centrosCostoDisponibles = [];
        let centrosCostoFiltrados = [];
        let movimientoActual = null;
        let busquedaTimeout = null;

        // Cargar centros de costo disponibles
        async function cargarCentrosCosto() {
            try {
                const response = await fetch('/api/secciones/centros-costo-disponibles');
                const data = await response.json();
                
                if (data.success) {
                    centrosCostoDisponibles = data.centros_costo;
                    centrosCostoFiltrados = [...centrosCostoDisponibles];
                }
            } catch (error) {
                console.error('Error al cargar centros de costo:', error);
            }
        }

        // Abrir modal de reclasificación
        function abrirModalReclasificar(index) {
            // Verificar permisos antes de abrir el modal
            if (!canReclassify) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sin permisos',
                    text: 'No tiene permisos para reclasificar movimientos. Solo usuarios con acceso total pueden realizar esta acción.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            movimientoActual = datosCompletos[index];
            
            if (!movimientoActual.id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede reclasificar este movimiento (ID no disponible)',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            // Llenar información del movimiento actual
            document.getElementById('reclass-movimiento-id').value = movimientoActual.id;
            document.getElementById('reclass-centro-actual').textContent = movimientoActual.centroCosto || 'N/A';
            document.getElementById('reclass-seccion-actual').textContent = movimientoActual.seccion || 'N/A';
            document.getElementById('reclass-rubro-actual').textContent = movimientoActual.rubro || 'N/A';
            document.getElementById('reclass-descripcion').textContent = movimientoActual.descripcion || 'N/A';
            
            const valor = parseFloat(movimientoActual.valor) || 0;
            document.getElementById('reclass-valor').textContent = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
            
            // Cargar centros de costo si no están cargados
            if (centrosCostoDisponibles.length === 0) {
                cargarCentrosCosto().then(() => {
                    poblarSelectCentrosCosto();
                    actualizarContadorResultados(''); // Mostrar contador inicial
                });
            } else {
                poblarSelectCentrosCosto();
                actualizarContadorResultados(''); // Mostrar contador inicial
            }
            
            // Limpiar y ocultar info de destino
            document.getElementById('info-destino').style.display = 'none';
            document.getElementById('reclass-buscar').value = '';
            
            // Mostrar modal
            document.getElementById('reclasificar-modal').style.display = 'flex';
        }

        // Poblar select con centros de costo
        function poblarSelectCentrosCosto() {
            const select = document.getElementById('reclass-centro-nuevo');
            const busqueda = document.getElementById('reclass-buscar').value.toLowerCase().trim();
            
            // Filtrar el centro de costo actual
            const centrosParaMostrar = centrosCostoFiltrados.filter(
                cc => cc.centro_costo !== movimientoActual.centroCosto
            );
            
            // Mensaje inicial dependiendo si hay búsqueda activa
            if (centrosParaMostrar.length === 0) {
                if (busqueda) {
                    select.innerHTML = '<option value="">❌ No se encontraron coincidencias</option>';
                } else {
                    select.innerHTML = '<option value="">Seleccione un centro de costo...</option>';
                }
            } else {
                const textoOpcionInicial = busqueda 
                    ? `✅ ${centrosParaMostrar.length} coincidencia${centrosParaMostrar.length !== 1 ? 's' : ''} - Seleccione una opción...`
                    : `Seleccione un centro de costo (${centrosParaMostrar.length} disponibles)...`;
                
                select.innerHTML = `<option value="">${textoOpcionInicial}</option>`;
                
                centrosParaMostrar.forEach(cc => {
                    const option = document.createElement('option');
                    option.value = cc.centro_costo;
                    
                    // Si hay búsqueda, resaltar visualmente la primera coincidencia encontrada
                    let textoOpcion = `${cc.centro_costo} - ${cc.seccion} | ${cc.rubro}`;
                    
                    // Agregar emoji de estrella si coincide exactamente con el centro de costo buscado
                    if (busqueda && cc.centro_costo.toLowerCase() === busqueda) {
                        textoOpcion = `⭐ ${textoOpcion}`;
                    }
                    
                    option.textContent = textoOpcion;
                    option.dataset.seccion = cc.seccion;
                    option.dataset.rubro = cc.rubro;
                    select.appendChild(option);
                });
                
                // Si solo hay una coincidencia y hay búsqueda activa, sugerir seleccionarla
                if (centrosParaMostrar.length === 1 && busqueda) {
                    select.selectedIndex = 1; // Seleccionar automáticamente la única opción
                    mostrarInfoDestino(); // Mostrar info de destino automáticamente
                }
            }
            
            // Resetear selección e info de destino cuando hay múltiples opciones
            if (centrosParaMostrar.length !== 1 || !busqueda) {
                if (select.selectedIndex !== 0) {
                    select.selectedIndex = 0;
                    document.getElementById('info-destino').style.display = 'none';
                }
            }
        }

        // Filtrar centros de costo por búsqueda (actualización en tiempo real)
        function filtrarCentrosCosto() {
            // Limpiar timeout anterior si existe
            if (busquedaTimeout) {
                clearTimeout(busquedaTimeout);
            }
            
            // Pequeño delay para evitar filtrar en cada tecla (mejora rendimiento)
            busquedaTimeout = setTimeout(() => {
                const busqueda = document.getElementById('reclass-buscar').value.toLowerCase().trim();
                
                if (!busqueda) {
                    centrosCostoFiltrados = [...centrosCostoDisponibles];
                } else {
                    centrosCostoFiltrados = centrosCostoDisponibles.filter(cc => 
                        cc.centro_costo.toLowerCase().includes(busqueda) ||
                        cc.seccion.toLowerCase().includes(busqueda) ||
                        cc.rubro.toLowerCase().includes(busqueda)
                    );
                }
                
                // Actualizar el select automáticamente
                poblarSelectCentrosCosto();
                
                // Mostrar contador de resultados
                actualizarContadorResultados(busqueda);
            }, 150); // Delay de 150ms para suavizar la búsqueda
        }

        // Actualizar contador de resultados
        function actualizarContadorResultados(busqueda) {
            const contador = document.getElementById('contador-resultados');
            if (!contador) return;
            
            const total = centrosCostoDisponibles.length - 1; // -1 por el centro actual
            const filtrados = centrosCostoFiltrados.filter(
                cc => cc.centro_costo !== movimientoActual.centroCosto
            ).length;
            
            if (busqueda) {
                if (filtrados === 0) {
                    contador.innerHTML = `<span style="color: #dc2626;">❌ No se encontraron coincidencias para "<strong>${busqueda}</strong>"</span>`;
                    contador.style.display = 'block';
                } else if (filtrados === 1) {
                    contador.innerHTML = `<span style="color: #059669;">✅ Se encontró <strong>1 coincidencia</strong></span>`;
                    contador.style.display = 'block';
                } else {
                    contador.innerHTML = `<span style="color: #059669;">✅ Se encontraron <strong>${filtrados} coincidencias</strong> de ${total} centros disponibles</span>`;
                    contador.style.display = 'block';
                }
            } else {
                contador.innerHTML = `<span style="color: #6b7280;">💡 <strong>${total}</strong> centros de costo disponibles. Comience a escribir para buscar...</span>`;
                contador.style.display = 'block';
            }
        }

        // Mostrar información del destino seleccionado
        function mostrarInfoDestino() {
            const select = document.getElementById('reclass-centro-nuevo');
            const selectedOption = select.options[select.selectedIndex];
            
            if (select.value) {
                document.getElementById('destino-centro').textContent = select.value;
                document.getElementById('destino-seccion').textContent = selectedOption.dataset.seccion;
                document.getElementById('destino-rubro').textContent = selectedOption.dataset.rubro;
                document.getElementById('info-destino').style.display = 'block';
            } else {
                document.getElementById('info-destino').style.display = 'none';
            }
        }

        // Confirmar reclasificación
        async function confirmarReclasificacion(event) {
            event.preventDefault();
            
            const movimientoId = document.getElementById('reclass-movimiento-id').value;
            const nuevoCentroCosto = document.getElementById('reclass-centro-nuevo').value;
            
            if (!nuevoCentroCosto) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Seleccione destino',
                    text: 'Por favor seleccione un centro de costo destino',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            // Confirmar acción con SweetAlert2
            const selectedOption = document.getElementById('reclass-centro-nuevo').options[document.getElementById('reclass-centro-nuevo').selectedIndex];
            
            const result = await Swal.fire({
                title: '¿Está seguro de reclasificar?',
                html: `
                    <div class="text-left">
                        <p class="mb-2"><strong>De:</strong> ${movimientoActual.centroCosto} - ${movimientoActual.seccion}</p>
                        <p class="mb-2"><strong>A:</strong> ${nuevoCentroCosto} - ${selectedOption.dataset.seccion}</p>
                        <p class="mt-4 text-lg"><strong>Valor:</strong> $${new Intl.NumberFormat('es-CO').format(Math.abs(parseFloat(movimientoActual.valor) || 0))}</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, reclasificar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) {
                return;
            }
            
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Reclasificando movimiento',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            try {
                const response = await fetch('/api/secciones/reclasificar-movimiento', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        movimiento_id: parseInt(movimientoId),
                        nuevo_centro_costo: nuevoCentroCosto
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Reclasificado exitosamente!',
                        html: `
                            <div class="text-left">
                                <p class="mb-2">El gasto de <strong>$${new Intl.NumberFormat('es-CO').format(Math.abs(data.data.valor))}</strong> fue movido de:</p>
                                <p class="mb-2 text-red-600">${data.data.seccion_anterior} (${data.data.rubro_anterior})</p>
                                <p class="mb-2">A:</p>
                                <p class="text-green-600">${data.data.seccion_nueva} (${data.data.rubro_nuevo})</p>
                            </div>
                        `,
                        confirmButtonColor: '#3b82f6'
                    });
                    
                    cerrarModalReclasificar();
                    cargarDatos(); // Recargar datos para reflejar el cambio
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al reclasificar',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud: ' + error.message,
                    confirmButtonColor: '#3b82f6'
                });
            }
        }

        // Cerrar modal de reclasificación
        function cerrarModalReclasificar() {
            document.getElementById('reclasificar-modal').style.display = 'none';
            document.getElementById('form-reclasificar').reset();
            document.getElementById('info-destino').style.display = 'none';
            movimientoActual = null;
        }

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('reclasificar-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalReclasificar();
            }
        });

        // ========== FUNCIONES PARA EXCLUSIÓN DE GASTOS 2024-2025 ==========
        
        // Abrir modal de exclusión
        function abrirModalExcluir(index) {
            // Verificar permisos antes de abrir el modal
            if (!canReclassify) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sin permisos',
                    text: 'No tiene permisos para excluir movimientos. Solo usuarios con acceso total pueden realizar esta acción.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            movimientoActual = datosCompletos[index];
            
            if (!movimientoActual.id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede excluir este movimiento (ID no disponible)',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            // Llenar información del movimiento
            document.getElementById('excluir-movimiento-id').value = movimientoActual.id;
            document.getElementById('excluir-centro').textContent = movimientoActual.centroCosto || 'N/A';
            document.getElementById('excluir-seccion').textContent = movimientoActual.seccion || 'N/A';
            document.getElementById('excluir-rubro').textContent = movimientoActual.rubro || 'N/A';
            document.getElementById('excluir-descripcion').textContent = movimientoActual.descripcion || 'N/A';
            document.getElementById('excluir-fecha').textContent = movimientoActual.fecha || 'N/A';
            document.getElementById('excluir-documento').textContent = movimientoActual.documento || 'N/A';
            
            const valor = parseFloat(movimientoActual.valor) || 0;
            document.getElementById('excluir-valor').textContent = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
            
            // Mostrar modal
            document.getElementById('excluir-modal').style.display = 'flex';
        }

        // Cerrar modal de exclusión
        function cerrarModalExcluir() {
            document.getElementById('excluir-modal').style.display = 'none';
            document.getElementById('form-excluir').reset();
            movimientoActual = null;
        }

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('excluir-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalExcluir();
            }
        });

        // Confirmar exclusión
        async function confirmarExclusion(event) {
            event.preventDefault();
            
            const movimientoId = document.getElementById('excluir-movimiento-id').value;
            const motivo = document.getElementById('excluir-motivo').value;
            
            if (!movimientoId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID de movimiento no válido',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            // Confirmar con SweetAlert2
            const result = await Swal.fire({
                title: '¿Marcar como gasto 2024-2025?',
                html: `
                    <div class="text-left">
                        <p class="mb-2"><strong>Sección:</strong> ${movimientoActual.seccion}</p>
                        <p class="mb-2"><strong>Rubro:</strong> ${movimientoActual.rubro}</p>
                        <p class="mb-4 text-lg"><strong>Valor:</strong> $${new Intl.NumberFormat('es-CO').format(Math.abs(parseFloat(movimientoActual.valor)))}</p>
                        <p class="text-sm text-gray-600">Este gasto dejará de afectar el presupuesto actual (2025-2026).</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, marcar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) {
                return;
            }

            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Marcando gasto como 2024-2025',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/api/secciones/excluir-gasto-2024', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        movimiento_id: movimientoId,
                        motivo: motivo
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Gasto marcado exitosamente!',
                        text: data.message,
                        confirmButtonColor: '#d97706'
                    });
                    cerrarModalExcluir();
                    // Recargar datos para actualizar la vista
                    cargarDatos();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al excluir',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud: ' + error.message,
                    confirmButtonColor: '#3b82f6'
                });
            }
        }

        // Cargar centros de costo al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarCentrosCosto();
        });
    </script>
</x-app-layout>