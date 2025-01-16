<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Nivel;
use App\Http\Requests\StoreEmpleadoRequest;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('cargo', 'nivel')->get();
        return inertia('Empleados/Index', ['empleados' => $empleados]);
    }

    public function create()
    {
        return inertia('Empleados/Form', [
            'cargos' => Cargo::all(),
            'niveles' => Nivel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'email' => 'required|email|unique:empleados,email',
            'idcargo' => 'required|exists:cargos,idcargo',  
            'idnivel' => 'required|exists:niveles,Idnivel',  
            'salario' => 'required|numeric|min:0',  
            'fecha_contratacion' => 'required|date',
        ]);
    
        
        $empleado = Empleado::create($validated);
    
        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit(Empleado $empleado)
    {
        return inertia('Empleados/Form', [
            'empleado' => $empleado,
            'cargos' => Cargo::all(),
            'niveles' => Nivel::all(),
        ]);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'primer_apellido' => 'required|string|max:255',
        'segundo_apellido' => 'nullable|string|max:255',
        'email' => 'required|email|unique:empleados,email,' . $id, 
        'idcargo' => 'required|exists:cargos,idcargo',
        'idnivel' => 'required|exists:niveles,Idnivel',
        'salario' => 'required|numeric|min:0',
        'fecha_contratacion' => 'required|date',
    ]);

    $empleado = Empleado::findOrFail($id);
    $empleado->update($validated);

    return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
}

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
