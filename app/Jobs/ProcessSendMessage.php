<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

// Models
use App\Models\ContactMessage;

class ProcessSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact_message;

    public function __construct(ContactMessage $contact_message)
    {
        $this->contact_message = $contact_message->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Verificar si el servidor en verdad está en línea
        $response = Http::get($this->contact_message->server->url.'/status?id='.$this->contact_message->server->slug);
        if($response->ok()){
            $res = json_decode($response->body());
            if(isset($res->success)){
                if($res->status == 1){
                    
                    // Si está en línea
                    $phone = strlen($this->contact_message->contact->phone) == 8 ? '591'.$this->contact_message->contact->phone : $this->contact_message->contact->phone;
                    Http::post($this->contact_message->server->url.'/send?id='.$this->contact_message->server->slug, [
                        'phone' => $phone,
                        'text' => $this->contact_message->message->text,
                        'image_url' => $this->contact_message->message->image ? url('storage/'.$this->contact_message->message->image) : '',
                    ]);

                    // Update message
                    $contact_message = ContactMessage::find($this->contact_message->id);
                    $contact_message->status = 'enviado';
                    $contact_message->update();
                }
            }
        }
            
    }
}
