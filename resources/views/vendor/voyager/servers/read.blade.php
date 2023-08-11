
@extends('voyager::master')

@section('page_title', 'Ver Servidor')

@php
    $server = App\Models\Server::find($dataTypeContent->getKey());
@endphp

@section('page_header')
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">
                <i class="voyager-harddrive"></i> Viendo Servidor &nbsp;&nbsp;
                <a href="{{ route('voyager.servers.index') }}" class="btn btn-warning">
                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                    Volver a la lista
                </a>
            </h1>
        </div>
        <div id="status" class="col-md-4 text-right" style="margin-top: 30px">
            <span>Obteniendo estado...</span>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $server->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">URL</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $server->url }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>N&deg;</th>
                                    <th>ID</th>
                                    <th>Contacto</th>
                                    <th>Texto</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach ($server->messages->sortByDesc('id') as $item)
                                    <tr>
                                        <td>{{ $cont }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->contact->full_name ?? $item->contact->phone }}</td>
                                        <td>{{ $item->text }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/'.str_replace('.', '-small.', $item->image)) }}" alt="{{ $item->text }}" width="50px">
                                            @endif
                                        </td>
                                        <th><label class="label label-{{ $item->status == 'enviado' ? 'primary' : 'default' }}">{{ Str::ucfirst($item->status) }}</label></th>
                                        <td>
                                            {{ date('d/m/Y H:i', strtotime($item->created_at)) }} <br>
                                            <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @php
                                        $cont++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal QR --}}
    <div class="modal modal-success fade" tabindex="-1" id="qr_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-lock"></i> Iniciar sesión</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <img alt="Código QR" id="qr_code">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('js/qrious.js') }}"></script>
    {{-- Socket.io --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.0/socket.io.js" integrity="sha512-nYuHvSAhY5lFZ4ixSViOwsEKFvlxHMU2NHts1ILuJgOS6ptUmAGt/0i5czIgMOahKZ6JN84YFDA+mCdky7dD8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const socket = io("{{ $server->url }}");
        socket.on('login', data => {
            $('#status').html('<button class="btn btn-success">En línea</button>');
            $('#qr_modal').modal('hide');
        });
        socket.on('qr', data => {
            $('#qr_modal').modal('show');
            new QRious({
                element: document.querySelector("#qr_code"),
                value: data.qr,
                size: 450,
                backgroundAlpha: 0,
                foreground: "#000000",
                level: "H", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
            });
        });
        socket.on('logout', data => {
            $('#status').html('<button type="button" class="btn btn-danger btn-offline" onclick="login()">Sesión finalizada</button>');
        });
        socket.on('disconnected', data => {
            $('#qr_modal').modal('hide');
            $('#status').html('<button type="button" class="btn btn-danger btn-offline" onclick="login()">Sesión finalizada</button>');
            console.log(data);
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                order: [[ 1, "desc" ]],
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    sInfoThousands: ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    buttons: {
                        copy: "Copiar",
                        colvis: "Visibilidad"
                    }
                }
            });

            fetch('{{ $server->url }}/status')
                .then(response => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Ocurrió un error');
                })
                .then(res => {
                    if (res.success) {
                        if (res.status == 1) {
                            $('#status').html('<button class="btn btn-success">En línea</button>');
                        } else {
                            $('#status').html('<button type="button" class="btn btn-danger btn-offline" onclick="login()">Fuera línea</button>');
                        }
                    } else {
                        console.log('Error al obtener el estado')
                    }
                })
                .catch(function(error) {
                    $('#status').html('<b class="text-danger">Servidor fuera de línea</b>');
                    console.log('Request failed', error);
                });
        });

        function login() {
            fetch('{{ $server->url }}/login')
                .then(response => {
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error('Ocurrió un error');
                })
                .then(res => {
                    if (res.success) {
                        $('#status').html('<span>Iniciando sesión...</span>');
                    } else {
                        console.log('Error al iniciar sesión')
                    }
                })
                .catch(function(error) {
                    console.log('Request failed', error);
                });
        }
    </script>
@stop
