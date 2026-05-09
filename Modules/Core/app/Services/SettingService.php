<?php

namespace Modules\Core\Services;

use App\Base\BaseService;
use Modules\Core\Models\Setting;
use Modules\Core\Repositories\SettingRepository;

class SettingService extends BaseService
{
    public function __construct(SettingRepository $repository)
    {
        parent::__construct($repository);
    }

    public function set(string $group, string $key, mixed $value, ?string $tenantId = null): Setting
    {
        return $this->repository->updateOrCreate($group, $key, $value, $tenantId);
    }

    public function get(string $group, string $key, mixed $default = null, ?string $tenantId = null): mixed
    {
        return Setting::get($group, $key, $default, $tenantId);
    }

    public function getGroup(string $group, ?string $tenantId = null)
    {
        return $this->repository->getByGroup($group, $tenantId);
    }
}