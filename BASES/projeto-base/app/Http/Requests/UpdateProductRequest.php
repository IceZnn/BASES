<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product') ?? $this->route('id');

        return [
            'name' => ['required', 'string', 'max:200'],
            'sku' => ['required', 'string', 'max:80', Rule::unique('products')->ignore($product)],
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
            'stock.integer' => 'O estoque deve ser um número inteiro.',
            'image.image' => 'O arquivo deve ser uma imagem.',
        ];
    }
}
