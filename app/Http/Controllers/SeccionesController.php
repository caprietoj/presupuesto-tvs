<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoSeccion;
use App\Models\CentroCostoSeccion;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function index()
    {
        return view('secciones.index');
    }

    public function detallado()
    {
        // Obtener todas las secciones únicas de la configuración
        $secciones = CentroCostoSeccion::select('seccion')
            ->distinct()
            ->orderBy('seccion')
            ->pluck('seccion');

        return view('secciones.detallado', compact('secciones'));
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
        $query = \App\Models\Movimiento::whereIn('centro_costo', $centrosCostoIds);

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
        $presupuestos = PresupuestoSeccion::all();
        return view('secciones.presupuesto', compact('presupuestos'));
    }

    public function storePresupuesto(Request $request)
    {
        $request->validate([
            'seccion' => 'required|string|max:255|unique:presupuesto_seccions,seccion',
            'presupuesto_aprobado' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string'
        ]);

        PresupuestoSeccion::create($request->all());

        return redirect()->route('presupuesto-secciones.index')
                        ->with('success', 'Presupuesto de sección creado exitosamente.');
    }

    public function updatePresupuesto(Request $request, $id)
    {
        $presupuesto = PresupuestoSeccion::findOrFail($id);
        
        $request->validate([
            'seccion' => 'required|string|max:255|unique:presupuesto_seccions,seccion,' . $id,
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
        $presupuestos = PresupuestoSeccion::all();
        $data = [];
        
        foreach ($presupuestos as $presupuesto) {
            $data[$presupuesto->seccion] = $presupuesto->presupuesto_aprobado;
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
            'Orientación Universitaria' => ['131601']
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
        // Conceptos de Aseo y Cafetería con sus centros de costo
        $conceptos = [
            'Utilidad Cafetería' => [
                'centros_costo' => [], // Será calculado desde movimientos
                'presupuesto_aprobado' => 0,
            ],
            'Utilidad Transporte' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Elementos de Aseo' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Mantenimiento Instalaciones' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ]
        ];

        $datos = [];
        $anoActual = date('Y');

        foreach ($conceptos as $concepto => $config) {
            // Buscar movimientos relacionados por descripción
            $movimientosQuery = Movimiento::whereYear('fecha', $anoActual);
            
            switch ($concepto) {
                case 'Utilidad Cafetería':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%cafeteria%')
                              ->orWhere('descripcion', 'LIKE', '%CAFETERIA%')
                              ->orWhere('descripcion', 'LIKE', '%restaurante%')
                              ->orWhere('descripcion', 'LIKE', '%RESTAURANTE%');
                    });
                    break;
                case 'Utilidad Transporte':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%transporte%')
                              ->orWhere('descripcion', 'LIKE', '%TRANSPORTE%')
                              ->orWhere('descripcion', 'LIKE', '%bus%')
                              ->orWhere('descripcion', 'LIKE', '%BUS%');
                    });
                    break;
                case 'Elementos de Aseo':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%aseo%')
                              ->orWhere('descripcion', 'LIKE', '%ASEO%')
                              ->orWhere('descripcion', 'LIKE', '%limpieza%')
                              ->orWhere('descripcion', 'LIKE', '%LIMPIEZA%');
                    });
                    break;
                case 'Mantenimiento Instalaciones':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%mantenimiento%')
                              ->orWhere('descripcion', 'LIKE', '%MANTENIMIENTO%')
                              ->orWhere('descripcion', 'LIKE', '%reparacion%')
                              ->orWhere('descripcion', 'LIKE', '%REPARACION%');
                    });
                    break;
            }

            $movimientos = $movimientosQuery->get();
            
            // Calcular totales por mes
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

            // Inicializar meses faltantes con cero si no están en la consulta
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

        return view('secciones.aseo-cafeteria', compact('datos'));
    }

    public function equipoDotacionSalones()
    {
        // Conceptos de Equipo y Dotación Salones
        $conceptos = [
            'Mobiliario Aulas' => [
                'centros_costo' => [], 
                'presupuesto_aprobado' => 0,
            ],
            'Equipos Didácticos' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Material de Oficina' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Decoración Aulas' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ]
        ];

        $datos = [];
        $anoActual = date('Y');

        foreach ($conceptos as $concepto => $config) {
            $movimientosQuery = Movimiento::whereYear('fecha', $anoActual);
            
            switch ($concepto) {
                case 'Mobiliario Aulas':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%mobiliario%')
                              ->orWhere('descripcion', 'LIKE', '%MOBILIARIO%')
                              ->orWhere('descripcion', 'LIKE', '%escritorio%')
                              ->orWhere('descripcion', 'LIKE', '%ESCRITORIO%')
                              ->orWhere('descripcion', 'LIKE', '%silla%')
                              ->orWhere('descripcion', 'LIKE', '%SILLA%');
                    });
                    break;
                case 'Equipos Didácticos':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%didactico%')
                              ->orWhere('descripcion', 'LIKE', '%DIDACTICO%')
                              ->orWhere('descripcion', 'LIKE', '%educativo%')
                              ->orWhere('descripcion', 'LIKE', '%EDUCATIVO%');
                    });
                    break;
                case 'Material de Oficina':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%oficina%')
                              ->orWhere('descripcion', 'LIKE', '%OFICINA%')
                              ->orWhere('descripcion', 'LIKE', '%papeleria%')
                              ->orWhere('descripcion', 'LIKE', '%PAPELERIA%');
                    });
                    break;
                case 'Decoración Aulas':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%decoracion%')
                              ->orWhere('descripcion', 'LIKE', '%DECORACION%')
                              ->orWhere('descripcion', 'LIKE', '%ornato%')
                              ->orWhere('descripcion', 'LIKE', '%ORNATO%');
                    });
                    break;
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

        return view('secciones.equipo-dotacion-salones', compact('datos'));
    }

    public function deportes()
    {
        // Conceptos de Deportes
        $conceptos = [
            'Implementos Deportivos' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Uniformes Deportivos' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Mantenimiento Instalaciones Deportivas' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Competencias Deportivas' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ]
        ];

        $datos = [];
        $anoActual = date('Y');

        foreach ($conceptos as $concepto => $config) {
            $movimientosQuery = Movimiento::whereYear('fecha', $anoActual);
            
            switch ($concepto) {
                case 'Implementos Deportivos':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%implemento%')
                              ->orWhere('descripcion', 'LIKE', '%IMPLEMENTO%')
                              ->orWhere('descripcion', 'LIKE', '%deporte%')
                              ->orWhere('descripcion', 'LIKE', '%DEPORTE%')
                              ->orWhere('descripcion', 'LIKE', '%balon%')
                              ->orWhere('descripcion', 'LIKE', '%BALON%');
                    });
                    break;
                case 'Uniformes Deportivos':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%uniforme%')
                              ->orWhere('descripcion', 'LIKE', '%UNIFORME%')
                              ->orWhere('descripcion', 'LIKE', '%camiseta%')
                              ->orWhere('descripcion', 'LIKE', '%CAMISETA%');
                    });
                    break;
                case 'Mantenimiento Instalaciones Deportivas':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%cancha%')
                              ->orWhere('descripcion', 'LIKE', '%CANCHA%')
                              ->orWhere('descripcion', 'LIKE', '%gimnasio%')
                              ->orWhere('descripcion', 'LIKE', '%GIMNASIO%');
                    });
                    break;
                case 'Competencias Deportivas':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%competencia%')
                              ->orWhere('descripcion', 'LIKE', '%COMPETENCIA%')
                              ->orWhere('descripcion', 'LIKE', '%torneo%')
                              ->orWhere('descripcion', 'LIKE', '%TORNEO%');
                    });
                    break;
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

        return view('secciones.deportes', compact('datos'));
    }

    public function honorarios()
    {
        // Conceptos de Honorarios
        $conceptos = [
            'Honorarios Profesionales' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Servicios de Consultoría' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Asesorías Especializadas' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ],
            'Servicios Técnicos' => [
                'centros_costo' => [],
                'presupuesto_aprobado' => 0,
            ]
        ];

        $datos = [];
        $anoActual = date('Y');

        foreach ($conceptos as $concepto => $config) {
            $movimientosQuery = Movimiento::whereYear('fecha', $anoActual);
            
            switch ($concepto) {
                case 'Honorarios Profesionales':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%honorario%')
                              ->orWhere('descripcion', 'LIKE', '%HONORARIO%')
                              ->orWhere('descripcion', 'LIKE', '%profesional%')
                              ->orWhere('descripcion', 'LIKE', '%PROFESIONAL%');
                    });
                    break;
                case 'Servicios de Consultoría':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%consultoria%')
                              ->orWhere('descripcion', 'LIKE', '%CONSULTORIA%')
                              ->orWhere('descripcion', 'LIKE', '%consultor%')
                              ->orWhere('descripcion', 'LIKE', '%CONSULTOR%');
                    });
                    break;
                case 'Asesorías Especializadas':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%asesoria%')
                              ->orWhere('descripcion', 'LIKE', '%ASESORIA%')
                              ->orWhere('descripcion', 'LIKE', '%asesor%')
                              ->orWhere('descripcion', 'LIKE', '%ASESOR%');
                    });
                    break;
                case 'Servicios Técnicos':
                    $movimientosQuery->where(function($query) {
                        $query->where('descripcion', 'LIKE', '%tecnico%')
                              ->orWhere('descripcion', 'LIKE', '%TECNICO%')
                              ->orWhere('descripcion', 'LIKE', '%especializado%')
                              ->orWhere('descripcion', 'LIKE', '%ESPECIALIZADO%');
                    });
                    break;
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

        return view('secciones.honorarios', compact('datos'));
    }

    public function dotaciones()
    {
        $conceptos = [
            'Uniformes Escolares' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Uniformes Administrativos' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Materiales Educativos' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Suministros de Oficina' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Uniformes Escolares' => ['uniforme', 'escolar'],
            'Uniformes Administrativos' => ['uniforme', 'administrativo', 'personal'],
            'Materiales Educativos' => ['material', 'educativo', 'didactico'],
            'Suministros de Oficina' => ['suministro', 'oficina', 'papeleria']
        ]);
        return view('secciones.dotaciones', compact('datos'));
    }

    public function agasajos()
    {
        $conceptos = [
            'Eventos Institucionales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Celebraciones' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Refrigerios' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Actividades Especiales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Eventos Institucionales' => ['evento', 'institucional', 'ceremonia'],
            'Celebraciones' => ['celebracion', 'fiesta', 'festejo'],
            'Refrigerios' => ['refrigerio', 'merienda', 'alimentacion'],
            'Actividades Especiales' => ['actividad', 'especial', 'programa']
        ]);
        return view('secciones.agasajos', compact('datos'));
    }

    public function tecnologia()
    {
        $conceptos = [
            'Hardware' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Software' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Infraestructura TI' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Mantenimiento Sistemas' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Hardware' => ['computador', 'laptop', 'hardware', 'equipo'],
            'Software' => ['software', 'licencia', 'programa'],
            'Infraestructura TI' => ['red', 'servidor', 'infraestructura'],
            'Mantenimiento Sistemas' => ['mantenimiento', 'sistema', 'soporte']
        ]);
        return view('secciones.tecnologia', compact('datos'));
    }

    public function gastosContratacion()
    {
        $conceptos = [
            'Procesos de Selección' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Publicaciones' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Evaluaciones' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Documentación' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Procesos de Selección' => ['seleccion', 'contratacion', 'reclutamiento'],
            'Publicaciones' => ['publicacion', 'aviso', 'anuncio'],
            'Evaluaciones' => ['evaluacion', 'examen', 'prueba'],
            'Documentación' => ['documentacion', 'tramite', 'papeleria']
        ]);
        return view('secciones.gastos-contratacion', compact('datos'));
    }

    public function afiliacionesSuscripciones()
    {
        $conceptos = [
            'Membresías Profesionales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Suscripciones Digitales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Afiliaciones Gremiales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Servicios en Línea' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Membresías Profesionales' => ['membresia', 'profesional', 'colegio'],
            'Suscripciones Digitales' => ['suscripcion', 'digital', 'online'],
            'Afiliaciones Gremiales' => ['afiliacion', 'gremial', 'asociacion'],
            'Servicios en Línea' => ['servicio', 'linea', 'web']
        ]);
        return view('secciones.afiliaciones-suscripciones', compact('datos'));
    }

    public function ib()
    {
        $conceptos = [
            'Materiales IB' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Capacitaciones IB' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Evaluaciones IB' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Certificaciones IB' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Materiales IB' => ['material', 'ib', 'bachillerato'],
            'Capacitaciones IB' => ['capacitacion', 'entrenamiento', 'formacion'],
            'Evaluaciones IB' => ['evaluacion', 'examen', 'assessment'],
            'Certificaciones IB' => ['certificacion', 'diploma', 'titulo']
        ]);
        return view('secciones.ib', compact('datos'));
    }

    public function entrenamientos()
    {
        $conceptos = [
            'Capacitación Docente' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Formación Administrativa' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Seminarios' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Talleres Especializados' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Capacitación Docente' => ['capacitacion', 'docente', 'profesor'],
            'Formación Administrativa' => ['formacion', 'administrativo', 'personal'],
            'Seminarios' => ['seminario', 'conferencia', 'congreso'],
            'Talleres Especializados' => ['taller', 'especializado', 'curso']
        ]);
        return view('secciones.entrenamientos', compact('datos'));
    }

    public function serviciosPublicos()
    {
        $conceptos = [
            'Energía Eléctrica' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Agua y Alcantarillado' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Gas Natural' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Telecomunicaciones' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Energía Eléctrica' => ['energia', 'electrica', 'luz'],
            'Agua y Alcantarillado' => ['agua', 'alcantarillado', 'acueducto'],
            'Gas Natural' => ['gas', 'natural', 'combustible'],
            'Telecomunicaciones' => ['telefono', 'internet', 'comunicacion']
        ]);
        return view('secciones.servicios-publicos', compact('datos'));
    }

    public function reparacionesMayores()
    {
        $conceptos = [
            'Infraestructura' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Sistemas Eléctricos' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Sistemas Hidráulicos' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Estructura Civil' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Infraestructura' => ['infraestructura', 'edificio', 'construccion'],
            'Sistemas Eléctricos' => ['electrico', 'instalacion', 'cableado'],
            'Sistemas Hidráulicos' => ['hidraulico', 'tuberia', 'fontaneria'],
            'Estructura Civil' => ['estructura', 'civil', 'obra']
        ]);
        return view('secciones.reparaciones-mayores', compact('datos'));
    }

    public function reparacionMuebles()
    {
        $conceptos = [
            'Mobiliario Aulas' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Mobiliario Oficina' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Equipos y Enseres' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Tapicería' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Mobiliario Aulas' => ['mobiliario', 'aula', 'pupitres'],
            'Mobiliario Oficina' => ['mueble', 'oficina', 'escritorio'],
            'Equipos y Enseres' => ['equipo', 'enser', 'artefacto'],
            'Tapicería' => ['tapiceria', 'tapizar', 'tela']
        ]);
        return view('secciones.reparacion-muebles', compact('datos'));
    }

    public function mercadeo()
    {
        $conceptos = [
            'Publicidad' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Marketing Digital' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Eventos Promocionales' => ['centros_costo' => [], 'presupuesto_aprobado' => 0],
            'Material Publicitario' => ['centros_costo' => [], 'presupuesto_aprobado' => 0]
        ];
        $datos = $this->procesarDatosSeccion($conceptos, [
            'Publicidad' => ['publicidad', 'promocion', 'anuncio'],
            'Marketing Digital' => ['marketing', 'digital', 'redes'],
            'Eventos Promocionales' => ['evento', 'promocional', 'campana'],
            'Material Publicitario' => ['material', 'publicitario', 'volante']
        ]);
        return view('secciones.mercadeo', compact('datos'));
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
}
