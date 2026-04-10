<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRegistrationRequest extends FormRequest
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
            'full_name' => 'sometimes|required|string|max:255',
            'email_address' => 'sometimes|required|email|max:255',
            'phone_number' => 'sometimes|required|numeric|digits_between:10,15',
            'address' => 'sometimes|required|string|max:255',
            'vehicle_type' => 'sometimes|required|string|max:255',
            'plate_number' => 'sometimes|required|string|max:255',
            'registration_date' => 'sometimes|required|date|max:255',
            'engine_number' => 'sometimes|required|string|max:255',
            'chassis_number' => 'sometimes|required|string|max:255',
            'document' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
            'status' => 'nullable|in:pending,approved',
        ];
    }
}
