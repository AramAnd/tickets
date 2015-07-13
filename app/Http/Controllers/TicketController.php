<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Ticket;
use App\Http\Controllers\Controller;
use App\Jobs\ZendeskTicketCreate;
use App\Jobs\ZendeskTicketDelete;
use Zendesk;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        return response(Ticket::paginate(50), 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ]);


        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }else{
            $this->dispatch(new ZendeskTicketCreate(Ticket::create($request->all())->id));
            return response(['created' => true], 200);
        }

    }

    public function delete($id)
    {
        if ($ticket = Ticket::find($id)) {
            
            $this->dispatch(new ZendeskTicketDelete($ticket->zendesk_ticket_id));
            
            $ticket->delete();

            return response(['deleted' => true], 200);

        }else{
            return response(['messagen' => 'not fount'], 404);
        }
    }

    public function getIndividual($id)
    {
        if ($ticket = Ticket::find($id)) {
            return response($ticket, 200);
        }else{
            return response(['messagen' => 'not fount'], 404);
        }
    }

    public function getStatistic()
    {
        return response(['open' => Ticket::count(), 'total' => Ticket::withTrashed()->count()], 200);
    }
}