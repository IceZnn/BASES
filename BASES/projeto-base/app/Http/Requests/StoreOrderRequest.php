<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'products' => ['required', 'array', 'min:1'],
            'products.*' => ['required', 'integer', 'exists:products,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'Selecione um cliente.',
            'client_id.exists' => 'O cliente selecionado não existe.',
            'products.required' => 'Adicione ao menos um produto ao pedido.',
            'products.*.exists' => 'Um dos produtos selecionados não existe.',
        ];
    }
}
