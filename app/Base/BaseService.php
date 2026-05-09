<?php

namespace App\Base;

use App\Contracts\RepositoryInterface;
use App\Contracts\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements ServiceInterface
{
    public function __construct(protected RepositoryInterface $repository) {}

    public function getAll(array $filters = []): Collection {
        return $this->repository->all();
    }

    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator {
        return $this->repository->paginate($perPage);
    }

    public function getById(int|string $id): ?Model {
        return $this->repository->findById($id);
    }

    public function create(array $data): Model {
        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data): Model {
        return $this->repository->update($id, $data);
    }

    public function delete(int|string $id): bool {
        return $this->repository->delete($id);
    }
}