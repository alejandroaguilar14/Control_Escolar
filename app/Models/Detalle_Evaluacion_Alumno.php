<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Evaluacion_Alumno extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'detalle_evaluacion_alumno'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'id_det_eva_alum';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;//indica si el id del modelo es autoincrementable
    protected $keyType = "int";// indica el tipo de dato del id autoincrementable
    protected $fk_idEvaluacion;//nombre del campo 
    protected $fk_idAlumno;//nombre del campo 
    protected $nota;
    protected $fillable=["fk_idEvaluacion","fk_idAlumno","nota"];
    public $timestamps=false;
}
