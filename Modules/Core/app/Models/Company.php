<?php

namespace Modules\Core\Models;

use App\Base\BaseModel;

class Company extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'name',
        'legal_name',
        'tax_id',
        'business_id',
        'email',
        'phone',
        'website',
        'logo',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'currency',
        'timezone',
        'is_default',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function casts(): array {
        return [
            ...parent::casts(),
            'is_default' => 'boolean',
        ];
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function branches() {
        return $this->hasMany(Branch::class);
    }

    public function settings() {
        return $this->hasMany(Setting::class);
    }
}