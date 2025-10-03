<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoSeccion;
use App\Models\CentroCostoSeccion;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
