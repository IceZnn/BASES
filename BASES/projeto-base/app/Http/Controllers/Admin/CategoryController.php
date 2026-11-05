<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Status;

class CategoryController extends CrudController
{
    protected string $modelClass = Category::class;
    protected string $resource = 'categories';
    protected string $title = 'Categoria';
    protected string $titlePlural = 'Categorias';
    protected array $countRelations = ['products'];
    protected array $searchColumns = ['name', 'description'];
    protected array $filterColumns = ['is_active' => 'Status'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:150|unique:categories,name,:id'],
        ['name' => 'products_count', 'label' => 'Produtos', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'description', 'label' => 'Descrição', 'type' => 'textarea', 'rules' => 'nullable|string|max:2000'],
        ['name' => 'is_active', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|boolean'],
    ];

    public static function statuses(): array
    {
        return Status::optionsFor('category');
    }
}
