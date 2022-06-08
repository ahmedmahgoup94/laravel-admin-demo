<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    public function allTrashed(): Collection;
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): Model;
    public function findTrashedById(int $modelId): Model;
    public function findOnlyTrashedById(int $modelId): Model;
    public function create(array $payLoad): Model;
    public function update(int $modelId, array $payLoad): Model;
    public function deleteById(int $modelId): Model;
    public function restoreById(int $modelId): Model;
    public function permanentlyDeleteById(int $modelId): bool;
}
