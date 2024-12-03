<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumno'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'idAlumno';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;//indica si el id del modelo es autoincrementable
    protected $keyType = "int";// indica el tipo de dato del id autoincrementable
    protected $nombre;//nombre del campo para recibir el nombre del Alumno
    protected $primerApellido;//nombre del campo 
    protected $segundoApellido;//nombre del campo 
    protected $NIF;//nombre del campo 
    protected $fk_idGrupo;//nombre del campo 
    protected $estado;
    protected $fillable=["nombre","primerApellido","segundoApellido","NIF","fk_idGrupo","estado"];
    public $timestamps=false;
    public function grupo()
    {
        // Se asume que la relación está basada en fk_idGrupo
        return $this->belongsTo(Grupo::class, 'fk_idGrupo', 'idGrupo');
    }

    // Método para obtener el semestre y nombre del grupo
    public function getSemestreNombreGrupoAttribute()
    {
        // Verificar si el alumno tiene un grupo asociado
        if ($this->grupo) {
            return $this->grupo->semestre . '-' . $this->grupo->nombre;
        } else {
            return 'Sin grupo asignado';
        }
    }
}
