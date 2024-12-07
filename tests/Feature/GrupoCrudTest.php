<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\CatalogosController;
use Illuminate\Http\Request;
use App\Models\Grupo;

class GrupoCrudTest extends TestCase
{

    public function test_can_create_grupo_directly()
    {
        // Crear una instancia del controlador
        $controller = new CatalogosController();

        // Simular los datos del request
        $request = Request::create('/dummy-url', 'POST', [
            'nombre' => 'F',
            'semestre' => 3,
        ]);

        // Invocar directamente el método del controlador
        $controller->agregarGrupo($request);

        // Verificar que el registro se haya guardado en la base de datos
        $this->assertDatabaseHas('grupo', [
            'nombre' => 'F',
            'semestre' => 3,
            'estado' => 1,
        ]);
    }
}
