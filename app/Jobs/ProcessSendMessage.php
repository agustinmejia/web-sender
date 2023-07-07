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
        $server = Server::where('status', 1)->first();
        Http::get($server->url.'?number='.$this->message->contact->phone.'&message='.$this->message->text);
        $message = Message::find($this->message->id);
        $message->status = 'enviado';
        $message->update();
    }
}
