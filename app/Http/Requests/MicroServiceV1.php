<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MicroServiceV1 extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'zendesk_ticket_id' => 'required',
        ];
    }
}
