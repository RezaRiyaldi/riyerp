<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    
    public function findById(int|string $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;
    
    public function findByField(string $field, mixed $value, array $columns = ['*']): Collection;
    
    public function create(array $data): Model;
    
    public function update(int|string $id, array $data): Model;
    
    public function delete(int|string $id): bool;
    
    public function restore(int|string $id): bool;
    
    public function forceDelete(int|string $id): bool;
}