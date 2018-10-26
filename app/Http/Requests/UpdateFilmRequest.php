<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFilmRequest extends FormRequest
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
            'name'          =>  'filled|max:512',
            'description'   =>  'filled',
            'release_date'  =>  'filled|date',
            'rating'        =>  'filled|between:1,5',
            'ticket_price'  =>  'filled|numeric',
            'country'       =>  'filled|max:255',
            'photo'         =>  'filled|url',
        ];
    }
}
