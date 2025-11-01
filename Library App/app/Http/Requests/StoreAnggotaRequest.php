<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnggotaRequest extends FormRequest
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
            'nama' => 'required',
            'jk' => 'required',
            'alamat' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama anggota tidak boleh kosong.',
            'jk.required' => 'Jenis tidak boleh kosong.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
        ];
    }


}
