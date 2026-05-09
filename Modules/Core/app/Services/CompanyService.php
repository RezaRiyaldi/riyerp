<?php

namespace Modules\Core\Services;

use App\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\Company;
use Modules\Core\Repositories\CompanyRepository;

class CompanyService extends BaseService
{
    public function __construct(CompanyRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            // Kalau is_default true, unset default company lain di tenant yang sama
            if (!empty($data['is_default'])) {
                $this->repository->model
                    ->where('tenant_id', $data['tenant_id'])
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
            return $this->repository->create($data);
        });
    }
}