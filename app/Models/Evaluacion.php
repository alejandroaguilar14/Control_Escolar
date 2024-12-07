<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $table = 'evaluacion'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'idEvaluacion';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;//indica si el id del modelo es autoincrementable
    protected $keyType = "int";// indica el tipo de dato del id autoincrementable
    protected $fecha;//nombre del campo para recibir el nombre del Alumno
    protected $idExamen;//nombre del campo 
    protected $tipoExamen;//nombre del campo
    protected $fk_idGrupo;
    protected $estado;
    protected $fillable=["fecha","fk_idAlumno","idExamen","nota","tipoExamen","fk_idGrupo","estado"];
    public $timestamps=false;
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'fk_idGrupo', 'idGrupo');
    }
}
