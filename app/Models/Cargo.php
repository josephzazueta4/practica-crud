<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    /** @use HasFactory<\Database\Factories\CargoFactory> */
    use HasFactory;
    protected $fillable = ['nombre_cargo'];
    protected $primaryKey = 'idcargo';  

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'cargo_id'); // Especifica 'cargo_id' si esa es la clave foránea en la tabla 'empleados'
    }
}
