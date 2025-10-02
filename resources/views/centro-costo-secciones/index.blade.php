<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-cogs mr-2"></i>Configuración Centro de Costo - Secciones
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Botones de acción -->
                    <div class="flex justify-end items-center mb-6">
                        <div class="space-x-2">
                            <button type="button" 
                                    style="background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#15803d'"
                                    onmouseout="this.style.backgroundColor='#16a34a'"
                                    onclick="document.getElementById('modalAgregar').style.display='block'">
                                ➕ Agregar
                            </button>
                            <button type="button" 
                                    style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer;"
                                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                                    onmouseout="this.style.backgroundColor='#2563eb'"
                                    onclick="cargarDatosIniciales()">
                                💾 Cargar Datos Iniciales
                            </button>
                        </div>
                    </div>

                    <!-- Notificaciones -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="centro_costo" class="block text-sm font-medium text-gray-700">Centro de Costo</label>
                                <input type="text" 
                                       name="centro_costo" 
                                       id="centro_costo"
                                       value="{{ request('centro_costo') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="Buscar centro de costo..."
                                       oninput="filtrarTabla()">
                            </div>
                            <div>
                                <label for="rubro" class="block text-sm font-medium text-gray-700">Rubro</label>
                                <input type="text" 
                                       name="rubro" 
                                       id="rubro"
                                       value="{{ request('rubro') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="Buscar rubro..."
                                       oninput="filtrarTabla()">
                            </div>
                            <div>
                                <label for="seccion" class="block text-sm font-medium text-gray-700">Sección</label>
                                <input type="text" 
                                       name="seccion" 
                                       id="seccion"
                                       value="{{ request('seccion') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="Buscar sección..."
                                       oninput="filtrarTabla()">
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" 
                                    onclick="limpiarFiltros()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-times mr-1"></i>Limpiar Filtros
                            </button>
                        </div>
                    </div>

                    <!-- Información de registros -->
                    <div class="mb-4 text-sm text-gray-700">
                        @if($centrosCosto->total() > 0)
                            Mostrando {{ $centrosCosto->firstItem() }} a {{ $centrosCosto->lastItem() }} de {{ $centrosCosto->total() }} registros
                        @else
                            No hay registros para mostrar
                        @endif
                    </div>

                    <!-- Tabla -->
                    <div class="table-wrapper">
                        <table id="tablaCentrosCosto" class="data-table budget-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Centro de Costo</th>
                                    <th style="text-align: left;">Rubro</th>
                                    <th style="text-align: left;">Sección</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($centrosCosto as $centro)
                                    <tr>
                                        <td style="text-align: left;">{{ $centro->centro_costo }}</td>
                                        <td style="text-align: left;">{{ $centro->rubro }}</td>
                                        <td style="text-align: left;">{{ $centro->seccion }}</td>
                                        <td style="text-align: center;">
                                            <button type="button" 
                                                    class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded text-xs text-white hover:bg-blue-700 mr-2"
                                                    onclick="editarCentro({{ $centro->id }}, '{{ addslashes($centro->centro_costo) }}', '{{ addslashes($centro->rubro) }}', '{{ addslashes($centro->seccion) }}')">
                                                <i class="fas fa-edit mr-1"></i>Editar
                                            </button>
                                            <button type="button" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded text-xs text-white hover:bg-red-700"
                                                    onclick="eliminarCentro({{ $centro->id }}, '{{ addslashes($centro->centro_costo) }}')">
                                                <i class="fas fa-trash mr-1"></i>Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 20px;">
                                            No hay centros de costo configurados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $centrosCosto->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar -->
    <div id="modalAgregar" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Agregar Centro de Costo</h3>
                    <button type="button" onclick="document.getElementById('modalAgregar').style.display='none'" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('centro-costo-secciones.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="centro_costo" class="block text-sm font-medium text-gray-700">Centro de Costo</label>
                            <input type="text" name="centro_costo" required maxlength="10"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="rubro" class="block text-sm font-medium text-gray-700">Rubro</label>
                            <input type="text" name="rubro" required maxlength="255"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="seccion" class="block text-sm font-medium text-gray-700">Sección</label>
                            <input type="text" name="seccion" required maxlength="255"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" 
                                onclick="document.getElementById('modalAgregar').style.display='none'"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-save mr-1"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="modalEditar" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Editar Centro de Costo</h3>
                    <button type="button" onclick="document.getElementById('modalEditar').style.display='none'" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="editCentroCosto" class="block text-sm font-medium text-gray-700">Centro de Costo</label>
                            <input type="text" name="centro_costo" id="editCentroCosto" required maxlength="10"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="editRubro" class="block text-sm font-medium text-gray-700">Rubro</label>
                            <input type="text" name="rubro" id="editRubro" required maxlength="255"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="editSeccion" class="block text-sm font-medium text-gray-700">Sección</label>
                            <input type="text" name="seccion" id="editSeccion" required maxlength="255"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" 
                                onclick="document.getElementById('modalEditar').style.display='none'"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-save mr-1"></i>Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form oculto para eliminar -->
    <form id="formEliminar" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
    function editarCentro(id, centroCosto, rubro, seccion) {
        document.getElementById('formEditar').action = `/centro-costo-secciones/${id}`;
        document.getElementById('editCentroCosto').value = centroCosto;
        document.getElementById('editRubro').value = rubro;
        document.getElementById('editSeccion').value = seccion;
        document.getElementById('modalEditar').style.display = 'block';
    }

    function eliminarCentro(id, centroCosto) {
        if (confirm(`¿Está seguro de eliminar el centro de costo ${centroCosto}?`)) {
            const form = document.getElementById('formEliminar');
            form.action = `/centro-costo-secciones/${id}`;
            form.submit();
        }
    }

    function cargarDatosIniciales() {
        if (confirm('¿Está seguro de cargar los datos iniciales? Esto puede tomar unos segundos.')) {
            window.location.href = '{{ route("centro-costo-secciones.bulk-insert") }}';
        }
    }

    // Filtrado automático en tiempo real
    function filtrarTabla() {
        const centroCosto = document.getElementById('centro_costo').value.toLowerCase();
        const rubro = document.getElementById('rubro').value.toLowerCase();
        const seccion = document.getElementById('seccion').value.toLowerCase();
        
        const tabla = document.getElementById('tablaCentrosCosto');
        const filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        let filasVisibles = 0;
        
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            
            // Saltar la fila de "no hay registros"
            if (fila.cells.length === 1) continue;
            
            const textoCentroCosto = fila.cells[0].textContent.toLowerCase();
            const textoRubro = fila.cells[1].textContent.toLowerCase();
            const textoSeccion = fila.cells[2].textContent.toLowerCase();
            
            const coincideCentroCosto = centroCosto === '' || textoCentroCosto.includes(centroCosto);
            const coincideRubro = rubro === '' || textoRubro.includes(rubro);
            const coincideSeccion = seccion === '' || textoSeccion.includes(seccion);
            
            if (coincideCentroCosto && coincideRubro && coincideSeccion) {
                fila.style.display = '';
                filasVisibles++;
            } else {
                fila.style.display = 'none';
            }
        }
        
        // Actualizar mensaje de registros
        actualizarMensajeRegistros(filasVisibles);
    }
    
    function actualizarMensajeRegistros(filasVisibles) {
        const totalRegistros = {{ $centrosCosto->total() }};
        const mensajeDiv = document.querySelector('.mb-4.text-sm.text-gray-700');
        
        if (filasVisibles === 0) {
            mensajeDiv.textContent = 'No se encontraron registros que coincidan con los filtros';
        } else if (filasVisibles === totalRegistros) {
            mensajeDiv.textContent = `Mostrando todos los ${totalRegistros} registros`;
        } else {
            mensajeDiv.textContent = `Mostrando ${filasVisibles} de ${totalRegistros} registros (filtrado)`;
        }
    }
    
    function limpiarFiltros() {
        document.getElementById('centro_costo').value = '';
        document.getElementById('rubro').value = '';
        document.getElementById('seccion').value = '';
        filtrarTabla();
    }
    </script>
</x-app-layout>