<?php 

namespace Modules\Core\Repositories;

use App\Base\BaseRepository;
use Modules\Core\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct()
    {
        return parent::__construct(new Setting());
    }

    public function getByGroup(string $group, ?string $tenantId = null)
    {
        return $this->model->where('group', $group)
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->first();
    }

    public function updateOrCreate(string $group, string $key, mixed $value, ?string $tenantId = null) : Setting 
    {
        return $this->model->updateOrCreate(
            [
                'tenant_id' => $tenantId,
                'group' => $group,
                'key' => $key,
            ],
            [
                'value' => $value,
            ]
        );    
    }
}