<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionItem extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'requisition_id',
        'item_name',
        'item_description',
        'quantity',
        'remarks',
    ];

    // Relationship: An Item belongs to a Requisition
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }
}