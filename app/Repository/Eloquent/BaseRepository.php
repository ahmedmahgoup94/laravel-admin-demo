<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    public function findTrashedById(int $modelId): Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    public function findOnlyTrashedById(int $modelId): Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    public function create(array $payLoad): Model
    {
        $model = $this->model->create($payLoad);

        return $model->fresh();
    }

    public function update(int $modelId, array $payLoad): Model
    {
        $model = $this->findById($modelId);

        return $model->update($payLoad);
    }

    public function deleteById(int $modelId): Model
    {
        return $this->findById($modelId)->delete();
    }

    public function restoreById(int $modelId): Model
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }
}
