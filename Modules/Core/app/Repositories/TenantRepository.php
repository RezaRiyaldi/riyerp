<?php 
namespace Modules\Core\Repositories;

use App\Base\BaseRepository;
use Modules\Core\Models\Tenant;

class TenantRepository extends BaseRepository
{

    public function __construct()
    {
        return parent::__construct(new Tenant());
    }
    
    public function findBySlug(string $slug) : ?Tenant {
        return $this->model->where('slug', $slug)->first();
    }

    public function findByDomain(string $domain) : ?Tenant {
        return $this->model->where('domain', $domain)->first();
    }

    public function getActive() {
        return $this->model->where('is_active', 'active')->get();
    }

}