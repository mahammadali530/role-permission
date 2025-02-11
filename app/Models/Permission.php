<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table='permissions';
    protected $fillable = ['name', 'guard_name'];
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
