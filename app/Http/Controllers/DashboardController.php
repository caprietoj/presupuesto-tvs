<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Función helper optimizada para calcular suma de valores absolutos
     * usando SQL en lugar de traer todos los registros a PHP
     */
    private function calcularSumaAbsoluta($year, $mes, $centrosCosto = null, $cuentas = null, $cuentaLike = null)
    {
        $query = DB::table('movimientos')
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $mes);
            
        if ($centrosCosto) {
            if (is_array($centrosCosto)) {
                $query->whereIn('centro_costo', $centrosCosto);
            } else {
                $query->where('centro_costo', $centrosCosto);
            }
        }
        
        if ($cuentas) {
            if (is_array($cuentas)) {
                $query->whereIn('cuenta', $cuentas);
            } else {
                $query->where('cuenta', $cuentas);
            }
        }
        
        if ($cuentaLike) {
            $query->where('cuenta', 'LIKE', $cuentaLike);
        }
        
        // Usar SQL para calcular la suma de valores absolutos directamente
        return $query->selectRaw('SUM(ABS(valor)) as total')->value('total') ?? 0;
    }

    public function index()
    {
        // Presupuestos aprobados (hardcodeados según el HTML proporcionado)
        $presupuestoIngresos = 11326778481;
        $presupuestoEgresos = 14133212606;
        $presupuestoUtilidad = $presupuestoIngresos - $presupuestoEgresos;

        // Calcular totales generales actuales
        $totalIngresos = Movimiento::where('valor', '>', 0)->sum('valor');
        $totalEgresos = abs(Movimiento::where('valor', '<', 0)->sum('valor'));
        $utilidad = $totalIngresos - $totalEgresos;

        // Calcular por meses (asumiendo año actual o próximo)
        $meses = [
            'junio' => 6,
            'julio' => 7,
            'agosto' => 8,
            'septiembre' => 9,
            'octubre' => 10,
            'noviembre' => 11,
            'diciembre' => 12,
            'enero' => 1,
            'febrero' => 2,
        ];

        $ingresosPorMes = [];
        $egresosPorMes = [];
        $utilidadPorMes = [];

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;

        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            $ingresos = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('valor', '>', 0)
                ->sum('valor');
            $egresos = abs(Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('valor', '<', 0)
                ->sum('valor'));
            $utilidadMes = $ingresos - $egresos;

            $ingresosPorMes[$mesNombre] = $ingresos;
            $egresosPorMes[$mesNombre] = $egresos;
            $utilidadPorMes[$mesNombre] = $utilidadMes;
        }

        // Calcular datos específicos para la tabla RESUMEN
        $resumenDatosPorMes = [];
        
        // Inicializar estructura de datos
        $resumenDatosPorMes['utilidad_cafeteria'] = ['presupuesto' => 0];
        $resumenDatosPorMes['utilidad_transporte'] = ['presupuesto' => 0];
        $resumenDatosPorMes['actividades_curriculares'] = ['presupuesto' => 0];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Utilidad Cafetería = Ingresos Cafetería - Contratos Cafetería
            $ingresosCafeteria = $this->calcularSumaAbsoluta($year, $mesNumero, ['07020101', '07020102', '07020103', '07020104', '07020105', '07020106']);
            $contratosCafeteria = $this->calcularSumaAbsoluta($year, $mesNumero, ['12010201']);
            $utilidadCafeteria = $ingresosCafeteria - $contratosCafeteria;
            
            // Utilidad Transporte = Ingresos Transporte - Contratos Transporte
            $ingresosTransporte = $this->calcularSumaAbsoluta($year, $mesNumero, ['07020201', '07020202', '07020203', '07020204', '07020205']);
            $contratosTransporte = $this->calcularSumaAbsoluta($year, $mesNumero, ['120103']);
            $utilidadTransporte = $ingresosTransporte - $contratosTransporte;
            
            // Actividades Curriculares = suma de centros 070104, 070105, 070106, 070107, 070108
            $actividadesCurriculares = $this->calcularSumaAbsoluta($year, $mesNumero, ['070104', '070105', '070106', '070107', '070108']);
            
            $resumenDatosPorMes['utilidad_cafeteria'][$mesNombre] = $utilidadCafeteria;
            $resumenDatosPorMes['utilidad_transporte'][$mesNombre] = $utilidadTransporte;
            $resumenDatosPorMes['actividades_curriculares'][$mesNombre] = $actividadesCurriculares;
        }

        // Calcular datos específicos para INGRESOS ESCOLARES por mes
        $ingresosEscolaresPorMes = [];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Matrículas: suma de centros de costo específicos
            $matriculas = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['070101', '07010101', '07010102', '07010103', '07010104', '07010105'])
                ->sum('valor');
            
            // Pensiones: suma de centros de costo específicos
            $pensiones = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['07010201', '07010202', '07010203', '07010204', '07010205', '07010206'])
                ->sum('valor');
            
            // Seguros estudiantiles: suma de centros de costo específicos
            $segurosEstudiantiles = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['07010301', '07010302', '07010303', '07010304'])
                ->sum('valor');
            
            // Desarrollo curricular bilingüe / Bibliobanco: suma de centros de costo específicos
            $desarrolloCurricular = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['07010501', '07010502', '07010503', '07010504'])
                ->sum('valor');
            
            // Sistematización de Notas: suma de centros de costo específicos
            $sistematizacionNotas = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['07011201', '07011202', '07011203', '07011204'])
                ->sum('valor');
            
            // Materiales generales: suma de cuentas contables específicas
            $materialesGenerales = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('cuenta', ['28150512', '28150515', '28150516'])
                ->sum('valor');
            
            $ingresosEscolaresPorMes[$mesNombre] = [
                'matriculas' => abs($matriculas), // Usar valor absoluto para mostrar positivo
                'pensiones' => abs($pensiones),
                'seguros_estudiantiles' => abs($segurosEstudiantiles),
                'desarrollo_curricular' => abs($desarrolloCurricular),
                'sistematizacion_notas' => abs($sistematizacionNotas),
                'materiales_generales' => abs($materialesGenerales),
            ];
            
            // Calcular total del mes para ingresos escolares
            $totalMesEscolares = array_sum($ingresosEscolaresPorMes[$mesNombre]);
            $ingresosEscolaresPorMes[$mesNombre]['total'] = $totalMesEscolares;
        }

        // Calcular datos específicos para SECCIONES ACADEMIA GENERAL por mes
        $seccionesAcademiaGeneralPorMes = [];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Capacitación y Administración: centro de costo 020402
            $capacitacionAdministracion = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '020402')
                ->sum('valor');
            
            // Material Importado: suma de 130301 - 130302 - 130303 - 130304
            $materialImportado = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130301', '130302', '130303', '130304'])
                ->sum('valor');
            
            // Biblioteca institucional: suma de 130401 - 130402 - 130403 - 130404
            $bibliotecaInstitucional = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130401', '130402', '130403', '130404'])
                ->sum('valor');
            
            // Materiales para clases: suma de 130501 - 130502 - 130503 - 130504
            $materialesClases = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130501', '130502', '130503', '130504'])
                ->sum('valor');
            
            // Material Deportivo: suma de 130601 al 130605
            $materialDeportivo = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130601', '130602', '130603', '130604', '130605'])
                ->sum('valor');
            
            // Musicales: suma de 130701 al 130705
            $musicales = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130701', '130702', '130703', '130704', '130705'])
                ->sum('valor');
            
            // Part time teacher- reemplazos: suma de 130801 al 130805
            $partTimeTeacher = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['130801', '130802', '130803', '130804', '130805'])
                ->sum('valor');
            
            // Insumos institucionales de Seccion (Tecnologia): suma de 131901 - 131902 - 131903 - 131904
            $insumosTecnologia = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['131901', '131902', '131903', '131904'])
                ->sum('valor');
            
            // PEP: centro de costo 131001
            $pep = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '131001')
                ->sum('valor');
            
            // DP: suma de 131201-131204
            $dp = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['131201', '131202', '131203', '131204'])
                ->sum('valor');
            
            // PAI: centro de costo 131101
            $pai = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '131101')
                ->sum('valor');
            
            // Departamento de Apoyo: centro de costo 131801
            $departamentoApoyo = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '131801')
                ->sum('valor');
            
            // Consejeria Universitaria: centro de costo 130803
            $consejeriaUniversitaria = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '130803')
                ->sum('valor');
            
            // Dirección general: centro de costo 132005
            $direccionGeneral = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '132005')
                ->sum('valor');
            
            $seccionesAcademiaGeneralPorMes[$mesNombre] = [
                'capacitacion_administracion' => abs($capacitacionAdministracion),
                'material_importado' => abs($materialImportado),
                'biblioteca_institucional' => abs($bibliotecaInstitucional),
                'materiales_clases' => abs($materialesClases),
                'material_deportivo' => abs($materialDeportivo),
                'musicales' => abs($musicales),
                'part_time_teacher' => abs($partTimeTeacher),
                'insumos_tecnologia' => abs($insumosTecnologia),
                'pep' => abs($pep),
                'dp' => abs($dp),
                'pai' => abs($pai),
                'departamento_apoyo' => abs($departamentoApoyo),
                'consejeria_universitaria' => abs($consejeriaUniversitaria),
                'direccion_general' => abs($direccionGeneral),
            ];

            // Calcular total del mes
            $totalMes = array_sum($seccionesAcademiaGeneralPorMes[$mesNombre]);
            $seccionesAcademiaGeneralPorMes[$mesNombre]['total'] = $totalMes;

            // Calcular impacto % frente a ingresos totales
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $seccionesAcademiaGeneralPorMes[$mesNombre]['impacto'] = $impacto;
        }

        // Calcular datos específicos para OTROS ESCOLARES por mes
        $otrosEscolaresPorMes = [];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Rendimientos/Intereses mora/Certificados: centro 090102 + cuentas 41600502, 41751513 + todas las que empiecen con 42
            $rendimientosIntereses = 0;
            // Centro de costo 090102
            $rendimientosIntereses += $this->calcularSumaAbsoluta($year, $mesNumero, '090102');
            
            // Cuentas específicas
            $rendimientosIntereses += $this->calcularSumaAbsoluta($year, $mesNumero, null, ['41600502', '41751513']);
            
            // Todas las cuentas que empiecen con 42
            $rendimientosIntereses += $this->calcularSumaAbsoluta($year, $mesNumero, null, null, '42%');
            
            // Agenda escolar: centro de costo 07011501
            $agendaEscolar = abs(Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('centro_costo', '07011501')
                ->sum('valor'));
            
            // Anuario: cuenta contable 28150503
            $anuario = abs(Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->where('cuenta', '28150503')
                ->sum('valor'));
            
            // Examenes de Admisión: suma de centros 07010801, 07010802, 07010803, 07010804
            $examenesAdmision = abs(Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mesNumero)
                ->whereIn('centro_costo', ['07010801', '07010802', '07010803', '07010804'])
                ->sum('valor'));
            
            // Ingresos Por Servicio de Cafeteria: suma de centros 07020101-07020106
            $servicioCafeteria = $this->calcularSumaAbsoluta($year, $mesNumero, ['07020101', '07020102', '07020103', '07020104', '07020105', '07020106']);
            
            // Ingresos Servicio de Transporte: suma de centros 07020201-07020205
            $servicioTransporte = $this->calcularSumaAbsoluta($year, $mesNumero, ['07020201', '07020202', '07020203', '07020204', '07020205']);
            
            $otrosEscolaresPorMes[$mesNombre] = [
                'rendimientos_intereses' => $rendimientosIntereses, // Ya está en valor absoluto
                'agenda_escolar' => abs($agendaEscolar),
                'anuario' => abs($anuario),
                'examenes_admision' => abs($examenesAdmision),
                'servicio_cafeteria' => $servicioCafeteria, // Ya está en valor absoluto
                'servicio_transporte' => $servicioTransporte, // Ya está en valor absoluto
            ];

            // Calcular total del mes
            $totalMes = array_sum($otrosEscolaresPorMes[$mesNombre]);
            $otrosEscolaresPorMes[$mesNombre]['total'] = $totalMes;

            // Calcular impacto % frente a ingresos totales
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $otrosEscolaresPorMes[$mesNombre]['impacto'] = $impacto;
        }

        // Calcular datos específicos para SALARIOS Y PRESTACIONES SOCIALES ACADEMIA por mes
        $salariosAcademiaGeneralPorMes = [];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Crear lista de centros de costo: del 010101 al 010506, más 010508, 010509, 0513
            $centrosCosto = [];
            
            // Agregar rango 010101 a 010506
            for ($i = 1; $i <= 506; $i++) {
                $centrosCosto[] = sprintf('0101%02d', $i);
            }
            
            // Agregar códigos específicos adicionales
            $centrosCosto[] = '010508';
            $centrosCosto[] = '010509'; 
            $centrosCosto[] = '0513';
            
            // Calcular salarios academia con todos los centros de costo
            $salariosAcademia = $this->calcularSumaAbsoluta($year, $mesNumero, $centrosCosto);
            
            $salariosAcademiaGeneralPorMes[$mesNombre] = [
                'salarios_academia' => $salariosAcademia
            ];
            
            // Calcular total del mes
            $totalMes = $salariosAcademia;
            $salariosAcademiaGeneralPorMes[$mesNombre]['total'] = $totalMes;

            // Calcular impacto % frente a ingresos totales
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $salariosAcademiaGeneralPorMes[$mesNombre]['impacto'] = $impacto;
        }

        // Calcular datos específicos para SALARIOS Y PRESTACIONES SOCIALES ADMINISTRACION por mes
        $salariosAdministracionPorMes = [];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Salarios y Aux de Transporte - administración y servicios generales: 020101
            $salariosTransporte = $this->calcularSumaAbsoluta($year, $mesNumero, '020101');
            
            // Capacitación Administración: por ahora 0 (no encontramos centro específico)
            $capacitacionAdmin = 0;
            
            // Aprendices SENA: por ahora 0 (no encontramos centro específico)
            $aprendicesSena = 0;
            
            $salariosAdministracionPorMes[$mesNombre] = [
                'salarios_transporte' => $salariosTransporte,
                'capacitacion_admin' => $capacitacionAdmin,
                'aprendices_sena' => $aprendicesSena
            ];
            
            // Calcular total del mes
            $totalMes = $salariosTransporte + $capacitacionAdmin + $aprendicesSena;
            $salariosAdministracionPorMes[$mesNombre]['total'] = $totalMes;

            // Calcular impacto % frente a ingresos totales
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $salariosAdministracionPorMes[$mesNombre]['impacto'] = $impacto;
        }

        // Calcular datos específicos para RUBROS INSTITUCIONALES por mes
        $rubrosInstitucionalesPorMes = [];
        
        // Inicializar estructura por categoría con presupuestos fijos
        $presupuestosFijos = [
            'equipos' => 18060210,
            'examenes_medicos' => 10520000,
            'tecnologia_institucional' => 167566399,
            'insumos_enfermeria' => 5260000,
            'mercadeo_admisiones' => 78688901,
            'eventos_comunidad' => 5008698,
            'mantenimiento_general' => 0, // No se especificó valor
            'reparaciones_mayores' => 182322120,
            'reparacion_muebles' => 17200200,
            'utiles_oficina' => 34400400,
            'elementos_aseo' => 60000000,
            'dotacion_trabajo' => 27352000,
            'gastos_agasajos' => 45867200,
            'bienestar_institucional' => 22933600,
            'eventos_internos' => 0, // No se especificó valor
            'gastos_contratacion' => 5733400,
            'afiliaciones_inscripciones' => 68617032
        ];
        
        $categorias = [
            'equipos', 'examenes_medicos', 'tecnologia_institucional', 'insumos_enfermeria',
            'mercadeo_admisiones', 'eventos_comunidad', 'mantenimiento_general', 'reparaciones_mayores',
            'reparacion_muebles', 'utiles_oficina', 'elementos_aseo', 'dotacion_trabajo', 'gastos_agasajos',
            'bienestar_institucional', 'eventos_internos', 'gastos_contratacion', 'afiliaciones_inscripciones'
        ];
        
        foreach ($categorias as $categoria) {
            $rubrosInstitucionalesPorMes[$categoria] = [
                'presupuesto' => $presupuestosFijos[$categoria],
                'junio' => 0,
                'julio' => 0,
                'agosto' => 0,
                'septiembre' => 0,
                'octubre' => 0,
                'noviembre' => 0,
                'diciembre' => 0,
                'enero' => 0,
                'febrero' => 0
            ];
        }
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Función helper para calcular valores absolutos de centros de costo
            $calcularRubro = function($centrosCosto) use ($year, $mesNumero) {
                return $this->calcularSumaAbsoluta($year, $mesNumero, $centrosCosto);
            };
            
            // Equipos y Dotacion Salones: 11010101 - 11010102
            $rubrosInstitucionalesPorMes['equipos'][$mesNombre] = $calcularRubro(['11010101', '11010102']);
            
            // Examenes Médicos: 010510
            $rubrosInstitucionalesPorMes['examenes_medicos'][$mesNombre] = $calcularRubro(['010510']);
            
            // Tecnologia institucional: 110103
            $rubrosInstitucionalesPorMes['tecnologia_institucional'][$mesNombre] = $calcularRubro(['110103']);
            
            // Insumos enfermeria escolar: 110104
            $rubrosInstitucionalesPorMes['insumos_enfermeria'][$mesNombre] = $calcularRubro(['110104']);
            
            // Mercadeo y admisiones: 110114
            $rubrosInstitucionalesPorMes['mercadeo_admisiones'][$mesNombre] = $calcularRubro(['110114']);
            
            // Eventos Institucionales de Comunidad: 110107
            $rubrosInstitucionalesPorMes['eventos_comunidad'][$mesNombre] = $calcularRubro(['110107']);
            
            // Mantenimiento general: 11010204
            $rubrosInstitucionalesPorMes['mantenimiento_general'][$mesNombre] = $calcularRubro(['11010204']);
            
            // Reparaciones mayores: 11010201
            $rubrosInstitucionalesPorMes['reparaciones_mayores'][$mesNombre] = $calcularRubro(['11010201']);
            
            // Reparación de Muebles: 11010203 - 11010205
            $rubrosInstitucionalesPorMes['reparacion_muebles'][$mesNombre] = $calcularRubro(['11010203', '11010205']);
            
            // Utiles de Oficina y Papeleria: 110109
            $rubrosInstitucionalesPorMes['utiles_oficina'][$mesNombre] = $calcularRubro(['110109']);
            
            // Elementos de Aseo y Cafeteria: 11011001 - 11011002
            $rubrosInstitucionalesPorMes['elementos_aseo'][$mesNombre] = $calcularRubro(['11011001', '11011002']);
            
            // Dotación de Trabajo: (código por definir - temporalmente vacío)
            $rubrosInstitucionalesPorMes['dotacion_trabajo'][$mesNombre] = $calcularRubro([]);
            
            // Gastos de Agasajos: 110112
            $rubrosInstitucionalesPorMes['gastos_agasajos'][$mesNombre] = $calcularRubro(['110112']);
            
            // Bienestar institucional: 110118
            $rubrosInstitucionalesPorMes['bienestar_institucional'][$mesNombre] = $calcularRubro(['110118']);
            
            // Eventos institucionales internos: 132001 al 132004
            $rubrosInstitucionalesPorMes['eventos_internos'][$mesNombre] = $calcularRubro(['132001', '132002', '132003', '132004']);
            
            // Gastos de contratación: 010507
            $rubrosInstitucionalesPorMes['gastos_contratacion'][$mesNombre] = $calcularRubro(['010507']);
            
            // Afiliaciones e Inscripciones: 110113
            $rubrosInstitucionalesPorMes['afiliaciones_inscripciones'][$mesNombre] = $calcularRubro(['110113']);
        }

        // Calcular totales e impactos para rubros institucionales
        $totalPresupuesto = 0;
        foreach ($categorias as $categoria) {
            $totalPresupuesto += $presupuestosFijos[$categoria];
        }
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalMes = 0;
            foreach ($categorias as $categoria) {
                $totalMes += $rubrosInstitucionalesPorMes[$categoria][$mesNombre];
            }
            
            // Agregar total y % de impacto
            $rubrosInstitucionalesPorMes['total'][$mesNombre] = $totalMes;
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $rubrosInstitucionalesPorMes['impacto'][$mesNombre] = $impacto;
        }

        // Agregar presupuesto para total e impacto 
        $rubrosInstitucionalesPorMes['total']['presupuesto'] = $totalPresupuesto;
        
        // Calcular impacto % del presupuesto frente a ingresos totales
        // Total Ingresos Presupuestado = $12.856.980.087
        $presupuestoIngresosTotal = $presupuestoIngresos; // Usar el valor de presupuesto de ingresos definido arriba
        $impactoPresupuesto = $presupuestoIngresosTotal > 0 ? 
            ($totalPresupuesto / $presupuestoIngresosTotal) * 100 : 0;
        $rubrosInstitucionalesPorMes['impacto']['presupuesto'] = $impactoPresupuesto;

        // Calcular datos específicos para MEMBRESIAS Y CONVENIOS por mes
        $membresiasYConveniosPorMes = [];
        
        // Inicializar estructura para MEMBRESIAS Y CONVENIOS con presupuestos fijos
        $membresiasYConveniosPorMes['bachillerato_internacional'] = [
            'presupuesto' => 284954040,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $membresiasYConveniosPorMes['accbi'] = [
            'presupuesto' => 0,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $membresiasYConveniosPorMes['red_papaz'] = [
            'presupuesto' => 0,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Bachillerato Internacional: 110201
            $valorBachillerato = $this->calcularSumaAbsoluta($year, $mesNumero, '110201');
            
            $membresiasYConveniosPorMes['bachillerato_internacional'][$mesNombre] = $valorBachillerato;
            
            // ACCBI: Por ahora en $0 (sin centro de costo definido)
            $membresiasYConveniosPorMes['accbi'][$mesNombre] = 0;
            
            // RED PAPAZ: Por ahora en $0 (sin centro de costo definido)
            $membresiasYConveniosPorMes['red_papaz'][$mesNombre] = 0;
        }

        // Calcular totales e impactos para membresias y convenios
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalMes = $membresiasYConveniosPorMes['bachillerato_internacional'][$mesNombre] +
                       $membresiasYConveniosPorMes['accbi'][$mesNombre] +
                       $membresiasYConveniosPorMes['red_papaz'][$mesNombre];
            
            // Agregar total y % de impacto
            $membresiasYConveniosPorMes['total'][$mesNombre] = $totalMes;
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $membresiasYConveniosPorMes['impacto'][$mesNombre] = $impacto;
        }

        // Calcular presupuesto total para membresias y convenios
        $totalPresupuestoMembresias = $membresiasYConveniosPorMes['bachillerato_internacional']['presupuesto'] +
                                     $membresiasYConveniosPorMes['accbi']['presupuesto'] +
                                     $membresiasYConveniosPorMes['red_papaz']['presupuesto'];
        
        // Agregar presupuesto para total e impacto 
        $membresiasYConveniosPorMes['total']['presupuesto'] = $totalPresupuestoMembresias;
        
        // Calcular impacto % del presupuesto frente a ingresos totales
        $impactoPresupuestoMembresias = $presupuestoIngresos > 0 ? 
            ($totalPresupuestoMembresias / $presupuestoIngresos) * 100 : 0;
        $membresiasYConveniosPorMes['impacto']['presupuesto'] = $impactoPresupuestoMembresias;

        // Calcular datos específicos para SERVICIOS PUBLICOS por mes
        $serviciosPublicosPorMes = [];
        
        // Inicializar estructura para SERVICIOS PUBLICOS con presupuestos fijos
        $serviciosPublicosPorMes['agua'] = [
            'presupuesto' => 10883921,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $serviciosPublicosPorMes['energia'] = [
            'presupuesto' => 119406196,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $serviciosPublicosPorMes['telefono'] = [
            'presupuesto' => 32518205,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $serviciosPublicosPorMes['vigilancia'] = [
            'presupuesto' => 177134680,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $serviciosPublicosPorMes['internet_arrendamientos'] = [
            'presupuesto' => 156656907,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Función helper para calcular valores absolutos de centros de costo
            $calcularServicio = function($centrosCosto) use ($year, $mesNumero) {
                return $this->calcularSumaAbsoluta($year, $mesNumero, $centrosCosto);
            };
            
            // Agua: 110301
            $serviciosPublicosPorMes['agua'][$mesNombre] = $calcularServicio(['110301']);
            
            // Energía: 110302
            $serviciosPublicosPorMes['energia'][$mesNombre] = $calcularServicio(['110302']);
            
            // Teléfono: 110303
            $serviciosPublicosPorMes['telefono'][$mesNombre] = $calcularServicio(['110303']);
            
            // Vigilancia (METROS CUADRADOS PORTERO): 110304
            $serviciosPublicosPorMes['vigilancia'][$mesNombre] = $calcularServicio(['110304']);
            
            // Internet/ Arrendamientos Tecnológicos: 110305
            $serviciosPublicosPorMes['internet_arrendamientos'][$mesNombre] = $calcularServicio(['110305']);
        }

        // Calcular totales e impactos para servicios públicos
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalMes = $serviciosPublicosPorMes['agua'][$mesNombre] +
                       $serviciosPublicosPorMes['energia'][$mesNombre] +
                       $serviciosPublicosPorMes['telefono'][$mesNombre] +
                       $serviciosPublicosPorMes['vigilancia'][$mesNombre] +
                       $serviciosPublicosPorMes['internet_arrendamientos'][$mesNombre];
            
            // Agregar total y % de impacto
            $serviciosPublicosPorMes['total'][$mesNombre] = $totalMes;
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $serviciosPublicosPorMes['impacto'][$mesNombre] = $impacto;
        }

        // Calcular presupuesto total para servicios públicos
        $totalPresupuestoServicios = $serviciosPublicosPorMes['agua']['presupuesto'] +
                                    $serviciosPublicosPorMes['energia']['presupuesto'] +
                                    $serviciosPublicosPorMes['telefono']['presupuesto'] +
                                    $serviciosPublicosPorMes['vigilancia']['presupuesto'] +
                                    $serviciosPublicosPorMes['internet_arrendamientos']['presupuesto'];
        
        // Agregar presupuesto para total e impacto 
        $serviciosPublicosPorMes['total']['presupuesto'] = $totalPresupuestoServicios;
        
        // Calcular impacto % del presupuesto frente a ingresos totales
        $impactoPresupuestoServicios = $presupuestoIngresos > 0 ? 
            ($totalPresupuestoServicios / $presupuestoIngresos) * 100 : 0;
        $serviciosPublicosPorMes['impacto']['presupuesto'] = $impactoPresupuestoServicios;

        // Calcular datos específicos para OTROS EGRESOS por mes
        $otrosEgresosPorMes = [];
        
        // Inicializar estructura para OTROS EGRESOS con presupuestos fijos
        $otrosEgresosPorMes['honorarios'] = [
            'presupuesto' => 173054567,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['legales_sanciones'] = [
            'presupuesto' => 6020070,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['comisiones_bancarias'] = [
            'presupuesto' => 143612273,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['mensajeria_acarreos'] = [
            'presupuesto' => 1806021,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['impto_industria_comercio'] = [
            'presupuesto' => 89998861,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['plan_seguridad_salud'] = [
            'presupuesto' => 28224382,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['otros_egresos_retencion'] = [
            'presupuesto' => 0,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['impto_renta'] = [
            'presupuesto' => 204200774,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        $otrosEgresosPorMes['arrendamientos'] = [
            'presupuesto' => 1386750155,
            'junio' => 0,
            'julio' => 0,
            'agosto' => 0,
            'septiembre' => 0,
            'octubre' => 0,
            'noviembre' => 0,
            'diciembre' => 0,
            'enero' => 0,
            'febrero' => 0
        ];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            
            // Función helper para calcular valores absolutos de centros de costo
            $calcularEgreso = function($centrosCosto) use ($year, $mesNumero) {
                return $this->calcularSumaAbsoluta($year, $mesNumero, $centrosCosto);
            };
            
            // Honorarios: 010601
            $otrosEgresosPorMes['honorarios'][$mesNombre] = $calcularEgreso(['010601']);
            
            // Legales (sanciones UGPP) càmara de comercio: 110401
            $otrosEgresosPorMes['legales_sanciones'][$mesNombre] = $calcularEgreso(['110401']);
            
            // Comisiones Bancarias: 110404
            $otrosEgresosPorMes['comisiones_bancarias'][$mesNombre] = $calcularEgreso(['110404']);
            
            // Mensajería y Acarreos: 110405
            $otrosEgresosPorMes['mensajeria_acarreos'][$mesNombre] = $calcularEgreso(['110405']);
            
            // Impto de Industria y Comercio: 110407
            $otrosEgresosPorMes['impto_industria_comercio'][$mesNombre] = $calcularEgreso(['110407']);
            
            // Plan de seguridad y Salud en el trabajo: 110409
            $otrosEgresosPorMes['plan_seguridad_salud'][$mesNombre] = $calcularEgreso(['110409']);
            
            // Otros Egresos Retención: 110411
            $otrosEgresosPorMes['otros_egresos_retencion'][$mesNombre] = $calcularEgreso(['110411']);
            
            // Impto de renta: 110410
            $otrosEgresosPorMes['impto_renta'][$mesNombre] = $calcularEgreso(['110410']);
            
            // Arrendamientos: 120101
            $otrosEgresosPorMes['arrendamientos'][$mesNombre] = $calcularEgreso(['120101']);
        }

        // Calcular totales e impactos para otros egresos
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalMes = $otrosEgresosPorMes['honorarios'][$mesNombre] +
                       $otrosEgresosPorMes['legales_sanciones'][$mesNombre] +
                       $otrosEgresosPorMes['comisiones_bancarias'][$mesNombre] +
                       $otrosEgresosPorMes['mensajeria_acarreos'][$mesNombre] +
                       $otrosEgresosPorMes['impto_industria_comercio'][$mesNombre] +
                       $otrosEgresosPorMes['plan_seguridad_salud'][$mesNombre] +
                       $otrosEgresosPorMes['otros_egresos_retencion'][$mesNombre] +
                       $otrosEgresosPorMes['impto_renta'][$mesNombre] +
                       $otrosEgresosPorMes['arrendamientos'][$mesNombre];
            
            // Agregar total y % de impacto
            $otrosEgresosPorMes['total'][$mesNombre] = $totalMes;
            $impacto = $ingresosPorMes[$mesNombre] > 0 ? ($totalMes / $ingresosPorMes[$mesNombre]) * 100 : 0;
            $otrosEgresosPorMes['impacto'][$mesNombre] = $impacto;
        }

        // Calcular presupuesto total para otros egresos
        $totalPresupuestoOtrosEgresos = $otrosEgresosPorMes['honorarios']['presupuesto'] +
                                       $otrosEgresosPorMes['legales_sanciones']['presupuesto'] +
                                       $otrosEgresosPorMes['comisiones_bancarias']['presupuesto'] +
                                       $otrosEgresosPorMes['mensajeria_acarreos']['presupuesto'] +
                                       $otrosEgresosPorMes['impto_industria_comercio']['presupuesto'] +
                                       $otrosEgresosPorMes['plan_seguridad_salud']['presupuesto'] +
                                       $otrosEgresosPorMes['otros_egresos_retencion']['presupuesto'] +
                                       $otrosEgresosPorMes['impto_renta']['presupuesto'] +
                                       $otrosEgresosPorMes['arrendamientos']['presupuesto'];
        
        // Agregar presupuesto para total e impacto 
        $otrosEgresosPorMes['total']['presupuesto'] = $totalPresupuestoOtrosEgresos;
        
        // Calcular impacto % del presupuesto frente a ingresos totales
        $impactoPresupuestoOtrosEgresos = $presupuestoIngresos > 0 ? 
            ($totalPresupuestoOtrosEgresos / $presupuestoIngresos) * 100 : 0;
        $otrosEgresosPorMes['impacto']['presupuesto'] = $impactoPresupuestoOtrosEgresos;

        // Calcular Contratos Externos por mes
        $contratosExternosPorMes = [];
        
        // Definir categorías con sus centros de costo
        $categoriasContratosExternos = [
            'cafeteria' => ['12010201'],
            'transporte' => ['120103']
        ];
        
        foreach ($meses as $mesNombre => $mesNumero) {
            $year = $mesNumero >= 6 ? $currentYear : $nextYear;
            $contratosExternosPorMes[$mesNombre] = [];
            
            foreach ($categoriasContratosExternos as $categoria => $centrosCosto) {
                $total = 0;
                foreach ($centrosCosto as $centroCosto) {
                    // Usar función helper optimizada
                    $valor = $this->calcularSumaAbsoluta($year, $mesNumero, $centroCosto);
                    $total += $valor;
                }
                $contratosExternosPorMes[$mesNombre][$categoria] = $total;
            }
        }
        
        // Inicializar estructuras adicionales
        foreach ($categoriasContratosExternos as $categoria => $centrosCosto) {
            // Presupuesto (valores definidos)
            if ($categoria === 'cafeteria') {
                $contratosExternosPorMes[$categoria]['presupuesto'] = 599725348;
            } elseif ($categoria === 'transporte') {
                $contratosExternosPorMes[$categoria]['presupuesto'] = 1231729426;
            } else {
                $contratosExternosPorMes[$categoria]['presupuesto'] = 0;
            }
            
            // Total por categoría
            $totalCategoria = 0;
            foreach ($meses as $mesNombre => $mesNumero) {
                $totalCategoria += $contratosExternosPorMes[$mesNombre][$categoria];
            }
            $contratosExternosPorMes[$categoria]['total'] = $totalCategoria;
            
            // Impacto (calculado después)
            $contratosExternosPorMes[$categoria]['impacto'] = 0;
        }
        
        // Calcular totales generales por mes
        $contratosExternosPorMes['total'] = [];
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalMes = 0;
            foreach ($categoriasContratosExternos as $categoria => $centrosCosto) {
                $totalMes += $contratosExternosPorMes[$mesNombre][$categoria];
            }
            $contratosExternosPorMes['total'][$mesNombre] = $totalMes;
        }
        
        // Presupuesto y totales generales
        $contratosExternosPorMes['presupuesto']['total'] = 599725348 + 1231729426; // Cafetería + Transporte
        $totalGeneralContratos = 0;
        foreach ($meses as $mesNombre => $mesNumero) {
            $totalGeneralContratos += $contratosExternosPorMes['total'][$mesNombre];
        }
        $contratosExternosPorMes['total']['total'] = $totalGeneralContratos;
        
        // Calcular impacto
        $contratosExternosPorMes['impacto'] = [];
        foreach ($meses as $mesNombre => $mesNumero) {
            $contratosExternosPorMes['impacto'][$mesNombre] = $ingresosPorMes[$mesNombre] > 0 ? 
                ($contratosExternosPorMes['total'][$mesNombre] / $ingresosPorMes[$mesNombre]) * 100 : 0;
        }
        $contratosExternosPorMes['impacto']['presupuesto'] = 12856980087 > 0 ? 
            ($contratosExternosPorMes['presupuesto']['total'] / 12856980087) * 100 : 0;
        $contratosExternosPorMes['impacto']['total'] = $totalIngresos > 0 ? 
            ($totalGeneralContratos / $totalIngresos) * 100 : 0;

        return view('dashboard', compact(
            'presupuestoIngresos',
            'presupuestoEgresos',
            'presupuestoUtilidad',
            'totalIngresos',
            'totalEgresos',
            'utilidad',
            'ingresosPorMes',
            'egresosPorMes',
            'utilidadPorMes',
            'ingresosEscolaresPorMes',
            'seccionesAcademiaGeneralPorMes',
            'otrosEscolaresPorMes',
            'salariosAcademiaGeneralPorMes',
            'salariosAdministracionPorMes',
            'rubrosInstitucionalesPorMes',
            'membresiasYConveniosPorMes',
            'serviciosPublicosPorMes',
            'otrosEgresosPorMes',
            'contratosExternosPorMes',
            'resumenDatosPorMes'
        ));
    }

    public function getIngresoDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo o cuentas
        $criterios = [
            'matriculas' => ['tipo' => 'centro_costo', 'codigos' => ['070101', '07010101', '07010102', '07010103', '07010104', '07010105']],
            'pensiones' => ['tipo' => 'centro_costo', 'codigos' => ['07010201', '07010202', '07010203', '07010204', '07010205', '07010206']],
            'seguros_estudiantiles' => ['tipo' => 'centro_costo', 'codigos' => ['07010301', '07010302', '07010303', '07010304']],
            'desarrollo_curricular' => ['tipo' => 'centro_costo', 'codigos' => ['07010501', '07010502', '07010503', '07010504']],
            'sistematizacion_notas' => ['tipo' => 'centro_costo', 'codigos' => ['07011201', '07011202', '07011203', '07011204']],
            'materiales_generales' => ['tipo' => 'cuenta', 'codigos' => ['28150512', '28150515', '28150516']]
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $columna = $criterio['tipo'];
        $codigos = $criterio['codigos'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn($columna, $codigos)
            ->select('fecha', 'documento', 'descripcion', 'valor', $columna, 'cuenta')
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'movimientos' => $movimientos,
            'total' => abs($movimientos->sum('valor')),
            'tipo' => $tipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getSeccionDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo
        $criterios = [
            'capacitacion_administracion' => ['tipo' => 'centro_costo', 'codigos' => ['020402']],
            'material_importado' => ['tipo' => 'centro_costo', 'codigos' => ['130301', '130302', '130303', '130304']],
            'biblioteca_institucional' => ['tipo' => 'centro_costo', 'codigos' => ['130401', '130402', '130403', '130404']],
            'materiales_clases' => ['tipo' => 'centro_costo', 'codigos' => ['130501', '130502', '130503', '130504']],
            'material_deportivo' => ['tipo' => 'centro_costo', 'codigos' => ['130601', '130602', '130603', '130604', '130605']],
            'musicales' => ['tipo' => 'centro_costo', 'codigos' => ['130701', '130702', '130703', '130704', '130705']],
            'part_time_teacher' => ['tipo' => 'centro_costo', 'codigos' => ['130801', '130802', '130803', '130804', '130805']],
            'insumos_tecnologia' => ['tipo' => 'centro_costo', 'codigos' => ['131901', '131902', '131903', '131904']],
            'pep' => ['tipo' => 'centro_costo', 'codigos' => ['131001']],
            'dp' => ['tipo' => 'centro_costo', 'codigos' => ['131201', '131202', '131203', '131204']],
            'pai' => ['tipo' => 'centro_costo', 'codigos' => ['131101']],
            'departamento_apoyo' => ['tipo' => 'centro_costo', 'codigos' => ['131801']],
            'consejeria_universitaria' => ['tipo' => 'centro_costo', 'codigos' => ['130803']],
            'direccion_general' => ['tipo' => 'centro_costo', 'codigos' => ['132005']]
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $columna = $criterio['tipo'];
        $codigos = $criterio['codigos'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn($columna, $codigos)
            ->select('fecha', 'documento', 'descripcion', 'valor', $columna, 'cuenta')
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'movimientos' => $movimientos,
            'total' => abs($movimientos->sum('valor')),
            'tipo' => $tipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getOtroEscolarDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo y cuentas
        $criterios = [
            'rendimientos_intereses' => ['tipo' => 'mixto', 'centro_costo' => ['090102'], 'cuentas' => ['41600502', '41751513'], 'cuenta_like' => '42%'],
            'agenda_escolar' => ['tipo' => 'centro_costo', 'codigos' => ['07011501']],
            'anuario' => ['tipo' => 'cuenta', 'codigos' => ['28150503']],
            'examenes_admision' => ['tipo' => 'centro_costo', 'codigos' => ['07010801', '07010802', '07010803', '07010804']],
            'servicio_cafeteria' => ['tipo' => 'centro_costo', 'codigos' => ['07020101', '07020102', '07020103', '07020104', '07020105', '07020106']],
            'servicio_transporte' => ['tipo' => 'centro_costo', 'codigos' => ['07020201', '07020202', '07020203', '07020204', '07020205']]
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $movimientos = collect();

        if ($criterio['tipo'] == 'mixto') {
            // Para rendimientos/intereses que tiene múltiples criterios
            $movimientos = collect();
            $idsProcessed = [];
            
            // Centro de costo
            $movimientosCentro = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mes)
                ->whereIn('centro_costo', $criterio['centro_costo'])
                ->select('id', 'fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
                ->get();
            
            foreach ($movimientosCentro as $mov) {
                if (!in_array($mov->id, $idsProcessed)) {
                    $movimientos->push($mov);
                    $idsProcessed[] = $mov->id;
                }
            }
            
            // Cuentas específicas
            $movimientosCuentas = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mes)
                ->whereIn('cuenta', $criterio['cuentas'])
                ->select('id', 'fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
                ->get();
            
            foreach ($movimientosCuentas as $mov) {
                if (!in_array($mov->id, $idsProcessed)) {
                    $movimientos->push($mov);
                    $idsProcessed[] = $mov->id;
                }
            }
            
            // Cuentas que empiecen con 42
            $movimientosLike = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mes)
                ->where('cuenta', 'LIKE', $criterio['cuenta_like'])
                ->select('id', 'fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
                ->get();
            
            foreach ($movimientosLike as $mov) {
                if (!in_array($mov->id, $idsProcessed)) {
                    $movimientos->push($mov);
                    $idsProcessed[] = $mov->id;
                }
            }
        } else {
            // Para los demás tipos
            $columna = $criterio['tipo'];
            $codigos = $criterio['codigos'];

            $movimientos = Movimiento::whereYear('fecha', $year)
                ->whereMonth('fecha', $mes)
                ->whereIn($columna, $codigos)
                ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
                ->get();
        }

        $movimientos = $movimientos->sortByDesc('fecha')->values();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $tipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getSalarioDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Crear lista de centros de costo: del 010101 al 010506, más 010508, 010509, 0513
        $centrosCosto = [];
        
        // Agregar rango 010101 a 010506
        for ($i = 1; $i <= 506; $i++) {
            $centrosCosto[] = sprintf('0101%02d', $i);
        }
        
        // Agregar códigos específicos adicionales
        $centrosCosto[] = '010508';
        $centrosCosto[] = '010509'; 
        $centrosCosto[] = '0513';

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => 'Salarios y Prestaciones Sociales Academia',
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getSalarioAdministracionDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo específicos
        $criterios = [
            'salarios_transporte' => ['centro_costo' => '020101', 'nombre' => 'Salarios y Aux de Transporte - Administración y Servicios Generales'],
            'capacitacion_admin' => ['centro_costo' => '', 'nombre' => 'Capacitación Administración'],
            'aprendices_sena' => ['centro_costo' => '', 'nombre' => 'Aprendices SENA']
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $nombreTipo = $criterio['nombre'];

        // Si no hay centro de costo definido, retornar datos vacíos
        if (empty($criterio['centro_costo'])) {
            return response()->json([
                'movimientos' => [],
                'total' => 0,
                'tipo' => $nombreTipo,
                'mes' => $mes,
                'year' => $year
            ]);
        }

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->where('centro_costo', $criterio['centro_costo'])
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $nombreTipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getRubroInstitucionalDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo específicos
        $criterios = [
            'equipos' => ['centros_costo' => ['11010101', '11010102'], 'nombre' => 'Equipos y Dotación Salones y/o Oficinas'],
            'examenes_medicos' => ['centros_costo' => ['010510'], 'nombre' => 'Exámenes Médicos (Periódicos y de Contratación)'],
            'tecnologia_institucional' => ['centros_costo' => ['110103'], 'nombre' => 'Tecnología Institucional'],
            'insumos_enfermeria' => ['centros_costo' => ['110104'], 'nombre' => 'Insumos Enfermería Escolar'],
            'mercadeo_admisiones' => ['centros_costo' => ['110114'], 'nombre' => 'Mercadeo y Admisiones'],
            'eventos_comunidad' => ['centros_costo' => ['110107'], 'nombre' => 'Eventos Institucionales de Comunidad'],
            'mantenimiento_general' => ['centros_costo' => ['11010204'], 'nombre' => 'Mantenimiento General'],
            'reparaciones_mayores' => ['centros_costo' => ['11010201'], 'nombre' => 'Reparaciones Mayores (Construcciones)'],
            'reparacion_muebles' => ['centros_costo' => ['11010203', '11010205'], 'nombre' => 'Reparación de Muebles y Enseres'],
            'utiles_oficina' => ['centros_costo' => ['110109'], 'nombre' => 'Útiles de Oficina y Papelería (ABKA)'],
            'elementos_aseo' => ['centros_costo' => ['11011001', '11011002'], 'nombre' => 'Elementos de Aseo y Cafetería'],
            'gastos_agasajos' => ['centros_costo' => ['110112'], 'nombre' => 'Gastos de Agasajos'],
            'bienestar_institucional' => ['centros_costo' => ['110118'], 'nombre' => 'Bienestar Institucional'],
            'eventos_internos' => ['centros_costo' => ['132001', '132002', '132003', '132004'], 'nombre' => 'Eventos Institucionales Internos'],
            'gastos_contratacion' => ['centros_costo' => ['010507'], 'nombre' => 'Gastos de Contratación'],
            'afiliaciones_inscripciones' => ['centros_costo' => ['110113'], 'nombre' => 'Afiliaciones e Inscripciones']
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $nombreTipo = $criterio['nombre'];
        $centrosCosto = $criterio['centros_costo'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $nombreTipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getMembresiaConvenioDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo específicos
        $criterios = [
            'bachillerato_internacional' => ['centros_costo' => ['110201'], 'nombre' => 'Bachillerato Internacional']
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $nombreTipo = $criterio['nombre'];
        $centrosCosto = $criterio['centros_costo'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $nombreTipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getServicioPublicoDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo específicos
        $criterios = [
            'agua' => ['centros_costo' => ['110301'], 'nombre' => 'Agua'],
            'energia' => ['centros_costo' => ['110302'], 'nombre' => 'Energía'],
            'telefono' => ['centros_costo' => ['110303'], 'nombre' => 'Teléfono'],
            'vigilancia' => ['centros_costo' => ['110304'], 'nombre' => 'Vigilancia (METROS CUADRADOS PORTERO)'],
            'internet_arrendamientos' => ['centros_costo' => ['110305'], 'nombre' => 'Internet/ Arrendamientos Tecnológicos']
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $nombreTipo = $criterio['nombre'];
        $centrosCosto = $criterio['centros_costo'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $nombreTipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getSeccionAcademiaDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo
        $tiposACentrosCosto = [
            'capacitacion_administracion' => ['020402'],
            'material_importado' => ['130301', '130302', '130303', '130304'],
            'biblioteca_institucional' => ['130401', '130402', '130403', '130404'],
            'materiales_clases' => ['130501', '130502', '130503', '130504'],
            'material_deportivo' => ['130601', '130602', '130603', '130604', '130605'],
            'musicales' => ['130701', '130702', '130703', '130704', '130705'],
            'part_time_teacher' => ['130801', '130802', '130803', '130804', '130805'],
            'insumos_tecnologia' => ['131901', '131902', '131903', '131904'],
            'pep' => ['131001'],
            'dp' => ['131201', '131202', '131203', '131204'],
            'pai' => ['131101'],
            'departamento_apoyo' => ['131801'],
            'consejeria_universitaria' => ['130803'],
            'direccion_general' => ['132005']
        ];

        // Mapear tipos a nombres descriptivos
        $tiposANombres = [
            'capacitacion_administracion' => 'Capacitación y Administración',
            'material_importado' => 'Material Importado',
            'biblioteca_institucional' => 'Biblioteca Institucional',
            'materiales_clases' => 'Materiales para Clases',
            'material_deportivo' => 'Material Deportivo',
            'musicales' => 'Musicales',
            'part_time_teacher' => 'Part Time Teacher - Reemplazos',
            'insumos_tecnologia' => 'Insumos Institucionales de Sección (Tecnología)',
            'pep' => 'PEP',
            'dp' => 'DP',
            'pai' => 'PAI',
            'departamento_apoyo' => 'Departamento de Apoyo',
            'consejeria_universitaria' => 'Consejería Universitaria',
            'direccion_general' => 'Dirección General'
        ];

        $centrosCosto = $tiposACentrosCosto[$tipo] ?? [];
        
        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->orderBy('fecha', 'desc')
            ->get();

        $total = $movimientos->sum(function($mov) {
            return abs($mov->valor);
        });

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $tiposANombres[$tipo] ?? ucfirst(str_replace('_', ' ', $tipo)),
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getContratoExternoDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo
        $tiposACentrosCosto = [
            'cafeteria' => ['12010201'],
            'transporte' => ['120103']
        ];

        // Mapear tipos a nombres descriptivos
        $tiposANombres = [
            'cafeteria' => 'Cafetería',
            'transporte' => 'Transporte'
        ];

        $centrosCosto = $tiposACentrosCosto[$tipo] ?? [];
        
        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->orderBy('fecha', 'desc')
            ->get();

        $total = $movimientos->sum(function($mov) {
            return abs($mov->valor);
        });

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $tiposANombres[$tipo] ?? ucfirst(str_replace('_', ' ', $tipo)),
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getOtroEgresoDetalle(Request $request)
    {
        $tipo = $request->get('tipo');
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Mapear tipos a centros de costo específicos
        $criterios = [
            'honorarios' => ['centros_costo' => ['010601'], 'nombre' => 'Honorarios'],
            'legales_sanciones' => ['centros_costo' => ['110401'], 'nombre' => 'Legales (sanciones UGPP) cámara de comercio'],
            'comisiones_bancarias' => ['centros_costo' => ['110404'], 'nombre' => 'Comisiones Bancarias'],
            'mensajeria_acarreos' => ['centros_costo' => ['110405'], 'nombre' => 'Mensajería y Acarreos'],
            'impto_industria_comercio' => ['centros_costo' => ['110407'], 'nombre' => 'Impto de Industria y Comercio'],
            'plan_seguridad_salud' => ['centros_costo' => ['110409'], 'nombre' => 'Plan de seguridad y Salud en el trabajo'],
            'otros_egresos_retencion' => ['centros_costo' => ['110411'], 'nombre' => 'Otros Egresos Retención'],
            'impto_renta' => ['centros_costo' => ['110410'], 'nombre' => 'Impto de renta'],
            'arrendamientos' => ['centros_costo' => ['120101'], 'nombre' => 'Arrendamientos']
        ];

        if (!isset($criterios[$tipo])) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $criterio = $criterios[$tipo];
        $nombreTipo = $criterio['nombre'];
        $centrosCosto = $criterio['centros_costo'];

        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo', 'cuenta')
            ->orderByDesc('fecha')
            ->get();

        // Calcular el total usando valores absolutos individuales
        $total = 0;
        foreach ($movimientos as $mov) {
            $total += abs($mov->valor);
        }

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'tipo' => $nombreTipo,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getUtilidadCafeteriaDetalle(Request $request)
    {
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Obtener ingresos cafetería
        $ingresosCafeteria = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', ['07020101', '07020102', '07020103', '07020104', '07020105', '07020106'])
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo')
            ->orderByDesc('fecha')
            ->get();

        // Obtener contratos cafetería
        $contratosCafeteria = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->where('centro_costo', '12010201')
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo')
            ->orderByDesc('fecha')
            ->get();

        $totalIngresos = $this->calcularSumaAbsoluta($year, $mes, ['07020101', '07020102', '07020103', '07020104', '07020105', '07020106']);
        $totalContratos = $this->calcularSumaAbsoluta($year, $mes, ['12010201']);
        $utilidad = $totalIngresos - $totalContratos;

        return response()->json([
            'ingresos' => $ingresosCafeteria,
            'contratos' => $contratosCafeteria,
            'total_ingresos' => $totalIngresos,
            'total_contratos' => $totalContratos,
            'utilidad' => $utilidad,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getUtilidadTransporteDetalle(Request $request)
    {
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Obtener ingresos transporte
        $ingresosTransporte = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', ['07020201', '07020202', '07020203', '07020204', '07020205'])
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo')
            ->orderByDesc('fecha')
            ->get();

        // Obtener contratos transporte
        $contratosTransporte = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->where('centro_costo', '120103')
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo')
            ->orderByDesc('fecha')
            ->get();

        $totalIngresos = $this->calcularSumaAbsoluta($year, $mes, ['07020201', '07020202', '07020203', '07020204', '07020205']);
        $totalContratos = $this->calcularSumaAbsoluta($year, $mes, ['120103']);
        $utilidad = $totalIngresos - $totalContratos;

        return response()->json([
            'ingresos' => $ingresosTransporte,
            'contratos' => $contratosTransporte,
            'total_ingresos' => $totalIngresos,
            'total_contratos' => $totalContratos,
            'utilidad' => $utilidad,
            'mes' => $mes,
            'year' => $year
        ]);
    }

    public function getActividadesCurricularesDetalle(Request $request)
    {
        $mes = $request->get('mes');
        $year = $request->get('year');

        // Obtener movimientos de actividades curriculares (centros de costo 070104, 070105, 070106, 070107, 070108)
        $centrosCosto = ['070104', '070105', '070106', '070107', '070108'];
        
        $movimientos = Movimiento::whereYear('fecha', $year)
            ->whereMonth('fecha', $mes)
            ->whereIn('centro_costo', $centrosCosto)
            ->select('fecha', 'documento', 'descripcion', 'valor', 'centro_costo')
            ->orderByDesc('fecha')
            ->get();

        $total = $this->calcularSumaAbsoluta($year, $mes, $centrosCosto);

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'mes' => $mes,
            'year' => $year
        ]);
    }
}