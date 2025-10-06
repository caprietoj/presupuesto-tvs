<?php

use App\Http\Controllers\CentroCostoSeccionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeccionesController;
use App\Http\Controllers\AutologinController;
use Illuminate\Support\Facades\Route;

// Deshabilitar completamente la ruta de registro - debe ir ANTES que cualquier otra ruta
Route::any('register', function () {
    abort(404);
});

Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autologin (sin middleware auth)
Route::get('/autologin', [AutologinController::class, 'autologin'])->name('autologin');
Route::post('/api/autologin/generate-token', [AutologinController::class, 'generateToken'])->name('autologin.generate');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'check.access'])->name('dashboard');
Route::get('/dashboard/ingreso-detalle', [DashboardController::class, 'getIngresoDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.ingreso-detalle');
Route::get('/dashboard/seccion-detalle', [DashboardController::class, 'getSeccionDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.seccion-detalle');
Route::get('/dashboard/otro-escolar-detalle', [DashboardController::class, 'getOtroEscolarDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.otro-escolar-detalle');
Route::get('/dashboard/salario-detalle', [DashboardController::class, 'getSalarioDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.salario-detalle');
Route::get('/dashboard/salario-administracion-detalle', [DashboardController::class, 'getSalarioAdministracionDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.salario-administracion-detalle');
Route::get('/dashboard/rubro-institucional-detalle', [DashboardController::class, 'getRubroInstitucionalDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.rubro-institucional-detalle');
Route::get('/dashboard/membresia-convenio-detalle', [DashboardController::class, 'getMembresiaConvenioDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.membresia-convenio-detalle');
Route::get('/dashboard/servicio-publico-detalle', [DashboardController::class, 'getServicioPublicoDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.servicio-publico-detalle');
Route::get('/dashboard/seccion-academia-detalle', [DashboardController::class, 'getSeccionAcademiaDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.seccion-academia-detalle');
Route::get('/dashboard/contrato-externo-detalle', [DashboardController::class, 'getContratoExternoDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.contrato-externo-detalle');
Route::get('/dashboard/otro-egreso-detalle', [DashboardController::class, 'getOtroEgresoDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.otro-egreso-detalle');
Route::get('/dashboard/utilidad-cafeteria-detalle', [DashboardController::class, 'getUtilidadCafeteriaDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.utilidad-cafeteria-detalle');
Route::get('/dashboard/utilidad-transporte-detalle', [DashboardController::class, 'getUtilidadTransporteDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.utilidad-transporte-detalle');
Route::get('/dashboard/actividades-curriculares-detalle', [DashboardController::class, 'getActividadesCurricularesDetalle'])->middleware(['auth', 'check.access'])->name('dashboard.actividades-curriculares-detalle');

Route::middleware(['auth', 'check.access'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');
    
    Route::get('/secciones', [SeccionesController::class, 'index'])->name('secciones.index');
    Route::get('/secciones/detallado', [SeccionesController::class, 'detallado'])->name('secciones.detallado');
    Route::get('/secciones/aseo-cafeteria', [SeccionesController::class, 'aseoCafeteria'])->name('secciones.aseo-cafeteria');
    Route::get('/secciones/equipo-dotacion-salones', [SeccionesController::class, 'equipoDotacionSalones'])->name('secciones.equipo-dotacion-salones');
    Route::get('/secciones/deportes', [SeccionesController::class, 'deportes'])->name('secciones.deportes');
    Route::get('/secciones/honorarios', [SeccionesController::class, 'honorarios'])->name('secciones.honorarios');
    Route::get('/secciones/dotaciones', [SeccionesController::class, 'dotaciones'])->name('secciones.dotaciones');
    Route::get('/secciones/agasajos', [SeccionesController::class, 'agasajos'])->name('secciones.agasajos');
    Route::get('/secciones/tecnologia', [SeccionesController::class, 'tecnologia'])->name('secciones.tecnologia');
    Route::get('/secciones/gastos-contratacion', [SeccionesController::class, 'gastosContratacion'])->name('secciones.gastos-contratacion');
    Route::get('/secciones/afiliaciones-suscripciones', [SeccionesController::class, 'afiliacionesSuscripciones'])->name('secciones.afiliaciones-suscripciones');
    Route::get('/secciones/ib', [SeccionesController::class, 'ib'])->name('secciones.ib');
    Route::get('/secciones/entrenamientos', [SeccionesController::class, 'entrenamientos'])->name('secciones.entrenamientos');
    Route::get('/secciones/servicios-publicos', [SeccionesController::class, 'serviciosPublicos'])->name('secciones.servicios-publicos');
    Route::get('/secciones/reparaciones-mayores', [SeccionesController::class, 'reparacionesMayores'])->name('secciones.reparaciones-mayores');
    Route::get('/secciones/reparacion-muebles', [SeccionesController::class, 'reparacionMuebles'])->name('secciones.reparacion-muebles');
    Route::get('/secciones/mercadeo', [SeccionesController::class, 'mercadeo'])->name('secciones.mercadeo');
    Route::get('/api/secciones/movimientos', [SeccionesController::class, 'getMovimientosDetallado'])->name('api.secciones.movimientos');
    Route::get('/api/secciones/movimientos-operativas', [SeccionesController::class, 'getMovimientosSeccionOperativa'])->name('api.secciones.movimientos-operativas');
    Route::get('/secciones/movimientos-detallado', [SeccionesController::class, 'getMovimientosDetallado'])->name('secciones.movimientos-detallado');
    Route::get('/presupuesto-secciones', [SeccionesController::class, 'presupuesto'])->name('presupuesto-secciones.index');
    Route::post('/presupuesto-secciones', [SeccionesController::class, 'storePresupuesto'])->name('presupuesto-secciones.store');
    Route::put('/presupuesto-secciones/{id}', [SeccionesController::class, 'updatePresupuesto'])->name('presupuesto-secciones.update');
    Route::delete('/presupuesto-secciones/{id}', [SeccionesController::class, 'destroyPresupuesto'])->name('presupuesto-secciones.destroy');
    Route::get('/api/presupuestos-secciones', [SeccionesController::class, 'getPresupuestos'])->name('api.presupuestos-secciones');
    Route::get('/api/secciones/ejecucion-preescolar-primaria', [SeccionesController::class, 'getEjecucionPreescolarPrimaria'])->name('api.secciones.ejecucion-preescolar-primaria');
    Route::get('/api/secciones/ejecucion-escuela-media', [SeccionesController::class, 'getEjecucionEscuelaMedia'])->name('api.secciones.ejecucion-escuela-media');
    Route::get('/api/secciones/ejecucion-escuela-alta', [SeccionesController::class, 'getEjecucionEscuelaAlta'])->name('api.secciones.ejecucion-escuela-alta');
    Route::get('/api/secciones/ejecucion-pep', [SeccionesController::class, 'getEjecucionPep'])->name('api.secciones.ejecucion-pep');
    Route::get('/api/secciones/ejecucion-biblioteca', [SeccionesController::class, 'getEjecucionBiblioteca'])->name('api.secciones.ejecucion-biblioteca');
    Route::get('/api/secciones/ejecucion-psicologia', [SeccionesController::class, 'getEjecucionPsicologia'])->name('api.secciones.ejecucion-psicologia');
    Route::get('/api/secciones/ejecucion-cas', [SeccionesController::class, 'getEjecucionCas']);
Route::get('/api/secciones/ejecucion-consejeria-universitaria', [SeccionesController::class, 'getEjecucionConsejeriaUniversitaria']);
Route::get('/api/secciones/ejecucion-pai', [SeccionesController::class, 'getEjecucionPai']);
    
    // Centro de Costo Secciones
    Route::get('/centro-costo-secciones', [CentroCostoSeccionController::class, 'index'])->name('centro-costo-secciones.index');
    Route::post('/centro-costo-secciones', [CentroCostoSeccionController::class, 'store'])->name('centro-costo-secciones.store');
    Route::put('/centro-costo-secciones/{id}', [CentroCostoSeccionController::class, 'update'])->name('centro-costo-secciones.update');
    Route::delete('/centro-costo-secciones/{id}', [CentroCostoSeccionController::class, 'destroy'])->name('centro-costo-secciones.destroy');
    Route::get('/centro-costo-secciones/bulk-insert', [CentroCostoSeccionController::class, 'bulkInsert'])->name('centro-costo-secciones.bulk-insert');
});

require __DIR__.'/auth.php';
