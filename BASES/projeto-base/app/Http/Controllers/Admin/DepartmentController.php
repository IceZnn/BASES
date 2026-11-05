<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Status;

class DepartmentController extends CrudController
{
    protected string $modelClass = Department::class;
    protected string $resource = 'departments';
    protected string $title = 'Departamento';
    protected string $titlePlural = 'Departamentos';
    protected array $countRelations = ['employees'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:150|unique:departments,name,:id'],
        ['name' => 'employees_count', 'label' => 'Funcionários', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'description', 'label' => 'Descrição', 'type' => 'textarea', 'rules' => 'nullable|string|max:2000'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function statuses(): array
    {
        return Status::optionsFor('department');
    }
}
