<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Niveles;
use App\Http\Requests\StoreEmpleadoRequest;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el valor de búsqueda
        $search = $request->input('search');
    
        // Filtrar empleados por nombre o cargo
        $empleados = Empleado::with('cargo', 'nivel')  // Asegúrate de que la relación 'cargo' y 'nivel' estén definidas
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    // Buscar por nombre del empleado
                    $q->where('empleados.nombre', 'like', "%$search%")
                      // Unir con la tabla 'cargos' y buscar por nombre_cargo
                      ->orWhereHas('cargo', function($q) use ($search) {
                          $q->where('nombre_cargo', 'like', "%$search%");
                      });
                });
            })
            ->paginate(5);
    
        return inertia('Empleados/Index', [
            'empleados' => $empleados,
        ]);
    }
    
    
    
    

    public function create()
    {
        // Obtener los cargos y niveles para pasarlos a la vista
        return inertia('Empleados/Form', [
            'cargos' => Cargo::all(),
            'niveles' => Niveles::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'email' => 'required|email|unique:empleados,email',
                'idcargo' => 'required|exists:cargos,idcargo',
                'idnivel' => 'required|exists:niveles,idnivel',
                'salario' => 'required|numeric|min:0',
                'fecha_contratacion' => 'required|date',
            ]);
            
            // Crear el nuevo empleado
            $empleado = Empleado::create($validated);

            // Redirigir con mensaje de éxito
            return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo específico para errores de la base de datos, como el error de "unique"
            if ($e->getCode() == 23000) { // Código de error para violación de restricción de unicidad
                // Extraemos el mensaje de error para el correo electrónico duplicado
                return back()->withErrors(['email' => 'El correo electrónico ya está registrado.']);
            } else {
                // Capturamos cualquier otro error de base de datos
                \Log::error('Error al guardar empleado: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Ocurrió un error al crear el empleado.']);
            }
        } catch (\Exception $e) {
            // Capturar cualquier otra excepción y loguear el error
            \Log::error('Error al guardar empleado: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error inesperado.']);
        }
    }

    
    public function edit($id)
    {
        // Utiliza $id para encontrar al empleado
        $empleado = Empleado::findOrFail($id);
        $cargos = Cargo::all();
        $niveles = Niveles::all();
    
        return inertia('Empleados/edit', [
            'empleado' => $empleado,
            'cargos' => $cargos,
            'niveles' => $niveles,
        ]);
    }
    
    
    
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'primer_apellido' => 'required|string|max:255',
        'segundo_apellido' => 'nullable|string|max:255',
        'email' => 'required|email|unique:empleados,email,' . $id . ',idempleado',  // Usa $id
        'idcargo' => 'required|exists:cargos,idcargo',
        'idnivel' => 'required|exists:niveles,Idnivel',
        'salario' => 'required|numeric|min:0',
        'fecha_contratacion' => 'required|date',
    ]);

    // Utiliza $id para actualizar al empleado
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
