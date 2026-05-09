<?php

namespace Modules\Core\Models;

use App\Base\BaseModel;

class Tenant extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'email',
        'phone',
        'logo',
        'settings',
        'status',
        'trial_ends_at',
        'subscription_until',
    ];

    protected function casts(): array {
        return [
            ...parent::casts(),
            'settings' => 'array',
            'trial_ends_at' => 'datetime',
            'subscription_until' => 'datetime',
        ];
    }

    public function companies() {
        return $this->hasMany(Company::class);
    }

    public function branches() {
        return $this->hasMany(Branch::class);
    }

    public function settings() {
        return $this->hasMany(Setting::class);
    }

    public function isActive(): bool {
        return $this->status === 'active';
    }

    public function isSuspended() : bool {
        return $this->status === 'suspended';
    }
}