<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Status;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;

class ProductController extends CrudController
{
    protected string $modelClass = Product::class;
    protected string $resource = 'products';
    protected string $title = 'Produto';
    protected string $titlePlural = 'Produtos';
    protected ?string $storeRequestClass = StoreProductRequest::class;
    protected ?string $updateRequestClass = UpdateProductRequest::class;
    protected array $relations = ['category', 'supplier'];
    protected array $searchColumns = ['name', 'sku'];
    protected array $filterColumns = ['category_id' => 'Categoria', 'status' => 'Status'];
    protected array $fields = [
        ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'rules' => 'required|string|max:200'],
        ['name' => 'sku', 'label' => 'SKU', 'type' => 'text', 'rules' => 'required|string|max:80|unique:products,sku,:id'],
        ['name' => 'category_id', 'label' => 'Categoria', 'type' => 'select', 'display' => 'category.name', 'options' => [self::class, 'categories'], 'rules' => 'nullable|exists:categories,id'],
        ['name' => 'supplier_id', 'label' => 'Fornecedor', 'type' => 'select', 'display' => 'supplier.name', 'options' => [self::class, 'suppliers'], 'rules' => 'nullable|exists:suppliers,id'],
        ['name' => 'description', 'label' => 'Descrição', 'type' => 'textarea', 'rules' => 'nullable|string|max:3000'],
        ['name' => 'price', 'label' => 'Preço', 'type' => 'number', 'step' => '0.01', 'rules' => 'required|numeric|min:0'],
        ['name' => 'stock', 'label' => 'Estoque', 'type' => 'number', 'rules' => 'required|integer|min:0'],
        ['name' => 'image', 'label' => 'Imagem', 'type' => 'file', 'rules' => 'nullable|image|max:4096'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [self::class, 'statuses'], 'rules' => 'required|in:active,inactive'],
    ];

    public static function categories(): array
    {
        return Category::query()->orderBy('name')->pluck('name', 'id')->all();
    }

    public static function suppliers(): array
    {
        return Supplier::query()->orderBy('name')->pluck('name', 'id')->all();
    }

    public static function statuses(): array
    {
        return Status::optionsFor('product');
    }

    protected function createRecord(array $data): Model
    {
        return app(ProductService::class)->create($data);
    }

    protected function updateRecord(Model $record, array $data): void
    {
        app(ProductService::class)->update($record, $data);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->orders()->exists()) {
            return back()->withErrors(['delete' => 'Este produto já pertence a um pedido e não pode ser excluído.']);
        }

        return parent::destroy($id);
    }
}
