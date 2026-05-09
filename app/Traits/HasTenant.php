<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasTenant
{
    public static function bootHasTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = self::resolveTenantId();
            if ($tenantId) {
                $builder->where('tenant_id', $tenantId);
            }
        });

        static::creating(function ($model) {
            if (empty($model->tenant_id)) {
                $model->tenant_id = self::resolveTenantId();
            }
        });
    }

    protected static function resolveTenantId(): ?string
    {
        if (app()->bound('current.tenant')) {
            return app('current.tenant')?->id;
        }

        // Fallback ke session kalau tidak ada binding (misal saat seeder/console)
        if (app()->runningInConsole()) {
            return null;
        }

        return session('tenant_id');
    }

    public function tenant()
    {
        return $this->belongsTo(\Modules\Core\Models\Tenant::class);
    }

    public function scopeWithoutTenant(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}