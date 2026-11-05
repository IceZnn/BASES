<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Models\Status;

class ClientController extends CrudController
{
    protected string $modelClass = Client::class;
    protected string $resource = 'clients';
    protected string $title = 'Cliente';
    protected string $titlePlural = 'Clientes';
    protected array $showRelations = ['orders'];
    protected array $countRelations = ['orders'];
    protected array $sumRelations = ['orders' => 'total'];
    protected ?string $storeRequestClass = StoreClientRequest::class;
    protected array $searchColumns = ['name', 'email', 'document'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:200'],
        ['name' => 'orders_count', 'label' => 'Pedidos', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'orders_sum_total', 'label' => 'Total em pedidos', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'email', 'label' => 'E-mail', 'type' => 'email', 'rules' => 'nullable|email|max:255|unique:clients,email,:id'],
        ['name' => 'phone', 'label' => 'Telefone', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
        ['name' => 'document', 'label' => 'Documento', 'type' => 'text', 'rules' => 'nullable|string|max:30|unique:clients,document,:id'],
        ['name' => 'address', 'label' => 'Endereço', 'type' => 'textarea', 'rules' => 'nullable|string|max:1000'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function statuses(): array
    {
        return Status::optionsFor('client');
    }

    public function destroy(int $id)
    {
        $client = Client::findOrFail($id);
        if ($client->orders()->exists()) {
            return back()->withErrors(['delete' => 'Este cliente possui pedidos e não pode ser excluído.']);
        }

        return parent::destroy($id);
    }
}
