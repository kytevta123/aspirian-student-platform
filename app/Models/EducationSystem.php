<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationSystem extends Model
{
    use SoftDeletes;

    protected $table = 'education_systems';

    protected $fillable = [
        'name',
        'country',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the boards for this education system.
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }
}
