<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Models
use App\Models\Server;
use App\Models\ContactMessage;

// Jobs
use App\Jobs\ProcessSendMessage;

class ServersController extends Controller
{
    public function test($id){
        try {
            $server = Server::findOrFail($id);
            Http::get($server->url.'/test?id='.$server->slug);
            return redirect()->route('voyager.servers.index')->with(['message' => 'Mensaje de prueba enviado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->route('voyager.servers.index')->with(['message' => 'Ocurrió un error en el servidor', 'alert-type' => 'error']);
        }
    }

    public function send($server_id, $id){
        ProcessSendMessage::dispatch(ContactMessage::find($id));
        return redirect()->route('voyager.servers.show', ['id' => $server_id])->with(['message' => 'Mensaje enviado', 'alert-type' => 'success']);
    }
}