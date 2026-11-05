<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use App\Models\Status;

class SupplierController extends CrudController
{
    protected string $modelClass = Supplier::class;
    protected string $resource = 'suppliers';
    protected string $title = 'Fornecedor';
    protected string $titlePlural = 'Fornecedores';
    protected array $countRelations = ['products'];
    protected array $searchColumns = ['name', 'email', 'company'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:200'],
        ['name' => 'products_count', 'label' => 'Produtos', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'company', 'label' => 'Empresa', 'type' => 'text', 'rules' => 'nullable|string|max:200'],
        ['name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'rules' => 'nullable|email|max:255|unique:suppliers,email,:id'],
        ['name' => 'phone', 'label' => 'Telefone', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function statuses(): array
    {
        return Status::optionsFor('supplier');
    }
}
