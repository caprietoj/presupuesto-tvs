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
        try {
            // Ejecutar el seeder
            \Artisan::call('db:seed', ['--class' => 'CentroCostoSeccionSeeder']);
            
            return redirect()->back()->with('success', 'Datos iniciales cargados exitosamente. Total: 65 registros.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar datos: ' . $e->getMessage());
        }
    }
}
