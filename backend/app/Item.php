<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = ['title','quantity', 'unit'];
    public $timestamps = false;

    public function details(){
        return $this->hasMany(ItemTransaction::class,'id_item');
    }
}
