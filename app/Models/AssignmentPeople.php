<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentPeople extends Model
{
    //
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_assignment_people', 'assignment_person_id', 'product_id')
            ->withPivot('assigned_quantity')
            ->withTimestamps();
    }
}
