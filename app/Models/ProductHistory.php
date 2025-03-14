<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'people_name',
        'people_phone',
        'people_email',
        'assignment_quantity',
        'assign_date',
        'devolution_date',
        'observation',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
