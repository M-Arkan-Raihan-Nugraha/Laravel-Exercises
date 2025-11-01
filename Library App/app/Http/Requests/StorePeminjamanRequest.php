<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
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
            'id_anggota' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id_anggota.required' => 'Anggota tidak boleh kosong.',
            'tanggal_pinjam.required' => 'Tanggal pinjam tidak boleh kosong.',
            'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong.',
            'status.required' => 'Status tidak boleh kosong.',
        ];
    }


}
