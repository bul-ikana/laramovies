<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFilmRequest extends FormRequest
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
            'name'          =>  'required|max:512',
            'description'   =>  'required',
            'release_date'  =>  'required|date',
            'rating'        =>  'required|between:1,5',
            'ticket_price'  =>  'required|numeric',
            'country'       =>  'required|max:255',
            'photo'         =>  'required|url',
        ];
    }
}
