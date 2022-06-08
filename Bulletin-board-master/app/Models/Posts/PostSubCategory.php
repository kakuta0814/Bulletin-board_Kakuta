<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\PostMainCategory;

class PostSubCategory extends Model
{
    protected $table = 'post_sub_categories';

    protected $fillable = [
        'post_main_category_id',
        'sub_category',
    ];


    public function postMainCategories()
    {
        return $this->belongsTo('App\Models\Posts\PostMainCategory');
    }
}
