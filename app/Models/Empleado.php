<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empleados';
    protected $primaryKey = 'idempleado';
    protected $fillable = [
        'nombre', 'primer_apellido', 'segundo_apellido',
        'email', 'idcargo', 'idnivel', 'fecha_contratacion',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'idcargo', 'idcargo'); // Asegúrate de que la clave foránea es 'idcargo' y la clave primaria es 'idcargo'
    }

    // Definir la relación con el modelo Nivel
    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'idnivel', 'idnivel'); // Aquí está bien si 'idnivel' es correcto
    }
}

