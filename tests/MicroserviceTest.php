<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Ticket;

class MicroserviceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateTicket()
    {
        $this->post('v1/tickets', [
                'body'      => '',
                'name'      => '',
                'email'     => '',
                'subject'   => ''
            ])->seeJson([
                'body'      => ['The body field is required.'],
                'name'      => ['The name field is required.'],
                'email'     => ['The email field is required.'],
                'subject'   => ['The subject field is required.']
            ]); //check ALL required fields

        $this->assertEquals(200, $this->call('post', 'v1/tickets/', factory(Ticket::class)->make()->toarray())->status());     //add ticket
        
        Zendesk::ticket(Ticket::orderBy('id', 'desc')->first()->zendesk_ticket_id)->delete();   //delete from Zendesk


    }

    public function testDeleteTicket()
    {
        $this->assertEquals(200, $this->call('post', 'v1/tickets/', factory(Ticket::class)->make()->toarray())->status());     //add ticket
        
        $ticket = Ticket::orderBy('id', 'desc')->first();
        $ticketId = $ticket->id;
        $zendeskTicketId = $ticket->zendesk_ticket_id;
        

        $this->assertEquals(200, $this->call('delete', 'v1/tickets/'.$ticketId)->status());     //find and delete
        $updatedTicketStatus = 404;

        if (Zendesk::tickets($zendeskTicketId)->find()->ticket->status == "solved") {
            $updatedTicketStatus = 200;
        }
        $this->assertEquals(200,$updatedTicketStatus);
        
        Zendesk::ticket($zendeskTicketId)->delete();    //delete ticket after 
        
        $this->assertEquals(404, $this->call('delete', 'v1/tickets/'.$ticketId)->status());     //find deleted one 

    }

    public function testIndividualTicket()
    {
        $ticketId = factory(Ticket::class)->create()->id;   //create new ticket
    
        $this->assertEquals(200, $this->call('get', 'v1/tickets/'.$ticketId)->status());    //find created ticket

        Ticket::destroy($ticketId); //delet created ticket                                                         
        
        $this->assertEquals(404, $this->call('get', 'v1/tickets/'.$ticketId)->status());    //find deleted one 
    }

    public function testStatisticTicket()
    {
        $this->assertEquals(200, $this->call('get', 'v1/statistic/')->status());    //find and delete

    }

}
