<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
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
            'kode_buku' => 'required|unique:Buku,kode_buku',
            'id_kategori' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'kode_buku.unique' => 'Kode buku sudah terdaftar, silahkan gunakan kode lain.',
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'judul.required' => 'Judul buku tidak boleh kosong.',
        ];
    }

}
