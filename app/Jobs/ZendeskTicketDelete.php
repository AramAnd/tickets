<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Zendesk;

class ZendeskTicketDelete extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ticket;

    public function __construct($id)
    {
        $this->ticket = $id;
        
    }

    public function handle()
    {
        Zendesk::ticket(array($this->ticket))->update(array('status' => 'solved'));
    }
}
