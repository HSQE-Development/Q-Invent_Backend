<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
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
        'total_quantity',
        'quantity_type',
        'ubication',
        'observation',
        'active'
    ];




    public function assignmentPeople()
    {
        return $this->belongsToMany(AssignmentPeople::class, "product_assignment_people", "product_id", "assignment_person_id")
            ->withPivot("assigned_quantity")
            ->withTimestamps();
    }
}
