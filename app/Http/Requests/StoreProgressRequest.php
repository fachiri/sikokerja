<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'required',
            'jtm' => 'required',
            'jtr' => 'required',
            'gardu' => 'required',
            'dokumentasi' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'Pilih paket',
            'jtm.required' => 'JTM harus diisi',
            'jtr.required' => 'JTR harus diisi',
            'gardu.required' => 'Gardu harus diisi',
            'dokumentasi.required' => 'Dokumentasi harus diisi',
        ];
    }
}
