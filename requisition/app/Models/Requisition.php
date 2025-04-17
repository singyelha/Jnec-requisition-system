<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requisition extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'user_id',
        'requisition_date',
        'department',
        'requester_name',
        'requester_designation',
        'status',
    ];

    // Relationship: A Requisition belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A Requisition has many Items
    public function items(): HasMany
    {
        return $this->hasMany(RequisitionItem::class);
    }
}