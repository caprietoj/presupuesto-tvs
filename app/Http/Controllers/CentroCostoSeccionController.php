<?php

namespace App\Http\Controllers;

use App\Models\CentroCostoSeccion;
use Illuminate\Http\Request;

class CentroCostoSeccionController extends Controller
{
    public function index(Request $request)
    {
        $query = CentroCostoSeccion::query();
        
        // Aplicar filtros si existen
        if ($request->filled('centro_costo')) {
            $query->where('centro_costo', 'like', '%' . $request->centro_costo . '%');
        }
        
        if ($request->filled('rubro')) {
            $query->where('rubro', 'like', '%' . $request->rubro . '%');
        }
        
        if ($request->filled('seccion')) {
            $query->where('seccion', 'like', '%' . $request->seccion . '%');
        }
        
        $centrosCosto = $query->orderBy('centro_costo')->paginate(10)->withQueryString();
        
        return view('centro-costo-secciones.index', compact('centrosCosto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'centro_costo' => 'required|string|max:10|unique:centro_costo_seccions',
            'rubro' => 'required|string|max:255',
            'seccion' => 'required|string|max:255'
        ]);

        CentroCostoSeccion::create($request->all());

        return redirect()->back()->with('success', 'Centro de costo creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'centro_costo' => 'required|string|max:10|unique:centro_costo_seccions,centro_costo,' . $id,
            'rubro' => 'required|string|max:255',
            'seccion' => 'required|string|max:255'
        ]);

        $centroCosto = CentroCostoSeccion::findOrFail($id);
        $centroCosto->update($request->all());

        return redirect()->back()->with('success', 'Centro de costo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $centroCosto = CentroCostoSeccion::findOrFail($id);
        $centroCosto->delete();

        return redirect()->back()->with('success', 'Centro de costo eliminado exitosamente');
    }

    public function bulkInsert()
    {
        $datos = [
            ['centro_costo' => '130101', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130102', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130103', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130104', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'ALTA'],
            ['centro_costo' => '130201', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130202', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130203', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130204', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'ALTA'],
            ['centro_costo' => '130205', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PEP'],
            ['centro_costo' => '130301', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130302', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130303', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130304', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'ALTA'],
            ['centro_costo' => '130305', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PEP'],
            ['centro_costo' => '130401', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130402', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130403', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130404', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130405', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130406', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130501', 'rubro' => 'MATERIALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130502', 'rubro' => 'MATERIALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130503', 'rubro' => 'MATERIALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130504', 'rubro' => 'MATERIALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130601', 'rubro' => 'DEPORTES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130602', 'rubro' => 'DEPORTES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130603', 'rubro' => 'DEPORTES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130604', 'rubro' => 'DEPORTES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130605', 'rubro' => 'DEPORTES', 'seccion' => 'DEPORTES ACADEMIA'],
            ['centro_costo' => '130701', 'rubro' => 'MUSICALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130702', 'rubro' => 'MUSICALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130703', 'rubro' => 'MUSICALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130704', 'rubro' => 'MUSICALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130801', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130802', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130803', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130804', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'ALTA'],
            ['centro_costo' => '130901', 'rubro' => 'DOTACION', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130902', 'rubro' => 'DOTACION', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130903', 'rubro' => 'DOTACION', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130904', 'rubro' => 'DOTACION', 'seccion' => 'ALTA'],
            ['centro_costo' => '131001', 'rubro' => 'EXHIBITION PEP', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131101', 'rubro' => 'PERSONAL PROYEC PAI', 'seccion' => 'PAI'],
            ['centro_costo' => '131201', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131202', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131203', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131204', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131301', 'rubro' => 'PRAE', 'seccion' => 'BIENESTAR INSTITUCIONAL'],
            ['centro_costo' => '131401', 'rubro' => 'MODELO NACIONES UNIDAS TVS', 'seccion' => 'MUN TVS'],
            ['centro_costo' => '131501', 'rubro' => 'MUN OTROS COLEGIOS', 'seccion' => 'MUN OTROS COLEGIOS'],
            ['centro_costo' => '131601', 'rubro' => 'CONSEJERIA UNIVERSITARIA', 'seccion' => 'CONSEJERIA UNIVERSITARIA'],
            ['centro_costo' => '131701', 'rubro' => 'EXHIBITION DE ARTE', 'seccion' => 'EXHIBITION DE ARTE'],
            ['centro_costo' => '131801', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131802', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131803', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131901', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131902', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131903', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '131904', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '132001', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '132002', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '132003', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '132004', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'ALTA'],
            ['centro_costo' => '132005', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'DIRECCION GENERAL'],
            ['centro_costo' => '132101', 'rubro' => 'CURSO PREICFES', 'seccion' => 'CURSO PREICFES']
        ];

        try {
            foreach ($datos as $dato) {
                CentroCostoSeccion::updateOrCreate(
                    ['centro_costo' => $dato['centro_costo']], 
                    $dato
                );
            }
            return redirect()->back()->with('success', 'Datos iniciales cargados exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar datos: ' . $e->getMessage());
        }
    }
}
