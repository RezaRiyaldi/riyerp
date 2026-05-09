<?php

namespace Modules\Core\Models;

use App\Base\BaseModel;

class Branch extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'company_id',
        'name',
        'code',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'is_headquarter',
        'is_default',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function casts(): array {
        return [
            ...parent::casts(),
            'is_headquarter' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
