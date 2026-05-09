<?php
namespace App\Base;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface 
{
    public function __construct(protected Model $model) {}

    public function all(array $columns = ['*'], array $relations = []): Collection {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator {
        return $this->model->paginate($perPage, $columns);
    }

    public function findById(int|string $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model {
        return $this->model->select($columns)
            ->with($relations)
            ->findOrFail($id)
            ->append($appends);
    }

    public function findByField(string $field, mixed $value, array $columns = ['*']): Collection {
        return $this->model->select($columns)->where($field, $value)->get($columns);
    }

    public function create(array $data): Model {
        return $this->model->create($data);
    }

    public function update(int|string $id, array $data): Model {
        $model = $this->findById($id);
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int|string $id): bool {
        $model = $this->findById($id);
        return $model->delete();
    }

    public function restore(int|string $id): bool {
        $model = $this->model->withTrashed()->findOrFail($id);
        return $model->restore();
    }

    public function forceDelete(int|string $id): bool {
        $model = $this->model->withTrashed()->findOrFail($id);
        return $model->forceDelete();
    }
}