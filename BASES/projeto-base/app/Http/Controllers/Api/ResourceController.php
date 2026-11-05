<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\OrderService;

class ResourceController extends Controller
{
    private const RESOURCES = [
        'users' => [User::class, ['profile', 'roleDefinition'], ['name' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email', 'phone' => 'nullable|string|max:30', 'role' => 'required|exists:roles,name', 'status' => 'required|in:active,inactive', 'password' => 'required|string|min:8']],
        'products' => [Product::class, ['category', 'supplier'], ['name' => 'required|string|max:200', 'sku' => 'required|string|max:80|unique:products,sku', 'category_id' => 'nullable|exists:categories,id', 'supplier_id' => 'nullable|exists:suppliers,id', 'description' => 'nullable|string', 'price' => 'required|numeric|min:0', 'stock' => 'required|integer|min:0', 'status' => 'required|in:active,inactive']],
        'categories' => [Category::class, ['products'], ['name' => 'required|string|max:150|unique:categories,name', 'description' => 'nullable|string', 'is_active' => 'required|boolean']],
        'clients' => [Client::class, ['orders'], ['name' => 'required|string|max:200', 'email' => 'nullable|email|unique:clients,email', 'phone' => 'nullable|string|max:30', 'document' => 'nullable|string|max:30|unique:clients,document', 'address' => 'nullable|string', 'status' => 'required|in:active,inactive']],
        'suppliers' => [Supplier::class, ['products'], ['name' => 'required|string|max:200', 'email' => 'nullable|email|unique:suppliers,email', 'phone' => 'nullable|string|max:30', 'company' => 'nullable|string|max:200', 'status' => 'required|in:active,inactive']],
        'employees' => [Employee::class, ['department'], ['department_id' => 'nullable|exists:departments,id', 'name' => 'required|string|max:200', 'email' => 'required|email|unique:employees,email', 'phone' => 'nullable|string|max:30', 'position' => 'nullable|string|max:150', 'hired_at' => 'nullable|date', 'status' => 'required|in:active,inactive']],
        'departments' => [Department::class, ['employees'], ['name' => 'required|string|max:150|unique:departments,name', 'description' => 'nullable|string', 'status' => 'required|in:active,inactive']],
        'orders' => [Order::class, ['client', 'user', 'products'], ['client_id' => 'required|exists:clients,id', 'status' => 'required|in:pending,processing,completed,cancelled', 'notes' => 'nullable|string|max:2000', 'products' => 'required|array|min:1', 'products.*' => 'required|integer|exists:products,id']],
    ];

    public function index(Request $request, string $resource)
    {
        [$model, $relations] = $this->configuration($resource);
        $records = $model::with($relations)->latest()->paginate(15);

        return response()->json([
            'data' => $records->items(),
            'meta' => ['current_page' => $records->currentPage(), 'last_page' => $records->lastPage(), 'total' => $records->total()],
        ]);
    }

    public function show(string $resource, int $id)
    {
        [$model, $relations] = $this->configuration($resource);

        return response()->json(['data' => $model::with($relations)->findOrFail($id)]);
    }

    public function store(Request $request, string $resource)
    {
        [$model, , $rules] = $this->configuration($resource);
        $data = $request->validate($rules);

        return $this->save($model, $data, $request);
    }

    public function update(Request $request, string $resource, int $id)
    {
        [$model, , $rules] = $this->configuration($resource);
        $record = $model::findOrFail($id);
        $data = $request->validate(array_map(function (string $rule) use ($id): string {
            $rule = preg_replace('/(^|\|)required(?=\||$)/', '$1sometimes', $rule);

            return preg_replace_callback(
                '/unique:([a-z_]+),([a-z_]+)/',
                fn (array $matches) => 'unique:'.$matches[1].','.$matches[2].','.$id,
                $rule,
            );
        }, $rules));

        return $this->save($model, $data, $request, $record);
    }

    public function destroy(string $resource, int $id)
    {
        [$model] = $this->configuration($resource);
        $model::findOrFail($id)->delete();

        return response()->json(['data' => null, 'message' => 'Registro removido com sucesso.']);
    }

    private function save(string $model, array $data, Request $request, ?Model $record = null)
    {
        $productIds = $model === Order::class ? ($data['products'] ?? null) : null;
        unset($data['products']);

        if ($model === User::class && isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if (in_array('slug', (new $model)->getFillable(), true) && isset($data['name'])) {
            $slug = Str::slug($data['name']);
            $slugQuery = $model::where('slug', $slug);
            if ($record) {
                $slugQuery->where('id', '<>', $record->getKey());
            }
            $data['slug'] = $slugQuery->exists() ? $slug.'-'.Str::lower(Str::random(6)) : $slug;
        }
        if ($model === Order::class && ! $record) {
            $data['user_id'] = $request->user()->id;
        }

        $record ? $record->update($data) : $record = $model::create($data);
        if ($model === Order::class && $productIds) {
            app(OrderService::class)->syncProducts($record, $productIds);
        }

        $relations = $model === Order::class ? ['client', 'user', 'products'] : [];

        return response()->json(['data' => $record->fresh($relations), 'message' => 'Registro salvo com sucesso.'], $record->wasRecentlyCreated ? 201 : 200);
    }

    private function configuration(string $resource): array
    {
        abort_unless(array_key_exists($resource, self::RESOURCES), 404);

        return self::RESOURCES[$resource];
    }
}
