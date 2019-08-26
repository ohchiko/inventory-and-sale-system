<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use SoftDeletes;

    protected $table = 'components';

    protected $fillable = [
        'name', 'description', 'cost',
    ];

    protected $cast = [
        'cost' => 'float',
    ];

    protected $with = [
        'user',
    ];

    public function skus()
    {
        return $this->belongsToMany('App\SKU', 'compositions', 'sku_id', 'component_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
