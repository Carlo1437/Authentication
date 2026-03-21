<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMotorRegisterRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'plate_number' =>['required','string','max:255'],
            'expirate_date' =>['required','date'],
            'phone_number' =>['required','string','min:10','max:15'],
            'address' =>['required','string','max:255'],

        ];
    }
}
