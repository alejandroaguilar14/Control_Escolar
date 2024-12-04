<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenTeorico extends Model
{
    use HasFactory;
    protected $table = 'examenteorico'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'idExamenTeorico';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;
    protected  $keyType = 'int';
    protected $fecha;//nombre del campo para recibir el nombre del Alumno
    protected $fk_idProfesor;//nombre del campo 
    protected $titulo;//nombre del campo 
    protected $numPreguntas;//nombre del campo 
    protected $estado;
    protected $fillable=["fecha","fk_idProfesor","titulo","numPreguntas","estado"];
    public $timestamps=false;
}
