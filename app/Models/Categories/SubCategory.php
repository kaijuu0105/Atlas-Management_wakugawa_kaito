<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\MainCategory;
use App\Models\Posts\Post;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory(){
        return $this->belongsTo('App\Models\Categories\MainCaregory');// リレーションの定義
    }

    // public function postsSubcategory(){
    //     return $this->hasMany('App\Models\Posts\Post');// リレーションの定義
    // }

    // 多対多リレーション
    // コントローラーでリレーション先を呼び出す時の名前post
    public function post(){
        return $this->belongsToMany('App\Models\Posts\Post','post_sub_categories','sub_category_id','post_id');// リレーションの定義
    }
}