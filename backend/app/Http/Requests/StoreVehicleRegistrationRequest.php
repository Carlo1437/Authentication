<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'address' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'registration_date' => 'required|date|max:255',
            'engine_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'document' => 'required|file|mimes:png,jpg,jpeg,pdf|max:2048',
            'status' => 'nullable|in:pending,approved,rejected',
            
        ];
    }
}
