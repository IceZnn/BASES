<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Status;

class EmployeeController extends CrudController
{
    protected string $modelClass = Employee::class;
    protected string $resource = 'employees';
    protected string $title = 'Funcionário';
    protected string $titlePlural = 'Funcionários';
    protected array $relations = ['department'];
    protected array $searchColumns = ['name', 'email'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:200'],
        ['name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'rules' => 'required|email|max:255|unique:employees,email,:id'],
        ['name' => 'phone', 'label' => 'Telefone', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
        ['name' => 'position', 'label' => 'Cargo', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
        ['name' => 'department_id', 'label' => 'Departamento', 'type' => 'select', 'display' => 'department.name', 'options' => [self::class, 'departments'], 'rules' => 'nullable|exists:departments,id'],
        ['name' => 'hired_at', 'label' => 'Data de admissão', 'type' => 'date', 'rules' => 'nullable|date'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function departments(): array
    {
        return Department::query()->orderBy('name')->pluck('name', 'id')->all();
    }

    public static function statuses(): array
    {
        return Status::optionsFor('employee');
    }
}
