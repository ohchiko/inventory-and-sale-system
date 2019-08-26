<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SKU extends Model
{
    use SoftDeletes;

    protected $table = 'skus';

    protected $fillable = [
        'name', 'description', 'price'
    ];

    protected $cast = [
        'price' => 'float',
    ];

    protected $with = [
        'user',
    ];

    public function components()
    {
        return $this->belongsToMany('App\Component', 'compositions', 'sku_id', 'component_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
