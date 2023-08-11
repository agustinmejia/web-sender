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
use App\Models\Server;
use App\Models\Message;

class ProcessSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The message instance.
     *
     * @var \App\Models\Message
     */
    protected $message;

    /**
     * Create a new job instance.
     * @param \App\Models\Message $message
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener servidor en línea
        $server = Server::where('status', 1)->first();
        if ($server) {
            // Verificar si el servidor en verdad está en línea
            $response = Http::get($server->url.'/status');
            if($response->ok()){
                $res = json_decode($response->body());
                if(isset($res->success)){
                    if($res->status == 1){
                        
                        // Si está en línea
                        $phone = strlen($this->message->contact->phone) == 8 ? '591'.$this->message->contact->phone : $this->message->contact->phone;
                        Http::post($server->url.'/send', [
                            'phone' => $phone,
                            'text' => $this->message->text,
                            'image_url' => $this->message->image ? url('storage/'.$this->message->image) : '',
                        ]);

                        // Update message
                        $message = Message::find($this->message->id);
                        $message->server_id = $server->id;
                        $message->status = 'enviado';
                        $message->update();
                    }
                }
            }
        }
            
    }
}
