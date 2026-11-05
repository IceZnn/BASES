<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class CrudController extends Controller
{
    protected string $modelClass;
    protected string $resource;
    protected string $title;
    protected string $titlePlural;
    protected array $fields = [];
    protected array $relations = [];
    protected array $showRelations = [];
    protected array $searchColumns = ['name'];
    protected array $searchRelations = [];
    protected array $filterColumns = [];
    protected array $countRelations = [];
    protected array $sumRelations = [];
    protected ?string $storeRequestClass = null;
    protected ?string $updateRequestClass = null;

    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'per_page' => ['nullable', 'integer', 'in:10,25,50,100'],
        ], [
            'date_from.date_format' => 'Informe uma data inicial válida.',
            'date_to.date_format' => 'Informe uma data final válida.',
            'date_to.after_or_equal' => 'A data final deve ser igual ou posterior à inicial.',
        ]);
        $query = $this->query()->with($this->relations);
        if ($this->countRelations) {
            $query->withCount($this->countRelations);
        }
        foreach ($this->sumRelations as $relation => $column) {
            $query->withSum($relation, $column);
        }

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function (Builder $builder) use ($search): void {
                foreach ($this->searchColumns as $column) {
                    $builder->orWhere($column, 'like', "%{$search}%");
                }

                foreach ($this->searchRelations as $relation => $columns) {
                    $builder->orWhereHas($relation, function (Builder $related) use ($columns, $search): void {
                        $related->where(function (Builder $nested) use ($columns, $search): void {
                            foreach ($columns as $column) {
                                $nested->orWhere($column, 'like', "%{$search}%");
                            }
                        });
                    });
                }
            });
        }

        foreach ($this->activeFilters() as $column => $label) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }

        $dateColumn = $this->dateColumn();
        if ($request->filled('date_from')) {
            $query->whereDate($dateColumn, '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate($dateColumn, '<=', $request->input('date_to'));
        }

        return view('admin.resources.index', [
            'records' => $this->paginateRecords($request, $query),
            'resource' => $this->resource,
            'title' => $this->title,
            'titlePlural' => $this->titlePlural,
            'fields' => $this->fields,
            'options' => $this->fieldOptions(),
            'filterColumns' => $this->activeFilters(),
            'sortableColumns' => $this->sortableColumns(),
            'sort' => $this->sortColumn($request),
            'direction' => $this->sortDirection($request),
            'dateColumn' => $dateColumn,
            'dateColumnLabel' => $this->dateColumnLabel(),
        ]);
    }

    public function create()
    {
        return $this->formView();
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $record = DB::transaction(function () use ($data) {
            $record = $this->createRecord($data);
            $this->syncRelations($record, $data);

            return $record;
        });

        return redirect()->route('admin.'.$this->resource.'.index')
            ->with('success', $this->title.' cadastrado(a) com sucesso.');
    }

    public function show(int $id)
    {
        $record = $this->query()
            ->with([...$this->relations, ...$this->showRelations])
            ->withCount($this->countRelations)
            ->findOrFail($id);
        foreach ($this->sumRelations as $relation => $column) {
            $record->loadSum($relation, $column);
        }

        return view('admin.resources.show', [
            'record' => $record,
            'resource' => $this->resource,
            'title' => $this->title,
            'titlePlural' => $this->titlePlural,
            'fields' => $this->fields,
            'options' => $this->fieldOptions(),
        ]);
    }

    public function edit(int $id)
    {
        return $this->formView($this->query()->with([...$this->relations, ...$this->showRelations])->findOrFail($id));
    }

    public function update(Request $request, int $id)
    {
        $record = $this->query()->findOrFail($id);
        $data = $this->validatedData($request, $record);
        DB::transaction(function () use ($record, $data): void {
            $this->updateRecord($record, $data);
            $this->syncRelations($record, $data);
        });

        return redirect()->route('admin.'.$this->resource.'.index')
            ->with('success', $this->title.' atualizado(a) com sucesso.');
    }

    public function destroy(int $id)
    {
        $record = $this->query()->findOrFail($id);
        $record->delete();
        $this->deleteUploads($record);

        return redirect()->route('admin.'.$this->resource.'.index')
            ->with('success', $this->title.' removido(a) com sucesso.');
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function filter(Request $request)
    {
        return $this->index($request);
    }

    protected function query(): Builder
    {
        return $this->modelClass::query();
    }

    protected function paginateRecords(Request $request, Builder $query)
    {
        $perPage = in_array($request->integer('per_page', 10), [10, 25, 50, 100], true)
            ? $request->integer('per_page', 10)
            : 10;

        return $query
            ->orderBy($this->sortColumn($request), $this->sortDirection($request))
            ->paginate($perPage)
            ->withQueryString();
    }

    protected function activeFilters(): array
    {
        $filters = $this->filterColumns;
        foreach ($this->fields as $field) {
            if (in_array($field['name'], ['status', 'is_active', 'role'], true)) {
                $filters[$field['name']] ??= $field['label'];
            }
        }

        return $filters;
    }

    protected function dateColumn(): string
    {
        return $this->modelClass::make()->isFillable('ordered_at') ? 'ordered_at' : 'created_at';
    }

    protected function dateColumnLabel(): string
    {
        return $this->dateColumn() === 'ordered_at' ? 'Data do pedido' : 'Data de cadastro';
    }

    protected function sortableColumns(): array
    {
        $columns = array_column(
            array_filter($this->fields, fn (array $field): bool => empty($field['display'])
                && ! in_array($field['name'], ['password', 'password_confirmation', 'image', 'photo', 'products'], true)
                && ($this->modelClass::make()->isFillable($field['name'])
                    || in_array($field['name'], ['created_at', 'updated_at'], true))),
            'name',
        );

        return array_values(array_unique([...$columns, $this->dateColumn(), 'created_at']));
    }

    protected function sortColumn(Request $request): string
    {
        $sort = $request->input('sort');

        return in_array($sort, $this->sortableColumns(), true) ? $sort : $this->dateColumn();
    }

    protected function sortDirection(Request $request): string
    {
        return $request->input('direction') === 'asc' ? 'asc' : 'desc';
    }

    protected function formView(?Model $record = null)
    {
        return view('admin.resources.form', [
            'record' => $record,
            'resource' => $this->resource,
            'title' => $this->title,
            'titlePlural' => $this->titlePlural,
            'fields' => $this->fields,
            'options' => $this->fieldOptions(),
        ]);
    }

    protected function fieldOptions(): array
    {
        $options = [];

        foreach ($this->fields as $field) {
            if (isset($field['options'])) {
                $options[$field['name']] = is_callable($field['options'])
                    ? call_user_func($field['options'])
                    : $field['options'];
            }
        }

        return $options;
    }

    protected function validatedData(Request $request, ?Model $record = null): array
    {
        $requestClass = $record ? $this->updateRequestClass : $this->storeRequestClass;
        if ($requestClass && is_subclass_of($requestClass, FormRequest::class)) {
            $formRequest = $requestClass::createFrom($request);
            $formRequest->setContainer(app())->setRedirector(app('redirect'));
            $formRequest->validateResolved();
            $data = $formRequest->validated();
        } else {
            $rules = [];
            $messages = [];

            foreach ($this->fields as $field) {
                if (isset($field['rules'])) {
                    $rules[$field['name']] = str_replace(':id', (string) ($record?->getKey() ?? 'NULL'), $field['rules']);
                }
                if (isset($field['messages'])) {
                    $messages += $field['messages'];
                }
            }

            $data = $request->validate($rules, $messages + [
                'required' => 'O campo :attribute é obrigatório.',
                'email' => 'Informe um endereço de e-mail válido.',
                'unique' => 'Este valor já está em uso.',
                'exists' => 'O registro selecionado não existe.',
                'in' => 'O valor selecionado é inválido.',
                'min' => 'O campo :attribute deve ser no mínimo :min.',
                'numeric' => 'O campo :attribute deve ser numérico.',
                'integer' => 'O campo :attribute deve ser um número inteiro.',
                'image' => 'O arquivo deve ser uma imagem.',
                'max' => 'O campo :attribute não pode exceder :max.',
            ]);
        }

        $uploadService = app(UploadService::class);

        foreach ($this->fields as $field) {
            if (($field['type'] ?? null) === 'file' && $request->hasFile($field['name'])) {
                $oldPath = $record?->getAttribute($field['name']);
                $data[$field['name']] = $uploadService->replace(
                    $request->file($field['name']),
                    $oldPath,
                    $this->resource,
                );
            }
        }

        if ($this->modelClass::make()->isFillable('slug') && isset($data['name'])) {
            $slug = Str::slug($data['name']);
            $slugQuery = $this->query()->where('slug', $slug);
            if ($record) {
                $slugQuery->where('id', '<>', $record->getKey());
            }
            $data['slug'] = $slugQuery->exists()
                ? $slug.'-'.Str::lower(Str::random(6))
                : $slug;
        }

        return $data;
    }

    protected function createRecord(array $data): Model
    {
        return $this->modelClass::create(Arr::only($data, $this->modelClass::make()->getFillable()));
    }

    protected function updateRecord(Model $record, array $data): void
    {
        $record->update(Arr::only($data, $this->modelClass::make()->getFillable()));
    }

    protected function syncRelations(Model $record, array $data): void
    {
    }

    protected function deleteUploads(Model $record): void
    {
        foreach ($this->fields as $field) {
            if (($field['type'] ?? null) === 'file' && $record->getAttribute($field['name'])) {
                app(UploadService::class)->delete($record->getAttribute($field['name']));
            }
        }
    }
}
