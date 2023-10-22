<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // 多対多リレーション
    // コントローラーでリレーション先を呼び出す時の名前subCategories
    public function subCategories(){
        return $this->belongsToMany('App\Models\Categories\SubCategory','post_sub_categories','post_id','sub_category_id');// リレーションの定義
    }

    // public function PostSubCategories(){
    //     return $this->belongsTo('App\Models\Posts\PostSubCaregory');// リレーションの定義
    // }


    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}