<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory, HasRoles;
    protected $table='roles';
    protected $fillable = ['name'];
    public $timestamps=false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            if (empty($permission->guard_name)) {
                $permission->guard_name = 'web'; 
            }
        });
    }
}
