<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Profesor_ExamPractico extends Model
{
    use HasFactory;
    protected $table = 'detalle_profesor_exampractico'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'id_det_prof_examPractico';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;//indica si el id del modelo es autoincrementable
    protected $keyType = "int";// indica el tipo de dato del id autoincrementable
    protected $fechaParticipacion;//nombre del campo para recibir el nombre del Alumno
    protected $fk_idProfesor;//nombre del campo 
    protected $fk_idExamenPractico;//nombre del campo 
    protected $fillable=["fechaParticipacion","fk_idProfesor","fk_idExamenPractico"];
    public $timestamps=false;
}
