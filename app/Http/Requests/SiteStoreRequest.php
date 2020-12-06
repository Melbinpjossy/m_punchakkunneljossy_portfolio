<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteStoreRequest extends FormRequest
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
            'logo' => ['required', 'string'],
            'favicon' => ['required', 'string'],
            'smallText' => ['required', 'string', 'max:400'],
            'title' => ['required', 'string', 'max:400'],
            'countary' => ['required', 'string', 'max:400'],
            'phone' => ['required', 'string', 'max:400'],
            'email' => ['required', 'email', 'max:400'],
            'address' => ['required', 'string', 'max:400'],
        ];
    }
}
