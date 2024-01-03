<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Contact;
use App\Models\Message;
use App\Models\ContactMessage;

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


            $message = Message::create([
                'user_id' => Auth::user()->id,
                'text' => $request->message,
                'image' => $image
            ]);

            foreach ($contacts as $contact) {
                ContactMessage::create([
                    'server_id' => $request->server_id,
                    'contact_id' => $contact->id,
                    'message_id' => $message->id
                ]);
            }

            return redirect()->route('sender.index')->with(['message' => 'Mensaje registrados para envío', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('sender.index')->with(['message' => 'Ocurrió un error en el servidor', 'alert-type' => 'error']);
        }
    }
}
