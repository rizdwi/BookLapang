<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLapanganRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', Rule::in(['futsal', 'badminton', 'basket', 'voli', 'tenis'])],
            'deskripsi' => ['nullable', 'string'],
            'harga_per_jam' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'alamat' => ['nullable', 'string'],
            'aktif' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lapangan wajib diisi.',
            'tipe.required' => 'Tipe lapangan wajib diisi.',
            'tipe.in' => 'Tipe lapangan tidak valid.',
            'harga_per_jam.required' => 'Harga per jam wajib diisi.',
            'harga_per_jam.numeric' => 'Harga harus berupa angka.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
