<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Http\Requests\UpdateUserRequest;

class UserController extends CrudController
{
    protected string $modelClass = User::class;
    protected string $resource = 'users';
    protected string $title = 'Usuário';
    protected string $titlePlural = 'Usuários';
    protected array $showRelations = ['profile'];
    protected ?string $updateRequestClass = UpdateUserRequest::class;
    protected array $searchColumns = ['name', 'email'];
    protected array $filterColumns = ['role' => 'Cargo', 'status' => 'Status'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:255'],
        ['name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'rules' => 'required|email|max:255|unique:users,email,:id'],
        ['name' => 'password', 'label' => 'Senha', 'type' => 'password', 'required' => true, 'rules' => 'nullable|string|min:8'],
        ['name' => 'password_confirmation', 'label' => 'Confirme a senha', 'type' => 'password', 'required' => true, 'rules' => 'nullable|string'],
        ['name' => 'phone', 'label' => 'Telefone', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
        ['name' => 'profile.bio', 'label' => 'Sobre', 'type' => 'computed', 'readOnly' => true, 'list' => false],
        ['name' => 'photo', 'label' => 'Foto', 'type' => 'file', 'rules' => 'nullable|image|max:2048'],
        ['name' => 'role', 'label' => 'Cargo', 'type' => 'select', 'options' => [self::class, 'roles'], 'rules' => 'required|in:administrator,manager,employee,client,operator'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function roles(): array
    {
        return Role::query()->orderBy('label')->pluck('label', 'name')->all();
    }

    public static function statuses(): array
    {
        return Status::optionsFor('user');
    }

    protected function validatedData(Request $request, ?Model $record = null): array
    {
        $fields = $this->fields;
        foreach ($fields as &$field) {
            if ($field['name'] === 'password') {
                $field['rules'] = $record ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed';
            }
            if ($field['name'] === 'email') {
                $field['rules'] = 'required|email|max:255|unique:users,email,'.($record?->id ?? 'NULL');
            }
            if ($field['name'] === 'role') {
                $field['rules'] = 'required|exists:roles,name';
            }
        }
        unset($field);
        $this->fields = $fields;

        $data = parent::validatedData($request, $record);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } elseif (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['photo']) && ! $request->hasFile('photo')) {
            unset($data['photo']);
        }

        return Arr::only($data, $this->modelClass::make()->getFillable());
    }

    protected function createRecord(array $data): Model
    {
        return app(UserService::class)->create($data);
    }

    protected function updateRecord(Model $record, array $data): void
    {
        app(UserService::class)->update($record, $data);
    }

    public function destroy(int $id)
    {
        if ((int) auth()->id() === $id) {
            return back()->withErrors(['delete' => 'Não é possível excluir a própria conta enquanto ela está em uso.']);
        }

        return parent::destroy($id);
    }
}
