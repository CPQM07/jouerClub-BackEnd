<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|min:4', 
            'motto'         => 'required|min:4', 
            'branch_id'      => 'required'
        ];
    }
}
