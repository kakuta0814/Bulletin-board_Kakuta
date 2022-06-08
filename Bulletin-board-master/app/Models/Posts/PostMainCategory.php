<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\PostSubCategory;

class PostMainCategory extends Model
{
    protected $table = 'post_main_categories';

    protected $fillable = [
        'main_category',
    ];

    public function postSubCategories()
    {
        return $this->hasMany('App\Models\Posts\PostSubCategory');
    }


}
