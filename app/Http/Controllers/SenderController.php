<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Contact;
use App\Models\Server;
use App\Models\Message;

// Queue
use App\Jobs\ProcessSendMessage;

class SenderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $this->custom_authorize('browse_sender');
        return view('dashboard.browse');
    }

    public function send(Request $request) {
        try {
            $contact_id = $request->contact_id;
            $image = $this->save_image($request->file('image'), 'messages');

            if($contact_id[0] == 'todos'){
                $contacts = Contact::where('status', 1)->where('deleted_at', null)->get();
            }else{
                $contacts = Contact::whereIn('id', $contact_id)->get();
            }

            $server = Server::where('status', 1)->first();
            if ($server) {
                foreach ($contacts as $contact) {
                    $new_message = Message::create([
                        'user_id' => Auth::user()->id,
                        'contact_id' => $contact->id,
                        'text' => $request->message,
                        'image' => $image
                    ]);

                    $message = Message::find($new_message->id);
                    ProcessSendMessage::dispatch($message);
                }
            }else {
                return redirect()->route('sender.index')->with(['message' => 'No hay servidores activos', 'alert-type' => 'error']);
            }

            return redirect()->route('sender.index')->with(['message' => 'Mensaje enviado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('sender.index')->with(['message' => 'Ocurrió un error en el servidor', 'alert-type' => 'error']);
        }
    }
}
