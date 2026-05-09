<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceInterface
{
    public function getAll(array $filters = []): Collection;
    
    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    
    public function getById(int|string $id): ?Model;
    
    public function create(array $data): Model;
    
    public function update(int|string $id, array $data): Model;
    
    public function delete(int|string $id): bool;
}