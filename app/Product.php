<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $guarded = [];
    protected $appends = ['win'];
    public $translatedAttributes = ['name', 'description'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getWinAttribute() {
        $win = $this->sale_price - $this->price;
        $win_per =  $win * 100 / $this->price;
        return number_format($win_per, 2);
    }
}
