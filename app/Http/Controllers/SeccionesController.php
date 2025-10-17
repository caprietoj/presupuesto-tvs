<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoSeccion;
use App\Models\CentroCostoSeccion;
use App\Models\Movimiento;
use App\Models\ReclasificacionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SeccionesController extends Controller
{
    public function index()
    {
        // Obtener permisos del usuario
        $userPermissions = session('user_permissions');
        
        // Definir mapeo de secciones a sus IDs HTML
        $seccionesDisponibles = [
            'PREESCOLAR Y PRIMARIA' => 'preescolar',
            'MEDIA' => 'escuela-media',
            'ALTA' => 'escuela-alta',
            'PAI' => 'pai',
            'PEP' => 'pep',
            'DEPORTES ACADEMIA' => 'deportes',
            'BIBLIOTECA' => 'biblioteca',
            'PSICOLOGIA INSTITUCIONAL' => 'psicologia',
            'CAS' => 'cas',
            'CONSEJERIA UNIVERSITARIA' => 'consejeria-universitaria',
            'DEPARTAMENTO DE APOYO' => 'departamento-apoyo',
        ];
        
        // Filtrar secciones según permisos
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            $allowedSections = $userPermissions->getAllowedSections();
            // Filtrar solo las secciones permitidas
            $seccionesDisponibles = array_filter($seccionesDisponibles, function($key) use ($allowedSections) {
                return in_array($key, $allowedSections);
            }, ARRAY_FILTER_USE_KEY);
        }
        
        return view('secciones.index', compact('seccionesDisponibles', 'userPermissions'));
    }

    public function detallado()
    {
        // Obtener todas las secciones únicas de la configuración
        $query = CentroCostoSeccion::select('seccion')
            ->distinct();   
        
        // Filtrar por permisos si el usuario tiene acceso por secciones
        $userPermissions = session('user_permissions');
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            $allowedSections = $userPermissions->getAllowedSections();
            $query->whereIn('seccion', $allowedSections);
        }
        
        $secciones = $query->orderBy('seccion')->pluck('seccion');
        
        // Determinar si el usuario puede reclasificar (solo acceso total)
        $canReclassify = !$userPermissions || $userPermissions->access_type === 'total';

        return view('secciones.detallado', compact('secciones', 'canReclassify'));
    }

    public function getMovimientosDetallado(Request $request)
    {
        $seccion = $request->get('seccion');
        $rubro = $request->get('rubro');
        $centroCosto = $request->get('centro_costo');
        $pagina = $request->get('pagina', 1);
        $registrosPorPagina = 5;

        // IMPORTANTE: Solo mostrar movimientos de centros de costo configurados
        $centrosCostoConfig = CentroCostoSeccion::query();

        // Filtrar por permisos del usuario
        $userPermissions = session('user_permissions');
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            $allowedSections = $userPermissions->getAllowedSections();
            $centrosCostoConfig->whereIn('seccion', $allowedSections);
        }

        if ($seccion) {
            $centrosCostoConfig->where('seccion', 'LIKE', '%' . $seccion . '%');
        }

        if ($rubro) {
            $centrosCostoConfig->where('rubro', 'LIKE', '%' . $rubro . '%');
        }

        if ($centroCosto) {
            $centrosCostoConfig->where('centro_costo', 'LIKE', '%' . $centroCosto . '%');
        }

        // Obtener TODOS los centros de costo configurados (filtrados o no)
        $centrosCostoIds = $centrosCostoConfig->pluck('centro_costo')->toArray();

        // Si no hay centros de costo configurados que coincidan, devolver vacío
        if (empty($centrosCostoIds)) {
            return response()->json([
                'datos' => [],
                'totalRegistros' => 0,
                'pagina' => $pagina,
                'registrosPorPagina' => $registrosPorPagina
            ]);
        }

        // Consultar movimientos SOLO de centros de costo configurados
        // Y excluir los que ya están marcados como 2024-2025 (no revertidos)
        $query = \App\Models\Movimiento::whereIn('centro_costo', $centrosCostoIds)
            ->whereDoesntHave('exclusion', function($q) {
                $q->where('revertido', false);
            });

        // Calcular total de registros para paginación
        $totalRegistros = $query->count();

        // Aplicar paginación
        $movimientos = $query->orderBy('fecha', 'desc')
            ->skip(($pagina - 1) * $registrosPorPagina)
            ->take($registrosPorPagina)
            ->get();

        // Formatear datos para la vista con información de configuración
        $datos = $movimientos->map(function($movimiento) {
            $configuracion = CentroCostoSeccion::where('centro_costo', $movimiento->centro_costo)->first();
            
            return [
                'id' => $movimiento->id, // ID para reclasificación
                'fuente' => $movimiento->fuente ?? '',
                'documento' => $movimiento->documento ?? '',
                'fecha' => $movimiento->fecha ? date('d/m/Y', strtotime($movimiento->fecha)) : '',
                'cuenta' => $movimiento->cuenta ?? '',
                'seccion' => $configuracion->seccion ?? 'Sin configurar',
                'rubro' => $configuracion->rubro ?? 'Sin configurar',
                'descripcion' => $movimiento->descripcion ?? '',
                'valor' => $movimiento->valor ?? 0,
                'valorMoneda' => $movimiento->valor_moneda ?? 0,
                'clienteProveedor' => $movimiento->cliente_proveedor ?? '',
                'nombreClienteProveedor' => $movimiento->nombre_cliente_proveedor ?? '',
                'tercero' => $movimiento->tercero ?? '',
                'nombreTercero' => $movimiento->nombre_tercero ?? '',
                'auxiliar' => $movimiento->auxiliar ?? '',
                'centroCosto' => $movimiento->centro_costo ?? ''
            ];
        });

        return response()->json([
            'datos' => $datos,
            'totalRegistros' => $totalRegistros,
            'pagina' => $pagina,
            'registrosPorPagina' => $registrosPorPagina
        ]);
    }

    public function presupuesto()
    {
        // Filtrar presupuestos según permisos del usuario
        $userPermissions = session('user_permissions');
        
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            // Usuario con acceso por secciones - filtrar
            $allowedSections = $userPermissions->getAllowedSections();
            $presupuestos = PresupuestoSeccion::whereIn('seccion', $allowedSections)->get();
        } else {
            // Usuario con acceso total - ver todo
            $presupuestos = PresupuestoSeccion::all();
        }
        
        // Obtener todas las secciones únicas desde la configuración
        $seccionesQuery = CentroCostoSeccion::select('seccion')
            ->distinct();
        
        // Filtrar secciones del dropdown según permisos
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            $allowedSections = $userPermissions->getAllowedSections();
            $seccionesQuery->whereIn('seccion', $allowedSections);
        }
        
        $secciones = $seccionesQuery->orderBy('seccion')
            ->pluck('seccion', 'seccion')
            ->toArray();
        
        // Agregar secciones adicionales que existen en la vista pero no en centro_costo_seccions
        $seccionesAdicionales = [
            'DEPARTAMENTO DE APOYO' => 'DEPARTAMENTO DE APOYO'
        ];
        
        // Solo agregar secciones adicionales si el usuario tiene permiso
        if (!$userPermissions || $userPermissions->access_type === 'total') {
            $secciones = array_merge($secciones, $seccionesAdicionales);
        } elseif (in_array('DEPARTAMENTO DE APOYO', $userPermissions->getAllowedSections())) {
            $secciones = array_merge($secciones, $seccionesAdicionales);
        }
        
        ksort($secciones); // Ordenar alfabéticamente
        
        return view('secciones.presupuesto', compact('presupuestos', 'secciones'));
    }

    public function storePresupuesto(Request $request)
    {
        try {
            $validated = $request->validate([
                'seccion' => 'required|string|max:255|unique:presupuesto_secciones,seccion',
                'presupuesto_aprobado' => 'required|numeric|min:0',
                'descripcion' => 'nullable|string'
            ]);

            PresupuestoSeccion::create([
                'seccion' => $validated['seccion'],
                'presupuesto_aprobado' => $validated['presupuesto_aprobado'],
                'descripcion' => $validated['descripcion'] ?? null
            ]);

            return redirect()->route('presupuesto-secciones.index')
                            ->with('success', 'Presupuesto de sección creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('presupuesto-secciones.index')
                            ->with('error', 'Error al crear el presupuesto: ' . $e->getMessage());
        }
    }

    public function updatePresupuesto(Request $request, $id)
    {
        $presupuesto = PresupuestoSeccion::findOrFail($id);
        
        $request->validate([
            'seccion' => 'required|string|max:255|unique:presupuesto_secciones,seccion,' . $id,
            'presupuesto_aprobado' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string'
        ]);

        $presupuesto->update($request->all());

        return redirect()->route('presupuesto-secciones.index')
                        ->with('success', 'Presupuesto de sección actualizado exitosamente.');
    }

    public function destroyPresupuesto($id)
    {
        $presupuesto = PresupuestoSeccion::findOrFail($id);
        $presupuesto->delete();

        return redirect()->route('presupuesto-secciones.index')
                        ->with('success', 'Presupuesto de sección eliminado exitosamente.');
    }

    public function getPresupuestos()
    {
        // Filtrar presupuestos según permisos del usuario
        $userPermissions = session('user_permissions');
        
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            $allowedSections = $userPermissions->getAllowedSections();
            $presupuestos = PresupuestoSeccion::whereIn('seccion', $allowedSections)->get();
        } else {
            $presupuestos = PresupuestoSeccion::all();
        }
        
        $data = [];
        
        // Mapeo de nombres de secciones de base de datos a nombres de frontend
        $mapeoSecciones = [
            'PREESCOLAR Y PRIMARIA' => 'preescolar',
            'MEDIA' => 'escuela-media',
            'ALTA' => 'escuela-alta',
            'PAI' => 'pai',
            'PEP' => 'pep',
            'DEPORTES ACADEMIA' => 'deportes',
            'BIBLIOTECA' => 'biblioteca',
            'PSICOLOGIA INSTITUCIONAL' => 'psicologia',
            'CAS' => 'cas',
            'CONSEJERIA UNIVERSITARIA' => 'consejeria-universitaria',
            'DEPARTAMENTO DE APOYO' => 'departamento-apoyo',
            // Agregar más mapeos según sea necesario
        ];
        
        foreach ($presupuestos as $presupuesto) {
            $nombreSeccion = strtoupper(trim($presupuesto->seccion));
            $claveSeccion = $mapeoSecciones[$nombreSeccion] ?? strtolower(str_replace(' ', '-', $nombreSeccion));
            $data[$claveSeccion] = $presupuesto->presupuesto_aprobado;
        }
        
        return response()->json($data);
    }

    public function getEjecucionPreescolarPrimaria()
    {
        // Mapeo de conceptos con sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Capacitación' => ['130101', '130102', '130201', '130202'],
            'Material Importado' => ['130301', '130302'],
            'Musicales' => ['130701', '130702'],
            'Part time teacher - reemplazos' => ['130801', '130802'],
            'Eventos Académicos y Sociales' => ['132001', '132002'],
            'Insumos Tecnológicos' => ['131901', '131902'],
            'Insumos de la Sección / Material para Clase' => ['130501', '130502'],
            'Material Deportivo' => ['130601', '130602'],
        ];

        $resultados = [];

        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener los movimientos para el modal
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'PREESCOLAR Y PRIMARIA', // Fijo ya que sabemos la sección
                    'rubro' => $concepto, // Usar el concepto como rubro
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count()
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionEscuelaMedia()
    {
        // Mapeo de conceptos con sus centros de costo correspondientes para ESCUELA MEDIA
        $conceptosCentrosCosto = [
            'Capacitación' => ['130103', '130203'],
            'Material Importado' => ['130303'],
            'Material Deportivo' => ['130603'],
            'Musicales' => ['130703'],
            'Part time teacher - reemplazos' => ['130803'],
            'Proyecto Comunitario' => ['131203'],
            'MUN TVS - Otros Colegios - GLY' => ['131501'],
            'Eventos Académicos y Sociales' => ['132003'],
            'Insumos Tecnológicos' => ['131904'],
            'Insumos de la Sección / Material para Clase' => ['130503'],
        ];

        $resultados = [];

        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener los movimientos para el modal
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'ESCUELA MEDIA', // Fijo ya que sabemos la sección
                    'rubro' => $concepto, // Usar el concepto como rubro
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count()
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionEscuelaAlta()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Capacitación' => ['130104', '130204'],
            'Material Importado' => ['130304'],
            'Material Deportivo' => ['130604'], 
            'Musicales' => ['130704'],
            'Part time teacher - reemplazos' => ['130804'],
            'Monografía' => ['131204'],
            'MUN TVS - Otros Colegios - GLY' => ['131501'],
            'Preparación Pruebas Saber' => ['132101'],
            'Eventos Académicos y Sociales' => ['132004'],
            'Insumos Tecnológicos' => ['131903'],
            'Insumos de la Sección / Material para Clase' => ['130504']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener los movimientos para el modal
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'ESCUELA ALTA', // Fijo ya que sabemos la sección
                    'rubro' => $concepto, // Usar el concepto como rubro
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count()
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionPep()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Capacitación' => ['130205'],
            'Material Importado' => ['130305'],
            'Exhibición PEP' => ['131001']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'PEP',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionBiblioteca()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Biblioteca Institucional' => ['130401', '130402', '130403', '130404', '130405', '130406']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'BIBLIOTECA',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionPsicologia()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Psicología Institucional' => ['131801', '131802', '131803']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'PSICOLOGÍA INSTITUCIONAL',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionCas()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Actividades CAS' => ['131201', '131202']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'CAS',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionConsejeriaUniversitaria()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Orientación Universitaria' => ['130803']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'CONSEJERÍA UNIVERSITARIA',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function getEjecucionPai()
    {
        // Definir los conceptos y sus centros de costo correspondientes
        $conceptosCentrosCosto = [
            'Proyecto Personal' => ['131101']
        ];

        $resultados = [];
        
        foreach ($conceptosCentrosCosto as $concepto => $centrosCosto) {
            // Obtener la suma de valores para cada concepto
            $suma = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->sum('valor');
            
            // Obtener TODOS los movimientos para el modal (incluso si la suma es 0)
            $movimientos = Movimiento::whereIn('centro_costo', $centrosCosto)
                ->orderBy('fecha', 'desc')
                ->get([
                    'documento', 'fecha', 'cuenta', 'descripcion', 'valor', 'valor_moneda', 
                    'cliente_proveedor', 'nombre_cliente_proveedor', 'tercero', 'nombre_tercero', 
                    'auxiliar', 'centro_costo', 'rubro_presupuesto'
                ]);

            // Mapear cada movimiento con información adicional
            $movimientosConInfo = $movimientos->map(function($movimiento) use ($concepto) {
                return [
                    'documento' => $movimiento->documento,
                    'fecha' => $movimiento->fecha,
                    'cuenta' => $movimiento->cuenta,
                    'seccion' => 'PAI',
                    'rubro' => $concepto,
                    'descripcion' => $movimiento->descripcion,
                    'valor' => $movimiento->valor,
                    'valor_moneda' => $movimiento->valor_moneda,
                    'cliente_proveedor' => $movimiento->cliente_proveedor,
                    'nombre_cliente_proveedor' => $movimiento->nombre_cliente_proveedor,
                    'tercero' => $movimiento->tercero,
                    'nombre_tercero' => $movimiento->nombre_tercero,
                    'auxiliar' => $movimiento->auxiliar,
                    'centro_costo' => $movimiento->centro_costo,
                ];
            });

            $resultados[$concepto] = [
                'valor' => $suma,
                'movimientos' => $movimientosConInfo,
                'totalMovimientos' => $movimientosConInfo->count(),
                'centrosCosto' => $centrosCosto // Agregar para debugging
            ];
        }

        return response()->json($resultados);
    }

    public function aseoCafeteria()
    {
        $datos = $this->procesarSeccionSimplificada('ASEO Y CAFETERÍA');
        return view('secciones.aseo-cafeteria', compact('datos'));
    }

    public function equipoDotacionSalones()
    {
        $datos = $this->procesarSeccionSimplificada('EQUIPO Y DOTACIÓN SALONES');
        return view('secciones.equipo-dotacion-salones', compact('datos'));
    }

    public function deportes()
    {
        $datos = $this->procesarSeccionSimplificada('DEPORTES');
        return view('secciones.deportes', compact('datos'));
    }

    public function honorarios()
    {
        $datos = $this->procesarSeccionSimplificada('HONORARIOS');
        return view('secciones.honorarios', compact('datos'));
    }

    public function dotaciones()
    {
        $datos = $this->procesarSeccionSimplificada('DOTACIONES');
        return view('secciones.dotaciones', compact('datos'));
    }

    public function agasajos()
    {
        $datos = $this->procesarSeccionSimplificada('AGASAJOS');
        return view('secciones.agasajos', compact('datos'));
    }

    public function tecnologia()
    {
        $datos = $this->procesarSeccionSimplificada('TECNOLOGÍA');
        return view('secciones.tecnologia', compact('datos'));
    }

    public function gastosContratacion()
    {
        $datos = $this->procesarSeccionSimplificada('GASTOS DE CONTRATACIÓN');
        return view('secciones.gastos-contratacion', compact('datos'));
    }

    public function afiliacionesSuscripciones()
    {
        $datos = $this->procesarSeccionSimplificada('AFILIACIONES Y SUSCRIPCIONES');
        return view('secciones.afiliaciones-suscripciones', compact('datos'));
    }

    public function ib()
    {
        $datos = $this->procesarSeccionSimplificada('IB');
        return view('secciones.ib', compact('datos'));
    }

    public function entrenamientos()
    {
        $datos = $this->procesarSeccionSimplificada('ENTRENAMIENTOS');
        return view('secciones.entrenamientos', compact('datos'));
    }

    public function serviciosPublicos()
    {
        $datos = $this->procesarSeccionSimplificada('SERVICIOS PÚBLICOS');
        return view('secciones.servicios-publicos', compact('datos'));
    }

    public function reparacionesMayores()
    {
        $datos = $this->procesarSeccionSimplificada('REPARACIONES MAYORES');
        return view('secciones.reparaciones-mayores', compact('datos'));
    }

    public function reparacionMuebles()
    {
        $datos = $this->procesarSeccionSimplificada('REPARACIÓN DE MUEBLES');
        return view('secciones.reparacion-muebles', compact('datos'));
    }

    public function mercadeo()
    {
        $datos = $this->procesarSeccionSimplificada('MERCADEO');
        return view('secciones.mercadeo', compact('datos'));
    }

    /**
     * Obtiene los movimientos detallados de una sección operativa para un mes específico
     */
    public function getMovimientosSeccionOperativa(Request $request)
    {
        $seccion = $request->get('seccion');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Obtener configuración de la sección
        $configuracion = $this->getConfiguracionSecciones();
        
        if (!isset($configuracion[$seccion])) {
            return response()->json(['error' => 'Sección no válida'], 400);
        }

        $centrosCosto = $configuracion[$seccion]['centros_costo'];

        if (empty($centrosCosto)) {
            return response()->json([
                'movimientos' => [],
                'total' => 0,
                'seccion' => $seccion,
                'mes' => $mes,
                'year' => $year
            ]);
        }

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'seccion' => $seccion,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    /**
     * Retorna la configuración de centros de costo para todas las secciones
     */
    private function getConfiguracionSecciones()
    {
        // Mapeo de secciones a centros de costo y presupuestos
        // Datos extraídos de presupuesto.md (2025-2026) y centros decosto.md
        return [
            'ASEO Y CAFETERÍA' => [
                'centros_costo' => ['11011001', '11011002'],
                'presupuesto_aprobado' => 60000000
            ],
            'EQUIPO Y DOTACIÓN SALONES' => [
                'centros_costo' => ['11010101', '11010102'],
                'presupuesto_aprobado' => 18060210
            ],
            'DEPORTES' => [
                'centros_costo' => ['130601', '130602', '130603', '130604', '130605'],
                'presupuesto_aprobado' => 12613480
            ],
            'HONORARIOS' => [
                'centros_costo' => ['010601'],
                'presupuesto_aprobado' => 173054567
            ],
            'DOTACIONES' => [
                'centros_costo' => ['130901', '130902', '130903', '130904'],
                'presupuesto_aprobado' => 27352000
            ],
            'AGASAJOS' => [
                'centros_costo' => ['110112'],
                'presupuesto_aprobado' => 45867200
            ],
            'TECNOLOGÍA' => [
                'centros_costo' => ['131901', '131902', '131903', '131904'],
                'presupuesto_aprobado' => 68800800
            ],
            'GASTOS DE CONTRATACIÓN' => [
                'centros_costo' => ['010507'],
                'presupuesto_aprobado' => 5733400
            ],
            'AFILIACIONES Y SUSCRIPCIONES' => [
                'centros_costo' => ['110113'],
                'presupuesto_aprobado' => 68617032
            ],
            'IB' => [
                'centros_costo' => ['130101', '130102', '130103', '130104', '130301', '130302', '130303', '130304', '130305'],
                'presupuesto_aprobado' => 123082674
            ],
            'ENTRENAMIENTOS' => [
                'centros_costo' => ['130201', '130202', '130203', '130204', '130205'],
                'presupuesto_aprobado' => 41682742
            ],
            'SERVICIOS PÚBLICOS' => [
                'centros_costo' => ['110301', '110302', '110303', '110304', '110305'],
                'presupuesto_aprobado' => 496599910
            ],
            'REPARACIONES MAYORES' => [
                'centros_costo' => ['11010201'],
                'presupuesto_aprobado' => 182322120
            ],
            'REPARACIÓN DE MUEBLES' => [
                'centros_costo' => ['11010203', '11010205'],
                'presupuesto_aprobado' => 17200200
            ],
            'MERCADEO' => [
                'centros_costo' => ['110114'],
                'presupuesto_aprobado' => 78688901
            ],
        ];
    }

    /**
     * Función simplificada para secciones operativas con datos dinámicos
     * Devuelve una sola fila con el nombre de la sección como concepto y datos reales de la BD
     */
    private function procesarSeccionSimplificada($nombreSeccion)
    {
        $datos = [];
        $configuracion = $this->getConfiguracionSecciones();
        $config = $configuracion[$nombreSeccion] ?? ['centros_costo' => [], 'presupuesto_aprobado' => 0];
        
        $centrosCosto = $config['centros_costo'];
        $presupuestoAprobado = $config['presupuesto_aprobado'];
        
        // Definir meses y años
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        
        $mesesConfig = [
            'julio' => ['mes' => 7, 'year' => $currentYear],
            'agosto' => ['mes' => 8, 'year' => $currentYear],
            'septiembre' => ['mes' => 9, 'year' => $currentYear],
            'octubre' => ['mes' => 10, 'year' => $currentYear],
            'noviembre' => ['mes' => 11, 'year' => $currentYear],
            'diciembre' => ['mes' => 12, 'year' => $currentYear],
            'enero' => ['mes' => 1, 'year' => $nextYear],
            'febrero' => ['mes' => 2, 'year' => $nextYear],
            'marzo' => ['mes' => 3, 'year' => $nextYear],
            'abril' => ['mes' => 4, 'year' => $nextYear],
            'mayo' => ['mes' => 5, 'year' => $nextYear],
            'junio' => ['mes' => 6, 'year' => $nextYear],
        ];
        
        // Calcular ejecutado por mes
        $totalEjecutado = 0;
        $mesesData = [];
        
        foreach ($mesesConfig as $nombreMes => $mesConfig) {
            $valorMes = 0;
            
            if (!empty($centrosCosto)) {
                $valorMes = DB::table('movimientos')
                    ->whereYear('fecha', $mesConfig['year'])
                    ->whereMonth('fecha', $mesConfig['mes'])
                    ->whereIn('centro_costo', $centrosCosto)
                    ->selectRaw('SUM(ABS(valor)) as total')
                    ->value('total') ?? 0;
            }
            
            $mesesData[$nombreMes] = $valorMes;
            $totalEjecutado += $valorMes;
        }
        
        // Calcular presupuesto por ejecutar y porcentaje restante
        $presupuestoPorEjecutar = $presupuestoAprobado - $totalEjecutado;
        $porcentajeRestante = $presupuestoAprobado > 0 
            ? ($presupuestoPorEjecutar / $presupuestoAprobado) * 100 
            : 0;
        
        // Construir la fila de datos
        $datos[$nombreSeccion] = array_merge([
            'presupuesto_aprobado' => $presupuestoAprobado,
            'ejecutado' => $totalEjecutado,
            'presupuesto_por_ejecutar' => $presupuestoPorEjecutar,
            'porcentaje_restante' => $porcentajeRestante,
        ], $mesesData);
        
        return $datos;
    }

    private function procesarDatosSeccion($conceptos, $filtros)
    {
        $datos = [];
        $anoActual = date('Y');

        foreach ($conceptos as $concepto => $config) {
            $movimientosQuery = Movimiento::whereYear('fecha', $anoActual);
            
            if (isset($filtros[$concepto])) {
                $movimientosQuery->where(function($query) use ($filtros, $concepto) {
                    foreach ($filtros[$concepto] as $filtro) {
                        $query->orWhere('descripcion', 'LIKE', '%' . $filtro . '%')
                              ->orWhere('descripcion', 'LIKE', '%' . strtoupper($filtro) . '%');
                    }
                });
            }

            $movimientos = $movimientosQuery->get();
            
            $totalEjecutado = 0;
            $meses = [
                7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre',
                11 => 'noviembre', 12 => 'diciembre', 1 => 'enero', 2 => 'febrero',
                3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio'
            ];

            $datosMeses = [];
            foreach ($meses as $numMes => $nombreMes) {
                $valorMes = $movimientos->filter(function($mov) use ($numMes) {
                    return (int)date('n', strtotime($mov->fecha)) === $numMes;
                })->sum('valor');
                
                $datosMeses[$nombreMes] = abs($valorMes);
                $totalEjecutado += abs($valorMes);
            }

            $todosMeses = ['julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio'];
            foreach ($todosMeses as $mes) {
                if (!isset($datosMeses[$mes])) {
                    $datosMeses[$mes] = 0;
                }
            }

            $presupuestoAprobado = $config['presupuesto_aprobado'];
            $presupuestoPorEjecutar = max(0, $presupuestoAprobado - $totalEjecutado);
            $porcentajeRestante = $presupuestoAprobado > 0 ? ($presupuestoPorEjecutar / $presupuestoAprobado) * 100 : 0;

            $datos[$concepto] = array_merge([
                'presupuesto_aprobado' => $presupuestoAprobado,
                'ejecutado' => $totalEjecutado,
                'presupuesto_por_ejecutar' => $presupuestoPorEjecutar,
                'porcentaje_restante' => round($porcentajeRestante, 2),
            ], $datosMeses);
        }

        return $datos;
    }

    /**
     * Reclasificar un movimiento cambiando su centro de costo
     * Esto efectivamente mueve el gasto de una sección/rubro a otra
     */
    public function reclasificarMovimiento(Request $request)
    {
        // Verificar permisos - solo usuarios con acceso total pueden reclasificar
        $userPermissions = session('user_permissions');
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para reclasificar movimientos. Esta acción está reservada para usuarios con acceso total.'
            ], 403);
        }
        
        try {
            $validated = $request->validate([
                'movimiento_id' => 'required|integer',
                'nuevo_centro_costo' => 'required|string|max:10'
            ]);

            // Buscar el movimiento
            $movimiento = Movimiento::find($validated['movimiento_id']);
            
            if (!$movimiento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movimiento no encontrado'
                ], 404);
            }

            // Verificar que el nuevo centro de costo existe en la configuración
            $nuevaConfig = CentroCostoSeccion::where('centro_costo', $validated['nuevo_centro_costo'])->first();
            
            if (!$nuevaConfig) {
                return response()->json([
                    'success' => false,
                    'message' => 'El centro de costo destino no está configurado en el sistema'
                ], 400);
            }

            // Obtener configuración anterior para el log
            $configAnterior = CentroCostoSeccion::where('centro_costo', $movimiento->centro_costo)->first();

            $centroCostoAnterior = $movimiento->centro_costo;
            $seccionAnterior = $configAnterior ? $configAnterior->seccion : 'Sin configurar';
            $rubroAnterior = $configAnterior ? $configAnterior->rubro : 'Sin configurar';

            // Actualizar el centro de costo del movimiento
            $movimiento->centro_costo = $validated['nuevo_centro_costo'];
            $movimiento->save();

            // Registrar el log de reclasificación
            ReclasificacionLog::create([
                'movimiento_id' => $movimiento->id,
                'usuario' => Auth::user()->name ?? 'Sistema',
                'centro_costo_anterior' => $centroCostoAnterior,
                'centro_costo_nuevo' => $validated['nuevo_centro_costo'],
                'seccion_anterior' => $seccionAnterior,
                'seccion_nueva' => $nuevaConfig->seccion,
                'rubro_anterior' => $rubroAnterior,
                'rubro_nuevo' => $nuevaConfig->rubro,
                'valor' => $movimiento->valor,
                'descripcion_movimiento' => $movimiento->descripcion ?? null,
                'revertido' => false // Explícitamente false al crear
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Movimiento reclasificado exitosamente',
                'data' => [
                    'movimiento_id' => $movimiento->id,
                    'centro_costo_anterior' => $centroCostoAnterior,
                    'seccion_anterior' => $seccionAnterior,
                    'rubro_anterior' => $rubroAnterior,
                    'centro_costo_nuevo' => $validated['nuevo_centro_costo'],
                    'seccion_nueva' => $nuevaConfig->seccion,
                    'rubro_nuevo' => $nuevaConfig->rubro,
                    'valor' => $movimiento->valor
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reclasificar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de centros de costo disponibles para reclasificación
     */
    public function getCentrosCostoDisponibles()
    {
        $centrosCosto = CentroCostoSeccion::select('centro_costo', 'rubro', 'seccion')
            ->orderBy('seccion')
            ->orderBy('rubro')
            ->get();

        return response()->json([
            'success' => true,
            'centros_costo' => $centrosCosto
        ]);
    }

    /**
     * Vista de control de cambios (auditoría de reclasificaciones)
     */
    public function controlCambios(Request $request)
    {
        $query = ReclasificacionLog::query()->orderBy('created_at', 'desc');

        // Filtros opcionales
        if ($request->has('usuario') && $request->usuario) {
            $query->where('usuario', 'LIKE', '%' . $request->usuario . '%');
        }

        if ($request->has('seccion') && $request->seccion) {
            $query->where(function($q) use ($request) {
                $q->where('seccion_anterior', 'LIKE', '%' . $request->seccion . '%')
                  ->orWhere('seccion_nueva', 'LIKE', '%' . $request->seccion . '%');
            });
        }

        if ($request->has('revertido')) {
            $query->where('revertido', $request->revertido === 'true' || $request->revertido === '1');
        }

        if ($request->has('fecha_desde') && $request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Paginación
        $logs = $query->paginate(15);

        // Obtener usuarios únicos para el filtro
        $usuarios = ReclasificacionLog::select('usuario')
            ->distinct()
            ->orderBy('usuario')
            ->pluck('usuario');

        // Obtener secciones únicas
        $secciones = CentroCostoSeccion::select('seccion')
            ->distinct()
            ->orderBy('seccion')
            ->pluck('seccion');

        return view('control-cambios.index', compact('logs', 'usuarios', 'secciones'));
    }

    /**
     * Revertir una reclasificación
     */
    public function revertirReclasificacion($id)
    {
        try {
            $log = ReclasificacionLog::findOrFail($id);

            // Verificar que no esté ya revertida
            if ($log->revertido) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta reclasificación ya fue revertida anteriormente'
                ], 400);
            }

            // Buscar el movimiento
            $movimiento = Movimiento::find($log->movimiento_id);

            if (!$movimiento) {
                return response()->json([
                    'success' => false,
                    'message' => 'El movimiento ya no existe en el sistema'
                ], 404);
            }

            // Verificar que el movimiento esté en el centro de costo nuevo (no reclasificado de nuevo)
            if ($movimiento->centro_costo !== $log->centro_costo_nuevo) {
                return response()->json([
                    'success' => false,
                    'message' => 'El movimiento ha sido reclasificado nuevamente. No se puede revertir.'
                ], 400);
            }

            // Revertir: volver al centro de costo anterior
            $movimiento->centro_costo = $log->centro_costo_anterior;
            $movimiento->save();

            // Marcar el log como revertido
            $log->revertido = true;
            $log->fecha_reversion = now();
            $log->usuario_reversion = Auth::user()->name ?? 'Sistema';
            $log->save();

            return response()->json([
                'success' => true,
                'message' => 'Reclasificación revertida exitosamente',
                'data' => [
                    'movimiento_id' => $movimiento->id,
                    'centro_costo_restaurado' => $log->centro_costo_anterior,
                    'seccion_restaurada' => $log->seccion_anterior,
                    'rubro_restaurado' => $log->rubro_anterior
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al revertir: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalles de un log de reclasificación
     */
    public function getDetalleLog($id)
    {
        try {
            $log = ReclasificacionLog::with('movimiento')->findOrFail($id);

            return response()->json([
                'success' => true,
                'log' => $log
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalles: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Excluir un gasto del presupuesto actual (marcarlo como 2024-2025)
     */
    public function excluirGasto2024(Request $request)
    {
        // Verificar permisos - solo usuarios con acceso total pueden excluir
        $userPermissions = session('user_permissions');
        if ($userPermissions && $userPermissions->access_type === 'secciones') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para excluir movimientos. Esta acción está reservada para usuarios con acceso total.'
            ], 403);
        }
        
        try {
            $validated = $request->validate([
                'movimiento_id' => 'required|integer',
                'motivo' => 'nullable|string|max:500'
            ]);

            // Buscar el movimiento
            $movimiento = Movimiento::find($validated['movimiento_id']);
            
            if (!$movimiento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movimiento no encontrado'
                ], 404);
            }

            // Verificar que el movimiento no esté ya excluido
            $existeExclusion = \App\Models\ExclusionPresupuesto::where('movimiento_id', $movimiento->id)
                ->where('revertido', false)
                ->first();

            if ($existeExclusion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este movimiento ya está marcado como gasto 2024-2025'
                ], 400);
            }

            // Obtener configuración del centro de costo
            $configuracion = CentroCostoSeccion::where('centro_costo', $movimiento->centro_costo)->first();

            // Crear registro de exclusión
            $exclusion = \App\Models\ExclusionPresupuesto::create([
                'movimiento_id' => $movimiento->id,
                'usuario' => Auth::user()->name,
                'seccion' => $configuracion ? $configuracion->seccion : 'Sin configurar',
                'rubro' => $configuracion ? $configuracion->rubro : 'Sin configurar',
                'centro_costo' => $movimiento->centro_costo,
                'descripcion' => $movimiento->descripcion ?? 'Sin descripción',
                'valor' => $movimiento->valor,
                'fecha_movimiento' => $movimiento->fecha,
                'documento' => $movimiento->documento,
                'motivo' => $validated['motivo'],
                'revertido' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gasto marcado exitosamente como 2024-2025. Ya no afectará el presupuesto actual.',
                'exclusion' => $exclusion
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al excluir gasto 2024: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la exclusión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ver lista de gastos excluidos 2024-2025
     */
    public function gastos20242025(Request $request)
    {
        // Obtener filtros
        $usuario = $request->get('usuario');
        $seccion = $request->get('seccion');
        $revertido = $request->get('revertido');
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');

        // Query base
        $query = \App\Models\ExclusionPresupuesto::query();

        // Aplicar filtros
        if ($usuario) {
            $query->where('usuario', 'LIKE', '%' . $usuario . '%');
        }

        if ($seccion) {
            $query->where('seccion', 'LIKE', '%' . $seccion . '%');
        }

        if ($revertido !== null) {
            $query->where('revertido', $revertido);
        }

        if ($fechaDesde) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        // Ordenar por más recientes
        $exclusiones = $query->orderBy('created_at', 'desc')->paginate(20);

        // Obtener listas únicas para filtros
        $usuarios = \App\Models\ExclusionPresupuesto::select('usuario')
            ->distinct()
            ->pluck('usuario');

        $secciones = \App\Models\ExclusionPresupuesto::select('seccion')
            ->distinct()
            ->pluck('seccion');

        return view('gastos-2024-2025.index', compact('exclusiones', 'usuarios', 'secciones'));
    }

    /**
     * Revertir una exclusión de gasto 2024-2025
     */
    public function revertirExclusion($id)
    {
        try {
            $exclusion = \App\Models\ExclusionPresupuesto::findOrFail($id);

            // Verificar que no esté ya revertida
            if ($exclusion->revertido) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta exclusión ya fue revertida anteriormente.'
                ]);
            }

            // Marcar como revertida
            $exclusion->revertir(Auth::user()->name);

            return response()->json([
                'success' => true,
                'message' => 'Exclusión revertida exitosamente. El gasto volverá a afectar el presupuesto actual.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al revertir exclusión: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al revertir la exclusión: ' . $e->getMessage()
            ], 500);
        }
    }
}
