<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presupuesto Secciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Mensajes de éxito -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mensajes de error -->
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Errores de validación -->
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>¡Error!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Contenido principal -->
                    <div class="text-center mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Configuración de Presupuesto por Secciones
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Gestiona y configura los presupuestos aprobados para cada sección académica en pesos colombianos.
                        </p>
                    </div>

                    <!-- Formulario para agregar nuevo presupuesto -->
                    <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-md font-semibold text-gray-700 mb-4">
                            Agregar/Actualizar Presupuesto
                        </h4>
                        
                        <form action="{{ route('presupuesto-secciones.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="seccion" class="block text-sm font-medium text-gray-700">Sección</label>
                                    <select name="seccion" id="seccion" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Seleccionar sección...</option>
                                        @foreach($secciones as $key => $nombre)
                                            <option value="{{ $key }}">{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('seccion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="presupuesto_aprobado" class="block text-sm font-medium text-gray-700">Presupuesto Aprobado (COP)</label>
                                    <input type="number" name="presupuesto_aprobado" id="presupuesto_aprobado" step="1" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ejemplo: 38000000 (sin puntos ni comas)">
                                    <p class="mt-1 text-xs text-gray-500">Ingrese el valor completo sin separadores. Ej: 38000000 para $38.000.000</p>
                                    @error('presupuesto_aprobado')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                                    <input type="text" name="descripcion" id="descripcion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Descripción del presupuesto">
                                    @error('descripcion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Guardar Presupuesto
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabla de presupuestos existentes -->
                    <div class="bg-white">
                        <h4 class="text-md font-semibold text-gray-700 mb-4">
                            Presupuestos Configurados
                        </h4>
                        
                        @if($presupuestos->count() > 0)
                            <div class="table-wrapper">
                                <table class="data-table budget-table">
                                    <thead>
                                        <tr>
                                            <th>Sección</th>
                                            <th>Presupuesto Aprobado</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($presupuestos as $presupuesto)
                                            <tr>
                                                <td style="text-align: left;">
                                                    <strong>{{ $secciones[$presupuesto->seccion] ?? $presupuesto->seccion }}</strong>
                                                </td>
                                                <td class="number-cell">
                                                    {{ $presupuesto->presupuesto_formateado }}
                                                </td>
                                                <td style="text-align: left;">
                                                    {{ $presupuesto->descripcion ?? 'Sin descripción' }}
                                                </td>
                                                <td>
                                                    <button onclick="editPresupuesto({{ $presupuesto->id }}, '{{ $presupuesto->seccion }}', {{ $presupuesto->presupuesto_aprobado }}, '{{ $presupuesto->descripcion }}')" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('presupuesto-secciones.destroy', $presupuesto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este presupuesto?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No hay presupuestos configurados aún.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar presupuesto -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Presupuesto</h3>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="seccion" id="editSeccion">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Sección</label>
                        <input type="text" id="editSeccionDisplay" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100">
                    </div>
                    
                    <div class="mb-4">
                        <label for="editPresupuesto" class="block text-sm font-medium text-gray-700">Presupuesto Aprobado (COP)</label>
                        <input type="number" name="presupuesto_aprobado" id="editPresupuesto" step="1" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Ingrese el valor completo sin separadores. Ej: 38000000 para $38.000.000</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="editDescripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <input type="text" name="descripcion" id="editDescripcion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const secciones = @json($secciones);
        
        function editPresupuesto(id, seccion, presupuesto, descripcion) {
            document.getElementById('editForm').action = `/presupuesto-secciones/${id}`;
            document.getElementById('editSeccion').value = seccion;
            document.getElementById('editSeccionDisplay').value = secciones[seccion] || seccion;
            document.getElementById('editPresupuesto').value = presupuesto;
            document.getElementById('editDescripcion').value = descripcion || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
        
        // Cerrar modal al hacer clic fuera
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Función para notificar cambios de presupuesto a la vista de secciones
        function notificarCambioPresupuesto() {
            // Intentar recargar presupuestos en la vista de secciones si está abierta
            if (window.opener && typeof window.opener.recargarPresupuestos === 'function') {
                window.opener.recargarPresupuestos();
            }
            
            // También intentar con parent window (para iframes)
            if (window.parent && typeof window.parent.recargarPresupuestos === 'function') {
                window.parent.recargarPresupuestos();
            }

            // Recargar esta página para mostrar cambios
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Interceptar envío de formularios para notificar cambios
        document.addEventListener('DOMContentLoaded', function() {
            // Formulario principal de crear/actualizar
            const mainForm = document.querySelector('form[action="{{ route('presupuesto-secciones.store') }}"]');
            if (mainForm) {
                mainForm.addEventListener('submit', function(e) {
                    setTimeout(notificarCambioPresupuesto, 500);
                });
            }

            // Formulario de edición
            const editForm = document.getElementById('editForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    setTimeout(notificarCambioPresupuesto, 500);
                });
            }

            // Formularios de eliminación
            const deleteForm = document.querySelectorAll('form[method="POST"][onsubmit*="confirm"]');
            deleteForm.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (confirm('¿Está seguro de eliminar este presupuesto?')) {
                        setTimeout(notificarCambioPresupuesto, 500);
                    }
                });
            });
        });
    </script>
</x-app-layout>