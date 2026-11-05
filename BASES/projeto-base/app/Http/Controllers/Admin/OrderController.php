<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;

class OrderController extends CrudController
{
    protected string $modelClass = Order::class;
    protected string $resource = 'orders';
    protected string $title = 'Pedido';
    protected string $titlePlural = 'Pedidos';
    protected array $searchColumns = ['id', 'status', 'notes'];
    protected array $searchRelations = ['client' => ['name', 'email']];
    protected array $filterColumns = ['status' => 'Status'];
    protected ?string $storeRequestClass = StoreOrderRequest::class;
    protected array $relations = ['client', 'user', 'products'];
    protected array $fields = [
        ['name' => 'id', 'label' => 'Pedido', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'client_id', 'label' => 'Cliente', 'type' => 'select', 'display' => 'client.name', 'options' => [self::class, 'clients'], 'rules' => 'required|exists:clients,id'],
        ['name' => 'user.name', 'label' => 'Responsável', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:pending,processing,completed,cancelled'],
        ['name' => 'total', 'label' => 'Total', 'type' => 'computed', 'readOnly' => true],
        ['name' => 'products', 'label' => 'Produtos', 'type' => 'select', 'multiple' => true, 'options' => [self::class, 'products'], 'rules' => 'required|array|min:1', 'messages' => ['products.required' => 'Adicione ao menos um produto ao pedido.']],
        ['name' => 'notes', 'label' => 'Observações', 'type' => 'textarea', 'rules' => 'nullable|string|max:2000'],
    ];

    public static function clients(): array
    {
        return Client::query()->orderBy('name')->pluck('name', 'id')->all();
    }

    public static function products(): array
    {
        return Product::query()->where('status', 'active')->orderBy('name')->pluck('name', 'id')->all();
    }

    public static function statuses(): array
    {
        return Status::optionsFor('order');
    }

    protected function syncRelations(Model $record, array $data): void
    {
        if (! $record->user_id && auth()->check()) {
            $record->user()->associate(auth()->user())->save();
        }

        if (! array_key_exists('products', $data)) {
            return;
        }

        app(OrderService::class)->syncProducts($record, $data['products']);
    }
}
