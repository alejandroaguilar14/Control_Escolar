<style>
    .breadcrumb {
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 5px;
    }

    .breadcrumb-item {
        display: inline-block;
        margin-right: 5px;
    }

    .breadcrumb-item:last-child {
        font-weight: bold;
    }

    .breadcrumb-item a {
        color: #007bff; /* Color del enlace */
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d; /* Color del texto activo */
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $name=>$url)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page" >
                    {{$name}}
                </li> 
            @else
                <li class="breadcrumb-item">
                    <a href="{{$url}}">{{$name}}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
