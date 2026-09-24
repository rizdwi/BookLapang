<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'lapangan_id' => ['required', 'exists:lapangan,id'],
            'jadwal_slot_id' => ['nullable', 'exists:jadwal_slots,id'],
            'jadwal_slot_ids' => ['nullable', 'array', 'min:1'],
            'jadwal_slot_ids.*' => ['exists:jadwal_slots,id'],
            'metode_pembayaran' => ['nullable', 'string', 'in:transfer_bca,transfer_mandiri,qris,cash'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'lapangan_id.required' => 'Lapangan harus dipilih.',
            'lapangan_id.exists' => 'Lapangan tidak ditemukan.',
            'jadwal_slot_ids.min' => 'Pilih minimal satu slot jadwal.',
        ];
    }
}
