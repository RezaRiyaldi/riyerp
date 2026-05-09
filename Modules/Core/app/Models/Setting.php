<?php

namespace Modules\Core\Models;

use App\Base\BaseModel;
use App\Traits\HasTenant;
use Illuminate\Support\Facades\Cache;
use Override;

class Setting extends BaseModel
{
    use HasTenant;


    protected $fillable = [
        'tenant_id',
        'company_id',
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_public',
        'created_by',
        'updated_by',
    ];

    public function casts(): array {
        return [
            ...parent::casts(),
            'is_public' => 'boolean',
        ];
    }

    public function getTypeValueAttribute() : mixed {
        return match ($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            'encrypted' => decrypt($this->value),
            default => $this->value,
        };
    }

    public static function get(string $group, string $key, mixed $default = null, ?string $tenantId = null) : mixed {
        $cacheKey = "setting:{$tenantId}:{$group}:{$key}";

        return Cache::remember($cacheKey, now()->addHours(), function () use ($group, $key, $tenantId, $default) {
            $query = self::where('group', $group)->where('key', $key);

            if ($tenantId) {
                $query->where('tenant_id', $tenantId);
            }

            $setting = $query->first();
            return $setting ? $setting->type_value : $default;
        });
    }

    protected static function booted(): void
    {
        static::saved(function (self $setting) {
            Cache::forget("setting:{$setting->tenant_id}:{$setting->group}:{$setting->key}");
        });
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}