<?php

namespace App\Base;

use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes, HasAudit, HasUlids;
    
    // Semua model ERP default pakai UILD sebagai primary key
    // UILD: seperti UUID tapi sortable by time - lebih cocok untuk ERP
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = ['id'];

    protected function casts() : array {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}