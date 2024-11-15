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
        'ubication',
        'observation',
        'active'
    ];




    public function assignments()
    {
        return $this->belongsToMany(AssignPeople::class, "product_assignments")
            ->withPivot("assigned_quantity")
            ->withTimestamps();
    }
    public function getQuantityNumberAttribute()
    {
        preg_match('/\d+/', $this->total_quantity, $matches);
        return (int) $matches[0] ?? 0;
    }

    public function getAvailableQuantityAttribute()
    {
        $totalAssigned = $this->assignments()->sum('assigned_quantity');
        return $this->quantity_number - $totalAssigned;
    }
}
