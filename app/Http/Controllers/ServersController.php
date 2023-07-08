<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Models
use App\Models\Server;

class ServersController extends Controller
{
    public function test($id){
        try {
            $server = Server::findOrFail($id);
            Http::get($server->url.'/test');
            return redirect()->route('voyager.servers.index')->with(['message' => 'Mensaje de prueba enviado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->route('voyager.servers.index')->with(['message' => 'Ocurrió un error en el servidor', 'alert-type' => 'error']);
        }
    }
}
