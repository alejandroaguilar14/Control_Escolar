<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenPractico extends Model
{
    use HasFactory;
    protected $table = 'examenpractico'; // nombre de la tabla en la BD a la que el modelo hace referencia.
    protected $primaryKey = 'idExamenPractico';//atributo de llave primaria asociado con la tabla
    public $incrementing = true;
    protected  $keyType = 'int';
    protected $titulo;//nombre del campo 
    protected $gradoDificultad;//nombre del campo 
    protected $estado;
    protected $fillable=["titulo","gradoDificultad","estado"];
    public $timestamps=false;

}