<?php

namespace Modules\Core\Repositories;

use App\Base\BaseRepository;
use Modules\Core\Models\Company;

class CompanyRepository extends BaseRepository
{
    public function __construct()
    {
        return parent::__construct(new Company());
    }

    public function getDefault(string $tenantId) : ?Company {
        return $this->model->where('tenant_id', $tenantId)->where('is_default', true)->first();
    }
    
}