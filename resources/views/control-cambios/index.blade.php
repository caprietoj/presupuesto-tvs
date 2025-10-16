<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-history mr-2"></i>{{ __('Control de Cambios - Reclasificaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Información de ayuda -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-blue-900 mb-1">¿Cómo revertir una reclasificación?</h3>
                                <p class="text-sm text-blue-800">
                                    <span class="font-semibold">1.</span> Busca la reclasificación en la tabla usando los filtros.<br>
                                    <span class="font-semibold">2.</span> En la columna <strong>"Acciones"</strong>, haz clic en el botón naranja 
                                    <span class="inline-flex items-center justify-center w-6 h-6 bg-orange-100 text-orange-700 rounded text-xs mx-1">
                                        <i class="fas fa-undo"></i>
                                    </span> para revertir.<br>
                                    <span class="font-semibold">3.</span> Confirma la acción en el modal que aparecerá.<br>
                                    <span class="text-xs text-blue-600 mt-1 inline-block">
                                        💡 <em>El movimiento volverá a su centro de costo original automáticamente.</em>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('control-cambios.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                
                <!-- Filtro por Usuario -->
                <div>
                    <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                    <select name="usuario" id="usuario" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario }}" {{ request('usuario') == $usuario ? 'selected' : '' }}>
                                {{ $usuario }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Sección -->
                <div>
                    <label for="seccion" class="block text-sm font-medium text-gray-700 mb-1">Sección</label>
                    <select name="seccion" id="seccion" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas</option>
                        @foreach($secciones as $seccion)
                            <option value="{{ $seccion }}" {{ request('seccion') == $seccion ? 'selected' : '' }}>
                                {{ $seccion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Estado -->
                <div>
                    <label for="revertido" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="revertido" id="revertido" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="0" {{ request('revertido') === '0' ? 'selected' : '' }}>Activas</option>
                        <option value="1" {{ request('revertido') === '1' ? 'selected' : '' }}>Revertidas</option>
                    </select>
                </div>

                <!-- Fecha Desde -->
                <div>
                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Fecha Hasta -->
                <div>
                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Botones de acción -->
                <div class="col-span-1 md:col-span-3 lg:col-span-5 flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors duration-200">
                        <i class="fas fa-search text-xs mr-1.5"></i> Filtrar
                    </button>
                    <a href="{{ route('control-cambios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 transition-colors duration-200">
                        <i class="fas fa-times-circle text-xs mr-1.5"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="text-sm text-blue-600 font-medium">Total Reclasificaciones</div>
                <div class="text-2xl font-bold text-blue-800">{{ $logs->total() }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="text-sm text-green-600 font-medium">Activas</div>
                <div class="text-2xl font-bold text-green-800">{{ $logs->where('revertido', false)->count() }}</div>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="text-sm text-orange-600 font-medium">Revertidas</div>
                <div class="text-2xl font-bold text-orange-800">{{ $logs->where('revertido', true)->count() }}</div>
            </div>
        </div>

        <!-- Tabla de logs -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Movimiento</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centro de Costo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rubro</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition {{ $log->revertido ? 'opacity-60' : '' }}">
                            <!-- Fecha/Hora -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <div class="font-medium text-gray-900">{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-gray-500 text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>

                            <!-- Usuario -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                    <span class="font-medium text-gray-700">{{ $log->usuario }}</span>
                                </div>
                            </td>

                            <!-- Movimiento ID y Descripción -->
                            <td class="px-4 py-4 text-sm">
                                <div class="font-medium text-gray-900">ID: #{{ $log->movimiento_id }}</div>
                                @if($log->descripcion_movimiento)
                                    <div class="text-gray-500 text-xs truncate max-w-xs" title="{{ $log->descripcion_movimiento }}">
                                        {{ Str::limit($log->descripcion_movimiento, 40) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Centro de Costo: Anterior → Nuevo -->
                            <td class="px-4 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">
                                        {{ $log->centro_costo_anterior }}
                                    </span>
                                    <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                        {{ $log->centro_costo_nuevo }}
                                    </span>
                                </div>
                            </td>

                            <!-- Sección: Anterior → Nueva -->
                            <td class="px-4 py-4 text-sm">
                                <div class="flex flex-col gap-1">
                                    <div class="text-gray-500 text-xs">
                                        <span class="line-through">{{ $log->seccion_anterior }}</span>
                                    </div>
                                    <div class="text-gray-900 font-medium text-xs">
                                        {{ $log->seccion_nueva }}
                                    </div>
                                </div>
                            </td>

                            <!-- Rubro: Anterior → Nuevo -->
                            <td class="px-4 py-4 text-sm">
                                <div class="flex flex-col gap-1">
                                    <div class="text-gray-500 text-xs">
                                        <span class="line-through">{{ $log->rubro_anterior }}</span>
                                    </div>
                                    <div class="text-gray-900 font-medium text-xs">
                                        {{ $log->rubro_nuevo }}
                                    </div>
                                </div>
                            </td>

                            <!-- Valor -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($log->valor, 2) }}
                            </td>

                            <!-- Estado -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                @if($log->revertido)
                                    <div class="flex flex-col gap-1">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            <i class="fas fa-undo mr-1"></i> Revertida
                                        </span>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->fecha_reversion ? $log->fecha_reversion->format('d/m/Y H:i') : '' }}
                                        </div>
                                        @if($log->usuario_reversion)
                                            <div class="text-xs text-gray-500">
                                                Por: {{ $log->usuario_reversion }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Activa
                                    </span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @php
                                    // Verificar si está revertido (maneja null, 0, false, 1, true)
                                    $estaRevertido = !empty($log->revertido) && ($log->revertido == true || $log->revertido == 1);
                                @endphp
                                
                                <div class="flex gap-2 items-center justify-center">
                                    <!-- Botón Ver Detalles -->
                                    <button onclick="verDetalle({{ $log->id }})" 
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                            title="Ver detalles completos">
                                        <i class="fas fa-eye text-xs mr-1"></i>
                                        Ver
                                    </button>
                                    
                                    <!-- Botón Revertir - SOLO SI NO ESTÁ REVERTIDO -->
                                    @if(!$estaRevertido)
                                        <button onclick="confirmarReversion({{ $log->id }})" 
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200"
                                                style="background-color: #f97316; border: none; cursor: pointer;"
                                                onmouseover="this.style.backgroundColor='#ea580c'"
                                                onmouseout="this.style.backgroundColor='#f97316'"
                                                title="Revertir esta reclasificación">
                                            <i class="fas fa-undo text-xs mr-1"></i>
                                            Revertir
                                        </button>
                                    @else
                                        <!-- Ya revertida - indicador visual -->
                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-500 bg-gray-100 rounded-md cursor-not-allowed"
                                              title="Esta reclasificación ya fue revertida">
                                            <i class="fas fa-check-circle text-xs mr-1"></i>
                                            Revertida
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                <p>No se encontraron registros de reclasificaciones</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Confirmación de Reversión -->
<div id="modalReversion" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-orange-100 rounded-full p-3">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-2xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-bold text-gray-900">Confirmar Reversión</h3>
            </div>
            
            <p class="text-gray-600 mb-6 leading-relaxed">
                ¿Está seguro que desea <strong class="text-orange-600">revertir</strong> esta reclasificación? Esta acción restaurará el movimiento a su centro de costo original.
            </p>

            <div class="flex gap-3 justify-end">
                <button onclick="cerrarModalReversion()" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors duration-200">
                    <i class="fas fa-times text-xs mr-1.5"></i> Cancelar
                </button>
                <button onclick="ejecutarReversion()" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors duration-200"
                        style="background-color: #f97316; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#ea580c'"
                        onmouseout="this.style.backgroundColor='#f97316'">
                    <i class="fas fa-undo text-xs mr-1.5"></i> Revertir Cambio
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalles -->
<div id="modalDetalle" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[85vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>Detalle de Reclasificación
                </h3>
                <button onclick="cerrarModalDetalle()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="contenidoDetalle" class="space-y-4">
                <!-- Se llenará dinámicamente con JavaScript -->
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="cerrarModalDetalle()" 
                        class="inline-flex items-center px-6 py-2.5 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-times-circle mr-2"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let logIdReversion = null;

function confirmarReversion(logId) {
    logIdReversion = logId;
    document.getElementById('modalReversion').classList.remove('hidden');
}

function cerrarModalReversion() {
    logIdReversion = null;
    document.getElementById('modalReversion').classList.add('hidden');
}

function ejecutarReversion() {
    if (!logIdReversion) return;

    fetch(`/control-cambios/revertir/${logIdReversion}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            window.location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al revertir la reclasificación');
    })
    .finally(() => {
        cerrarModalReversion();
    });
}

function verDetalle(logId) {
    fetch(`/control-cambios/detalle/${logId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarDetalle(data.log);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al cargar los detalles');
    });
}

function mostrarDetalle(log) {
    const contenido = `
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-bold text-blue-800 mb-2">Información General</h4>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div><strong>ID Log:</strong> #${log.id}</div>
                    <div><strong>Movimiento ID:</strong> #${log.movimiento_id}</div>
                    <div><strong>Usuario:</strong> ${log.usuario}</div>
                    <div><strong>Fecha:</strong> ${new Date(log.created_at).toLocaleString('es-ES')}</div>
                </div>
            </div>

            <div class="col-span-2 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="font-bold text-gray-800 mb-2">Descripción del Movimiento</h4>
                <p class="text-sm text-gray-600">${log.descripcion_movimiento || 'Sin descripción'}</p>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="font-bold text-red-800 mb-2">Origen (Anterior)</h4>
                <div class="text-sm space-y-1">
                    <div><strong>Centro de Costo:</strong> ${log.centro_costo_anterior}</div>
                    <div><strong>Sección:</strong> ${log.seccion_anterior}</div>
                    <div><strong>Rubro:</strong> ${log.rubro_anterior}</div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h4 class="font-bold text-green-800 mb-2">Destino (Nuevo)</h4>
                <div class="text-sm space-y-1">
                    <div><strong>Centro de Costo:</strong> ${log.centro_costo_nuevo}</div>
                    <div><strong>Sección:</strong> ${log.seccion_nueva}</div>
                    <div><strong>Rubro:</strong> ${log.rubro_nuevo}</div>
                </div>
            </div>

            <div class="col-span-2 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-bold text-yellow-800 mb-2">Valor Reclasificado</h4>
                <p class="text-2xl font-bold text-yellow-900">$${parseFloat(log.valor).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
            </div>

            ${log.revertido ? `
            <div class="col-span-2 bg-orange-50 border border-orange-200 rounded-lg p-4">
                <h4 class="font-bold text-orange-800 mb-2">Información de Reversión</h4>
                <div class="text-sm space-y-1">
                    <div><strong>Estado:</strong> <span class="text-orange-600">Revertida</span></div>
                    <div><strong>Fecha de Reversión:</strong> ${log.fecha_reversion ? new Date(log.fecha_reversion).toLocaleString('es-ES') : 'N/A'}</div>
                    <div><strong>Revertida por:</strong> ${log.usuario_reversion || 'N/A'}</div>
                </div>
            </div>
            ` : ''}
        </div>
    `;

    document.getElementById('contenidoDetalle').innerHTML = contenido;
    document.getElementById('modalDetalle').classList.remove('hidden');
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').classList.add('hidden');
}

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModalReversion();
        cerrarModalDetalle();
    }
});
</script>

</x-app-layout>
