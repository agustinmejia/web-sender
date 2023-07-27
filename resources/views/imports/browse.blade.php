@extends('voyager::master')

@section('page_title', 'Viendo Importar contactos')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h1 class="page-title">
                    <i class="voyager-upload"></i> Importar contactos
                </h1>
            </div>
            <div class="col-md-8 text-right" style="padding-top: 10px">

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <form class="form-submit" action="{{ route('imports.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group col-md-6">
                                <label for="category_id">Categoría</label>
                                <select name="category_id" class="form-control select2">
                                    <option value="">Ninguna</option>
                                    @foreach (App\Models\Category::where('status', 1)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="file">Archivo</label>
                                <input type="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            </div>
                        </div>
                        <div class="panel-body text-right">
                            <button type="reset" class="btn btn-default">Cancelar</button>
                            <button class="btn btn-primary btn-submit">Importar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop
