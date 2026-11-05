<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'sku' => ['required', 'string', 'max:80', 'unique:products,sku'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do produto.',
            'sku.required' => 'Informe o SKU.',
            'sku.unique' => 'Este SKU já está cadastrado.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'supplier_id.exists' => 'O fornecedor selecionado não existe.',
            'price.required' => 'Informe o preço.',
            'price.numeric' => 'O preço deve ser numérico.',
            'stock.integer' => 'O estoque deve ser um número inteiro.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.max' => 'A imagem não pode exceder 4 MB.',
        ];
    }
}
