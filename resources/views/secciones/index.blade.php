<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Secciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Contenido principal -->
                    <div class="text-center mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Sistema de Presupuesto TVS
                        </h3>
                        <p class="text-gray-600 mb-6">
                            Página de secciones del sistema presupuestal.
                        </p>
                    </div>

                    <!-- Navegador de Tablas -->
                    <div class="mb-6">
                        <label for="section-navigator" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por sección:</label>
                        <select id="section-navigator" class="block w-full max-w-xs px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Mostrar todas las secciones</option>
                            <option value="preescolar">PREESCOLAR Y PRIMARIA</option>
                            <option value="escuela-media">ESCUELA MEDIA</option>
                            <option value="escuela-alta">ESCUELA ALTA</option>
                            <option value="pai">PAI</option>
                            <option value="pep">PEP</option>
                            <option value="deportes">DEPORTES</option>
                            <option value="biblioteca">BIBLIOTECA</option>
                            <option value="psicologia">PSICOLOGÍA INSTITUCIONAL</option>
                            <option value="cas">CAS</option>
                            <option value="consejeria-universitaria">CONSEJERÍA UNIVERSITARIA</option>
                            <option value="departamento-apoyo">DEPARTAMENTO DE APOYO</option>
                        </select>
                    </div>

                    <!-- Tabla Preescolar y Primaria -->
                    <div class="budget-section" id="preescolar-section">
                        <h5 id="table-preescolar" class="flex justify-between items-center">
                            <span>PREESCOLAR Y PRIMARIA</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="preescolar-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="preescolar-tbody">
                                    <tr>
                                        <td>Capacitación</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Capacitación" data-type="presupuesto" data-value="0">$0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Capacitación" data-type="ejecucion" data-value="0">$0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Importado</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Material Importado" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Material Importado" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Deportivo</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Material Deportivo" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Material Deportivo" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Musicales</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Musicales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Musicales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Part time teacher - reemplazos</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Part time teacher - reemplazos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Part time teacher - reemplazos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Apoyo Institucional</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Apoyo Institucional" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Apoyo Institucional" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Eventos Académicos y Sociales</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Eventos Académicos y Sociales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Eventos Académicos y Sociales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos Tecnológicos</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Insumos Tecnológicos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Insumos Tecnológicos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Salidas Académicas Sección</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Salidas Académicas Sección" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Salidas Académicas Sección" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Alimentación</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Alimentación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Alimentación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Transporte</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Transporte" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Transporte" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos de la Sección / Material para Clase</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Insumos de la Sección / Material para Clase" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="preescolar" data-concept="Insumos de la Sección / Material para Clase" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Escuela Media -->
                    <div class="budget-section" id="escuela-media-section">
                        <h5 id="table-escuela-media" class="flex justify-between items-center">
                            <span>ESCUELA MEDIA</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="escuela-media-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="escuela-media-tbody">
                                    <tr>
                                        <td>Capacitación</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Capacitación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Capacitación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Importado</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Material Importado" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Material Importado" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Deportivo</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Material Deportivo" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Material Deportivo" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Musicales</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Musicales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Musicales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Part time teacher - reemplazos</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Part time teacher - reemplazos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Part time teacher - reemplazos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Proyecto Comunitario</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Proyecto Comunitario" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Proyecto Comunitario" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>MUN TVS - Otros Colegios - GLY</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="MUN TVS - Otros Colegios - GLY" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="MUN TVS - Otros Colegios - GLY" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Apoyo Institucional</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Apoyo Institucional" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Apoyo Institucional" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Eventos Académicos y Sociales</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Eventos Académicos y Sociales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Eventos Académicos y Sociales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos Tecnológicos</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Insumos Tecnológicos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Insumos Tecnológicos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Salidas Académicas Sección</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Salidas Académicas Sección" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Salidas Académicas Sección" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Alimentación</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Alimentación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Alimentación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Transporte</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Transporte" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Transporte" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos de la Sección / Material para Clase</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Insumos de la Sección / Material para Clase" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-media" data-concept="Insumos de la Sección / Material para Clase" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Escuela Alta -->
                    <div class="budget-section" id="escuela-alta-section">
                        <h5 id="table-escuela-alta" class="flex justify-between items-center">
                            <span>ESCUELA ALTA</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="escuela-alta-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="escuela-alta-tbody">
                                    <tr>
                                        <td>Capacitación</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Capacitación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Capacitación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Importado</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Material Importado" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Material Importado" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Deportivo</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Material Deportivo" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Material Deportivo" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Musicales</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Musicales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Musicales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Part time teacher - reemplazos</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Part time teacher - reemplazos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Part time teacher - reemplazos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Monografía</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Monografía" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Monografía" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>MUN TVS - Otros Colegios - GLY</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="MUN TVS - Otros Colegios - GLY" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="MUN TVS - Otros Colegios - GLY" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Preparación Pruebas Saber</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Preparación Pruebas Saber" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Preparación Pruebas Saber" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Eventos Académicos y Sociales</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Eventos Académicos y Sociales" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Eventos Académicos y Sociales" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos Tecnológicos</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Insumos Tecnológicos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Insumos Tecnológicos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Insumos de la Sección / Material para Clase</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Insumos de la Sección / Material para Clase" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="escuela-alta" data-concept="Insumos de la Sección / Material para Clase" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla PAI -->
                    <div class="budget-section" id="pai-section">
                        <h5 id="table-pai" class="flex justify-between items-center">
                            <span>PAI</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="pai-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="pai-tbody">
                                    <tr>
                                        <td>Capacitación</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Capacitación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Capacitación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Importado</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Material Importado" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Material Importado" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Proyecto Comunitario</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Proyecto Comunitario" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Proyecto Comunitario" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Proyecto Personal</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Proyecto Personal" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pai" data-concept="Proyecto Personal" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla PEP -->
                    <div class="budget-section" id="pep-section">
                        <h5 id="table-pep" class="flex justify-between items-center">
                            <span>PEP</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="pep-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="pep-tbody">
                                    <tr>
                                        <td>Capacitación</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Capacitación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Capacitación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Material Importado</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Material Importado" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Material Importado" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Exhibición PEP</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Exhibición PEP" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="pep" data-concept="Exhibición PEP" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Deportes -->
                    <div class="budget-section" id="deportes-section">
                        <h5 id="table-deportes" class="flex justify-between items-center">
                            <span>DEPORTES</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="deportes-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="deportes-tbody">
                                    <tr>
                                        <td>Dotación - Deportes</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Dotación - Deportes" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Dotación - Deportes" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Transporte</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Transporte" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Transporte" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Alimentación</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Alimentación" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Alimentación" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr>
                                        <td>Participación en Eventos</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Participación en Eventos" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="deportes" data-concept="Participación en Eventos" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Biblioteca -->
                    <div class="budget-section" id="biblioteca-section">
                        <h5 id="table-biblioteca" class="flex justify-between items-center">
                            <span>BIBLIOTECA</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="biblioteca-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="biblioteca-tbody">
                                    <tr>
                                        <td>Biblioteca Institucional</td>
                                        <td class="number-cell editable" data-section="biblioteca" data-concept="Biblioteca Institucional" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="biblioteca" data-concept="Biblioteca Institucional" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Psicología Institucional -->
                    <div class="budget-section" id="psicologia-section">
                        <h5 id="table-psicologia" class="flex justify-between items-center">
                            <span>PSICOLOGÍA INSTITUCIONAL</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="psicologia-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="psicologia-tbody">
                                    <tr>
                                        <td>Psicología Institucional</td>
                                        <td class="number-cell editable" data-section="psicologia" data-concept="Psicología Institucional" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="psicologia" data-concept="Psicología Institucional" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla CAS -->
                    <div class="budget-section" id="cas-section">
                        <h5 id="table-cas" class="flex justify-between items-center">
                            <span>CAS</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="cas-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="cas-tbody">
                                    <tr>
                                        <td>Actividades CAS</td>
                                        <td class="number-cell editable" data-section="cas" data-concept="Actividades CAS" data-type="presupuesto">0</td>
                                        <td class="number-cell editable" data-section="cas" data-concept="Actividades CAS" data-type="ejecucion">0</td>
                                        <td class="number-cell calculated positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Consejería Universitaria -->
                    <div class="budget-section" id="consejeria-universitaria-section">
                        <h5 id="table-consejeria-universitaria" class="flex justify-between items-center">
                            <span>CONSEJERÍA UNIVERSITARIA</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="consejeria-universitaria-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="consejeria-universitaria-tbody">
                                    <tr>
                                        <td>Orientación Universitaria</td>
                                        <td class="number-cell">0</td>
                                        <td class="number-cell clickable-value" data-type="ejecucion" data-concepto="Orientación Universitaria" data-seccion="consejeria-universitaria">0</td>
                                        <td class="number-cell positive">0</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla Departamento de Apoyo -->
                    <div class="budget-section" id="departamento-apoyo-section">
                        <h5 id="table-departamento-apoyo" class="flex justify-between items-center">
                            <span>DEPARTAMENTO DE APOYO</span>
                            <span class="text-sm font-normal text-gray-600">Presupuesto Aprobado:</span>
                        </h5>
                        <div class="table-wrapper">
                            <table id="departamento-apoyo-table" class="data-table budget-table">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Presupuesto</th>
                                        <th>Ejecución</th>
                                        <th>Saldo por ejecutar</th>
                                    </tr>
                                </thead>
                                <tbody id="departamento-apoyo-tbody">
                                    <tr class="total-row">
                                        <td><strong>TOTAL</strong></td>
                                        <td class="number-cell total-presupuesto">0</td>
                                        <td class="number-cell total-ejecucion">0</td>
                                        <td class="number-cell total-saldo positive">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar detalles de movimientos -->
    <div id="modal-detalle-movimiento" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-titulo">Detalle de Movimientos</h3>
                <button onclick="cerrarModalEjecucion()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="modal-movimientos-container">
                    <!-- Aquí se cargarán los movimientos -->
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos para el modal -->
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-width: 90%;
            max-height: 90%;
            width: 800px;
            overflow: hidden;
        }

        .modal-header {
            background-color: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 1.5rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .clickable-value {
            cursor: pointer !important;
            transition: background-color 0.2s ease;
        }

        .clickable-value:hover {
            background-color: #f0f8ff !important;
        }

        .positive-value {
            color: #059669;
        }

        .negative-value {
            color: #dc2626;
        }

        .movimiento-item {
            background-color: #f9f9f9;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .movimiento-valor {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .movimiento-detalle {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
    </style>

    <!-- JavaScript para filtrado de secciones -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtro de secciones por visibilidad
            document.getElementById('section-navigator').addEventListener('change', function(event) {
                var selectedSection = event.target.value;
                
                // Obtener todas las secciones
                var allSections = document.querySelectorAll('.budget-section');
                
                if (selectedSection === '') {
                    // Mostrar todas las secciones
                    allSections.forEach(function(section) {
                        section.style.display = 'block';
                    });
                } else {
                    // Ocultar todas las secciones
                    allSections.forEach(function(section) {
                        section.style.display = 'none';
                    });
                    
                    // Mostrar solo la sección seleccionada
                    var targetSection = document.getElementById(selectedSection + '-section');
                    if (targetSection) {
                        targetSection.style.display = 'block';
                    }
                }
            });
        });

        // Cargar presupuestos aprobados
        function cargarPresupuestosAprobados() {
            fetch('/api/presupuestos-secciones')
                .then(response => response.json())
                .then(data => {
                    // Mapeo de secciones
                    const mapeoSecciones = {
                        'preescolar': 'table-preescolar',
                        'escuela-media': 'table-escuela-media',
                        'escuela-alta': 'table-escuela-alta',
                        'pai': 'table-pai',
                        'pep': 'table-pep',
                        'deportes': 'table-deportes',
                        'biblioteca': 'table-biblioteca',
                        'psicologia': 'table-psicologia',
                        'cas': 'table-cas',
                        'consejeria-universitaria': 'table-consejeria-universitaria',
                        'departamento-apoyo': 'table-departamento-apoyo'
                    };

                    // Actualizar cada sección con su presupuesto
                    Object.keys(mapeoSecciones).forEach(seccion => {
                        const elementoId = mapeoSecciones[seccion];
                        const elemento = document.getElementById(elementoId);
                        
                        if (elemento) {
                            const spanPresupuesto = elemento.querySelector('span:last-child');
                            const presupuesto = data[seccion];
                            
                            if (spanPresupuesto) {
                                if (presupuesto && presupuesto > 0) {
                                    const presupuestoFormateado = '$' + new Intl.NumberFormat('es-CO').format(presupuesto);
                                    spanPresupuesto.textContent = `Presupuesto Aprobado: ${presupuestoFormateado}`;
                                    spanPresupuesto.classList.remove('text-gray-600');
                                    spanPresupuesto.classList.add('text-green-600', 'font-medium');
                                } else {
                                    spanPresupuesto.textContent = 'Presupuesto Aprobado: No configurado';
                                    spanPresupuesto.classList.remove('text-green-600', 'font-medium');
                                    spanPresupuesto.classList.add('text-gray-600');
                                }
                            }
                            
                            // Distribuir presupuesto entre los items de la tabla
                            distribuirPresupuestoEnTabla(seccion, presupuesto || 0);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al cargar presupuestos:', error);
                });
        }

        // Función para cargar datos de ejecución de PREESCOLAR Y PRIMARIA
        function cargarEjecucionPreescolarPrimaria() {
            fetch('/api/secciones/ejecucion-preescolar-primaria')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = info.valor;
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('preescolar-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // Agregar clases para modal y almacenar datos
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        // Aplicar color según el valor
                                        if (valor < 0) {
                                            celdaEjecucion.classList.add('negative-value');
                                            celdaEjecucion.classList.remove('positive-value');
                                        } else {
                                            celdaEjecucion.classList.add('positive-value');
                                            celdaEjecucion.classList.remove('negative-value');
                                        }
                                    }
                                    
                                    // Recalcular saldo de esta fila
                                    recalcularSaldoFila(fila);
                                }
                            });
                        }
                    });
                    
                    // Actualizar totales de la sección preescolar
                    const tbody = document.getElementById('preescolar-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'preescolar');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución:', error);
                });
        }

        // Función para cargar datos de ejecución de ESCUELA MEDIA
        function cargarEjecucionEscuelaMedia() {
            fetch('/api/secciones/ejecucion-escuela-media')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución ESCUELA MEDIA recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = info.valor;
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('escuela-media-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // Agregar clases para modal y almacenar datos
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        // Aplicar color según el valor
                                        if (valor < 0) {
                                            celdaEjecucion.classList.add('negative-value');
                                            celdaEjecucion.classList.remove('positive-value');
                                        } else {
                                            celdaEjecucion.classList.add('positive-value');
                                            celdaEjecucion.classList.remove('negative-value');
                                        }
                                    }
                                    
                                    // Recalcular saldo de esta fila
                                    recalcularSaldoFila(fila);
                                }
                            });
                        }
                    });
                    
                    // Actualizar totales de la sección escuela media
                    const tbody = document.getElementById('escuela-media-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'escuela-media');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución ESCUELA MEDIA:', error);
                });
        }

        // Función para cargar datos de ejecución de ESCUELA ALTA
        function cargarEjecucionEscuelaAlta() {
            fetch('/api/secciones/ejecucion-escuela-alta')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución ESCUELA ALTA recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = info.valor;
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('escuela-alta-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // Agregar clases para modal y almacenar datos
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        // Aplicar color según el valor
                                        if (valor < 0) {
                                            celdaEjecucion.classList.add('negative-value');
                                            celdaEjecucion.classList.remove('positive-value');
                                        } else {
                                            celdaEjecucion.classList.add('positive-value');
                                            celdaEjecucion.classList.remove('negative-value');
                                        }
                                    }
                                    
                                    // Recalcular saldo de esta fila
                                    recalcularSaldoFila(fila);
                                }
                            });
                        }
                    });
                    
                    // Actualizar totales de la sección escuela alta
                    const tbody = document.getElementById('escuela-alta-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'escuela-alta');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución ESCUELA ALTA:', error);
                });
        }

        // Función para cargar datos de ejecución de PEP
        function cargarEjecucionPep() {
            fetch('/api/secciones/ejecucion-pep')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución PEP recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto PEP:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('pep-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección pep
                    const tbody = document.getElementById('pep-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'pep');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución PEP:', error);
                });
        }

        // Función para cargar datos de ejecución de BIBLIOTECA
        function cargarEjecucionBiblioteca() {
            fetch('/api/secciones/ejecucion-biblioteca')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución BIBLIOTECA recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto BIBLIOTECA:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('biblioteca-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección biblioteca
                    const tbody = document.getElementById('biblioteca-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'biblioteca');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución BIBLIOTECA:', error);
                });
        }

        // Función para cargar datos de ejecución de PSICOLOGÍA INSTITUCIONAL
        function cargarEjecucionPsicologia() {
            fetch('/api/secciones/ejecucion-psicologia')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución PSICOLOGÍA INSTITUCIONAL recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto PSICOLOGÍA:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('psicologia-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección psicología
                    const tbody = document.getElementById('psicologia-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'psicologia');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución PSICOLOGÍA INSTITUCIONAL:', error);
                });
        }

        // Función para cargar datos de ejecución de CAS
        function cargarEjecucionCas() {
            fetch('/api/secciones/ejecucion-cas')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución CAS recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto CAS:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('cas-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección cas
                    const tbody = document.getElementById('cas-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'cas');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución CAS:', error);
                });
        }

        // Función para cargar datos de ejecución de CONSEJERÍA UNIVERSITARIA
        function cargarEjecucionConsejeriaUniversitaria() {
            fetch('/api/secciones/ejecucion-consejeria-universitaria')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución Consejería Universitaria recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto Consejería Universitaria:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('consejeria-universitaria-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección consejeria-universitaria
                    const tbody = document.getElementById('consejeria-universitaria-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'consejeria-universitaria');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución Consejería Universitaria:', error);
                });
        }

        // Función para cargar datos de ejecución de PAI
        function cargarEjecucionPai() {
            fetch('/api/secciones/ejecucion-pai')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos de ejecución PAI recibidos:', data);
                    
                    // Actualizar cada concepto en la tabla
                    Object.keys(data).forEach(concepto => {
                        const info = data[concepto];
                        const valor = parseFloat(info.valor) || 0;
                        
                        console.log('Procesando concepto PAI:', concepto, 'Valor:', valor, 'Movimientos:', info.totalMovimientos);
                        
                        // Buscar la fila correspondiente al concepto
                        const tbody = document.getElementById('pai-tbody');
                        if (tbody) {
                            const filas = tbody.querySelectorAll('tr:not(.total-row)');
                            filas.forEach(fila => {
                                const celdaConcepto = fila.querySelector('td:first-child');
                                if (celdaConcepto && celdaConcepto.textContent.trim() === concepto) {
                                    console.log('Encontrada fila para:', concepto);
                                    
                                    // Actualizar celda de ejecución
                                    const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                                    if (celdaEjecucion) {
                                        const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                                        celdaEjecucion.textContent = valorFormateado;
                                        celdaEjecucion.setAttribute('data-value', valor);
                                        
                                        // SIEMPRE agregar modal (incluso para valor 0) - igual que otras secciones
                                        celdaEjecucion.classList.add('clickable-value');
                                        celdaEjecucion.style.cursor = 'pointer';
                                        celdaEjecucion.setAttribute('data-movimientos', JSON.stringify(info.movimientos));
                                        celdaEjecucion.setAttribute('data-concepto', concepto);
                                        celdaEjecucion.setAttribute('title', 'Clic para ver detalles');
                                        
                                        // Agregar evento de clic para el modal - IGUAL QUE OTRAS SECCIONES
                                        celdaEjecucion.addEventListener('click', function() {
                                            mostrarModalEjecucion(concepto, info);
                                        });
                                        
                                        console.log('Modal configurado para:', concepto, 'con', info.totalMovimientos, 'movimientos');
                                    }
                                }
                            });
                        }
                    });

                    // Actualizar totales de la sección pai
                    const tbody = document.getElementById('pai-tbody');
                    if (tbody) {
                        actualizarFilaTotal(tbody, 'pai');
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos de ejecución PAI:', error);
                });
        }

        // Función para formatear fechas
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

        // Función para mostrar el modal con detalles de movimientos
        function mostrarModalEjecucion(concepto, info) {
            const modal = document.getElementById('modal-detalle-movimiento');
            const titulo = document.getElementById('modal-titulo');
            const container = document.getElementById('modal-movimientos-container');

            titulo.textContent = `${concepto} - ${info.totalMovimientos} movimiento(s)`;

            // Generar HTML de los movimientos
            let movimientosHTML = '';
            
            if (info.movimientos && info.movimientos.length > 0) {
                info.movimientos.forEach((movimiento, index) => {
                    const valor = parseFloat(movimiento.valor || 0);
                    const valorFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valor));
                    const fechaFormateada = formatearFecha(movimiento.fecha);
                    
                    movimientosHTML += `
                        <div class="movimiento-item">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <div class="font-semibold">${movimiento.descripcion || 'Sin descripción'}</div>
                                    <div class="text-sm text-gray-600">Doc: ${movimiento.documento || 'N/A'} | Fecha: ${fechaFormateada}</div>
                                </div>
                                <div class="movimiento-valor ${valor < 0 ? 'negative-value' : 'positive-value'}">
                                    ${valorFormateado}
                                </div>
                            </div>
                            <div class="movimiento-detalle">
                                <div><strong>Cuenta:</strong> ${movimiento.cuenta || 'N/A'}</div>
                                <div><strong>Sección:</strong> ${movimiento.seccion || 'N/A'}</div>
                                <div><strong>Rubro:</strong> ${movimiento.rubro || 'N/A'}</div>
                                <div><strong>Centro Costo:</strong> ${movimiento.centro_costo || 'N/A'}</div>
                                ${movimiento.tercero ? `<div><strong>Tercero:</strong> ${movimiento.tercero}</div>` : ''}
                                ${movimiento.nombre_tercero ? `<div><strong>Nombre Tercero:</strong> ${movimiento.nombre_tercero}</div>` : ''}
                                ${movimiento.cliente_proveedor ? `<div><strong>Cliente/Proveedor:</strong> ${movimiento.cliente_proveedor}</div>` : ''}
                                ${movimiento.nombre_cliente_proveedor ? `<div><strong>Nombre Cliente/Proveedor:</strong> ${movimiento.nombre_cliente_proveedor}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
            } else {
                movimientosHTML = '<div class="text-center text-gray-500 py-8">No hay movimientos para mostrar</div>';
            }

            // Agregar resumen al inicio
            const valorTotal = info.valor || 0;
            const valorTotalFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(valorTotal));
            
            const resumenHTML = `
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h4 class="font-semibold text-blue-900 mb-2">Resumen</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-blue-700">Total de movimientos:</span>
                            <div class="font-semibold">${info.totalMovimientos}</div>
                        </div>
                        <div>
                            <span class="text-sm text-blue-700">Valor total:</span>
                            <div class="font-semibold ${valorTotal < 0 ? 'negative-value' : 'positive-value'}">${valorTotalFormateado}</div>
                        </div>
                    </div>
                </div>
            `;

            container.innerHTML = resumenHTML + movimientosHTML;
            modal.style.display = 'flex';
        }

        // Función para cerrar el modal
        function cerrarModalEjecucion() {
            const modal = document.getElementById('modal-detalle-movimiento');
            modal.style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('modal-detalle-movimiento');
            if (event.target === modal) {
                cerrarModalEjecucion();
            }
        });

        // Función para recargar presupuestos (útil para llamar desde el CRUD)
        function recargarPresupuestos() {
            cargarPresupuestosAprobados();
        }

        // Hacer la función accesible globalmente para uso desde otras páginas
        window.recargarPresupuestos = recargarPresupuestos;

        // Función para distribuir el presupuesto entre los items de una tabla
        function distribuirPresupuestoEnTabla(seccion, presupuestoTotal) {
            const tbody = document.getElementById(seccion + '-tbody');
            if (!tbody) return;
            
            // Obtener todas las filas que no sean la fila total
            const filas = tbody.querySelectorAll('tr:not(.total-row)');
            const numeroItems = filas.length;
            
            if (numeroItems === 0) return;
            
            // Calcular presupuesto por item
            const presupuestoPorItem = presupuestoTotal > 0 ? Math.floor(presupuestoTotal / numeroItems) : 0;
            let presupuestoRestante = presupuestoTotal - (presupuestoPorItem * numeroItems);
            
            // Asignar presupuesto a cada item
            filas.forEach((fila, index) => {
                const celdaPresupuesto = fila.querySelector('td.number-cell[data-type="presupuesto"]');
                if (celdaPresupuesto) {
                    let presupuestoParaItem = presupuestoPorItem;
                    
                    // Agregar el resto al último item para que el total coincida exactamente
                    if (index === numeroItems - 1) {
                        presupuestoParaItem += presupuestoRestante;
                    }
                    
                    const presupuestoFormateado = presupuestoParaItem > 0 ? '$' + new Intl.NumberFormat('es-CO').format(presupuestoParaItem) : '$0';
                    celdaPresupuesto.textContent = presupuestoFormateado;
                    // Actualizar el atributo data para mantener consistencia
                    celdaPresupuesto.setAttribute('data-value', presupuestoParaItem);
                }
                
                // Recalcular el saldo (presupuesto - ejecución)
                recalcularSaldoFila(fila);
            });
            
            // Actualizar fila total
            actualizarFilaTotal(tbody, seccion);
        }

        // Función para recalcular el saldo de una fila
        function recalcularSaldoFila(fila) {
            const celdaPresupuesto = fila.querySelector('td.number-cell[data-type="presupuesto"]');
            const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
            const celdaSaldo = fila.querySelector('td.number-cell.calculated');
            
            if (celdaPresupuesto && celdaEjecucion && celdaSaldo) {
                const presupuesto = parseFloat(celdaPresupuesto.getAttribute('data-value') || '0');
                const ejecucion = parseFloat(celdaEjecucion.getAttribute('data-value') || '0');
                const saldo = presupuesto - ejecucion;
                
                const saldoFormateado = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(saldo));
                celdaSaldo.textContent = saldoFormateado;
                
                // Actualizar clases según el signo del saldo
                celdaSaldo.classList.remove('positive', 'negative');
                celdaSaldo.classList.add(saldo >= 0 ? 'positive' : 'negative');
            }
        }

        // Función para actualizar la fila total
        function actualizarFilaTotal(tbody, seccion) {
            const filas = tbody.querySelectorAll('tr:not(.total-row)');
            const filaTotalRow = tbody.querySelector('tr.total-row');
            
            if (!filaTotalRow) return;
            
            let totalPresupuesto = 0;
            let totalEjecucion = 0;
            
            filas.forEach(fila => {
                const celdaPresupuesto = fila.querySelector('td.number-cell[data-type="presupuesto"]');
                const celdaEjecucion = fila.querySelector('td.number-cell[data-type="ejecucion"]');
                
                if (celdaPresupuesto) {
                    totalPresupuesto += parseFloat(celdaPresupuesto.getAttribute('data-value') || '0');
                }
                if (celdaEjecucion) {
                    totalEjecucion += parseFloat(celdaEjecucion.getAttribute('data-value') || '0');
                }
            });
            
            const totalSaldo = totalPresupuesto - totalEjecucion;
            
            // Actualizar celdas de totales
            const celdaTotalPresupuesto = filaTotalRow.querySelector('td.total-presupuesto');
            const celdaTotalEjecucion = filaTotalRow.querySelector('td.total-ejecucion');
            const celdaTotalSaldo = filaTotalRow.querySelector('td.total-saldo');
            
            if (celdaTotalPresupuesto) {
                celdaTotalPresupuesto.textContent = '$' + new Intl.NumberFormat('es-CO').format(totalPresupuesto);
            }
            if (celdaTotalEjecucion) {
                celdaTotalEjecucion.textContent = '$' + new Intl.NumberFormat('es-CO').format(totalEjecucion);
            }
            if (celdaTotalSaldo) {
                celdaTotalSaldo.textContent = '$' + new Intl.NumberFormat('es-CO').format(Math.abs(totalSaldo));
                celdaTotalSaldo.classList.remove('positive', 'negative');
                celdaTotalSaldo.classList.add(totalSaldo >= 0 ? 'positive' : 'negative');
            }
        }

        // Cargar presupuestos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            inicializarAtributos();
            cargarPresupuestosAprobados();
            cargarEjecucionPreescolarPrimaria();
            cargarEjecucionEscuelaMedia();
            cargarEjecucionEscuelaAlta();
            cargarEjecucionPep();
            cargarEjecucionBiblioteca();
            cargarEjecucionPsicologia();
            cargarEjecucionCas();
            cargarEjecucionConsejeriaUniversitaria();
            cargarEjecucionPai();
        });

        // Función para inicializar todos los atributos data-value y formato de moneda
        function inicializarAtributos() {
            // Inicializar todas las celdas editables
            const celdasEditables = document.querySelectorAll('td.number-cell.editable');
            celdasEditables.forEach(celda => {
                if (!celda.hasAttribute('data-value')) {
                    celda.setAttribute('data-value', '0');
                }
                // Formatear como moneda si no está ya formateado
                if (!celda.textContent.includes('$')) {
                    celda.textContent = '$0';
                }
            });

            // Inicializar todas las celdas calculadas
            const celdasCalculadas = document.querySelectorAll('td.number-cell.calculated');
            celdasCalculadas.forEach(celda => {
                if (!celda.textContent.includes('$')) {
                    celda.textContent = '$0';
                }
            });

            // Inicializar celdas de totales
            const celdasTotales = document.querySelectorAll('td.number-cell.total-presupuesto, td.number-cell.total-ejecucion, td.number-cell.total-saldo');
            celdasTotales.forEach(celda => {
                if (!celda.textContent.includes('$')) {
                    celda.textContent = '$0';
                }
            });

            // Actualizar todas las filas totales inicialmente
            const secciones = ['preescolar', 'escuela-media', 'escuela-alta', 'pai', 'pep', 'deportes', 'biblioteca', 'psicologia', 'cas', 'consejeria-universitaria', 'departamento-apoyo'];
            secciones.forEach(seccion => {
                const tbody = document.getElementById(seccion + '-tbody');
                if (tbody) {
                    actualizarFilaTotal(tbody, seccion);
                }
            });
        }
    </script>
</x-app-layout>