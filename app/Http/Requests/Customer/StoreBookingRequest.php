<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_id'     => 'required|integer|exists:rooms,id',
            'start_date'  => 'required|date_format:Y-m-d',
            'end_date'    => 'required|date_format:Y-m-d|after:start_date',
            'guest_count' => 'required|integer|min:1|max:10',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'room_id.required'        => 'Please select a room.',
            'room_id.integer'         => 'Invalid room ID.',
            'room_id.exists'          => 'The selected room does not exist.',
            'start_date.required'     => 'Check-in date is required.',
            'start_date.date_format'  => 'Check-in date must be in YYYY-MM-DD format.',
            'end_date.required'       => 'Check-out date is required.',
            'end_date.date_format'    => 'Check-out date must be in YYYY-MM-DD format.',
            'end_date.after'          => 'Check-out date must be after check-in date.',
            'guest_count.required'    => 'Number of guests is required.',
            'guest_count.integer'     => 'Number of guests must be a whole number.',
            'guest_count.min'         => 'At least 1 guest is required.',
            'guest_count.max'         => 'Maximum 10 guests allowed.',
        ];
    }
}
