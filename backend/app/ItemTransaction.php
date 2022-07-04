<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    protected $table = 'items_transactions';
    protected $primaryKey = 'id';
    protected $fillable = ['id_item','quantity','details'];

    protected $casts = [
        'details' => 'array',
    ];

    public function item(){
        return $this->belongsTo(Item::class,'id_item');
    }

    public function scopeDesc($query){
        $query->orderByDesc('created_at');
    }
}
