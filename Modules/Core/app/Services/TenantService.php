<?php

namespace Modules\Core\Services;

use App\Base\BaseService;
use Illuminate\Support\Str;
use Modules\Core\Models\Tenant;
use Modules\Core\Repositories\TenantRepository;

class TenantService extends BaseService
{
    public function __construct(TenantRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Tenant
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        return parent::create($data);
    }

    public function findByDomain(string $domain): ?Tenant
    {
        return $this->repository->findByDomain($domain);
    }

    public function suspend(string $id): Tenant
    {
        return $this->update($id, ['status' => 'suspended']);
    }

    public function activate(string $id): Tenant
    {
        return $this->update($id, ['status' => 'active']);
    }
}