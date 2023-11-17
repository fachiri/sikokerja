<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgresRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'progres' => 'required|numeric|between:0,100',
            'dokumentasi' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'progres.required' => 'Kolom progres wajib diisi.',
            'progres.numeric' => 'Kolom progres harus berupa angka.',
            'progres.between' => 'Kolom progres harus di antara :min dan :max.',
        ];
    }
}
