@extends('voyager::master')

@section('page_title', 'Panel de envío')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h1 class="page-title">
                    <i class="voyager-paper-plane"></i> Panel de envío
                </h1>
                {{-- <a href="#" class="btn btn-success btn-add-new">
                    <i class="voyager-plus"></i> <span>Crear</span>
                </a> --}}
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
            <form class="form-submit" action="{{ route('sender.send') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                <label for="select-contact_id">Contacto (*)</label>
                                <select name="contact_id[]" id="select-contact_id" multiple class="form-control" required>
                                    <option value="todos">Todos</option>
                                    @foreach (App\Models\Contact::where('status', 1)->where('deleted_at', NULL)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->phone }} {{ $item->full_name ? '('.$item->full_name.')' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="message">Mensaje</label>
                                <textarea name="message" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="image">Imagen</label>
                                <input type="file" name="image" accept="image/png, image/jpeg">
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="reset" class="btn btn-default"> <i class="voyager-refresh"></i> Vaciar</button>
                            <button type="submit" class="btn btn-primary btn-submit"> <i class="voyager-paper-plane"></i> Enviar</button>
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
            $('#select-contact_id').select2();

            $('.form-submit').submit(function(){
                $('.form-submit .btn-submit').attr('disabled', 'disabled');
            });
        });
    </script>
@stop
