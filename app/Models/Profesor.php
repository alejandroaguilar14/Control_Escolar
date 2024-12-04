<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $table = 'profesor'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'idProfesor';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;//indica si el id del modelo es autoincrementable
    protected $keyType = "int";// indica el tipo de dato del id autoincrementable
    protected $nombre;//nombre del campo para recibir el nombre del Alumno
    protected $primerApellido;//nombre del campo 
    protected $segundoApellido;//nombre del campo 
    protected $NIF;//nombre del campo 
    protected $estado;
    protected $fillable=["nombre","primerApellido","segundoApellido","NIF","estado"];
    public $timestamps=false;

}
