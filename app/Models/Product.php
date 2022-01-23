<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'product_image','product_image_name','stock','price','description','user_id','category_id','status','offer'
    ];

    public function pimages(){
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

}
