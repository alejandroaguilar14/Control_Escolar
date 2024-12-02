@extends("components.layout") <!-- Extiende la plantilla layout -->

@section("content") <!-- Define el bloque de contenido -->

<div class="container-fluid">
    <div class="row">
        <!-- Contenido principal -->
        <div class="col content">
            @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
            <!-- Incluye el componente de migas de pan -->
            @endcomponent

            <div class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Grupos @if($estado == 0) Deshabilitados @endif</h1>
                    <!-- Botones de acción -->
                    <div class="titlebar-commands">
                        @if($estado == 1)
                            <a class="btn btn-primary" href="{{url('/catalogos/grupos/agregar')}}">Agregar</a>
                            <a class="btn btn-secondary" href="{{url('/catalogos/grupos/deshabilitados')}}">Ver Deshabilitados</a>
                        @else
                            <a class="btn btn-primary" href="{{url('/catalogos/grupos')}}">Ver Habilitados</a>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-fluid" id="maintable"> 
                                <!-- Encabezados de la tabla -->
                                <thead> 
                                    <tr> 
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col" class="text-center">NOMBRE</th>
                                        <th scope="col" class="text-center">SEMESTRE</th>
                                        <th scope="col" colspan="2" class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <!-- Iteración sobre los grupos -->
                                    @foreach($grupos as $grupo) 
                                        <tr>
                                            <!-- Datos del grupo -->
                                            <td class="text-center">{{$grupo->idGrupo}}</td>
                                            <td class="text-center">{{$grupo->nombre}}</td>
                                            <td class="text-center">{{$grupo->semestre}}</td>
                                            <td class="text-center">
                                                <!-- Botón de Modificar si el estado es 1 -->
                                                @if($estado == 1)
                                                    <a href='{{url("/catalogos/grupos/{$grupo->idGrupo}/modificar")}}' class="btn btn-success">Modificar</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <!-- Botón de Deshabilitar/Habilitar según el estado -->
                                                @if($estado == 1)
                                                    <a href='{{url("/catalogos/grupos/{$grupo->idGrupo}/deshabilitar")}}' class="btn btn-danger">Deshabilitar</a>
                                                @else
                                                    <a href='{{url("/catalogos/grupos/{$grupo->idGrupo}/habilitar")}}' class="btn btn-info">Habilitar</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Paginación de la tabla -->
                            {{ $grupos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection <!-- Fin del bloque de contenido -->

@section('styles') <!-- Sección para los estilos -->

<style>
    .content {
        transition: margin-left 0.3s;
        width: 100%;
    }

    .sidebar.active ~ .content {
        margin-left: 250px;
        width: calc(100% - 250px);
    }

    .titlebar-commands {
        display: flex;
        align-items: center;
    }

    .btn-primary {
        margin-left: 10px;
    }

    .table td, .table th {
        text-align: center;
    }

    .table-fluid {
        width: 100%;
    }

    .table {
        min-width: 800px; /* Ajusta el ancho mínimo de la tabla según sea necesario */
    }
</style>

@endsection <!-- Fin de la sección de estilos -->

@section('scripts') <!-- Sección para los scripts -->

<script>
    let table = new DataTable("#maintable", {
        paging: true,
        searching: true
    });
</script>

@endsection <!-- Fin de la sección de scripts -->
