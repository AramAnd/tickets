<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Zendesk;
use App\Ticket;


class ZendeskTicketCreate extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ticket;

    public function __construct($id)
    {
        $this->ticket = Ticket::find($id);
    } 

    public function handle()
    {
        $zendesk = Zendesk::tickets()->create(array('subject' => $this->ticket->subject,'comment' => array('body' => $this->ticket->body),'priority' => 'normal'));

        $this->ticket->zendesk_ticket_id = $zendesk->ticket->id;

        $this->ticket->save();


    }
}
