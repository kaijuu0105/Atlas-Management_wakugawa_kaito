<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\CategoryFormRequest;
use App\Http\Requests\BulletinBoard\SubCategoryFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        // dd($request);
        // subCategoriesはpost_sub_categoryの中間テーブルを呼び出している
        $posts = Post::with('user', 'postComments','subCategories')->orderBy('updated_at','desc')->get();
        $post_id = Post::find('id');
        // dd($posts);

        //////////////いいねカウント//////////////////////
        $post_ids = Post::pluck('id');
        $likeCounts = [];

        foreach ($post_ids as $post_id) {
            $like = new Like;
            // dd($like);
            $likeCount = $like->likeCounts($post_id);
            $likeCounts[$post_id] = $likeCount;
        }
        //////////////////////////////////////////////
        /////////////コメントカウント///////////////////
        $post_ids = Post::pluck('id');
        $commentCounts = [];

        foreach ($post_ids as $post_id) {
            $post_comment = new PostComment;
            $commentCount = $post_comment->commentCounts($post_id);
            $commentCounts[$post_id] = $commentCount;
        }
        //////////////////////////////////////////////////////

        $categories = MainCategory::with('subCategories')->get();
        // dd($categories);
        $subCategories = SubCategory::get();
        // dd($subCategories);
        

        if(!empty($request->keyword)){
            $sub_category = SubCategory::where('sub_category', $request->keyword)->value('id');
            // dd($sub_category);
            if(!empty($sub_category)){
            $post_id = PostSubCategory::where('sub_category_id',$sub_category)->pluck('post_id');
            $posts = Post::with('user', 'postComments')->whereIn('id', $post_id)->orderBy('updated_at','desc')->get();
            // dd($posts);
            }else{
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->orderBy('updated_at','desc')->get();
            }
        }else if($request->category_word){
            // dd($request);
            $sub_category = $request->category_word;
            // dd($sub_category);
            $sub_category_id = SubCategory::where('sub_category',$sub_category)->pluck('id');
            // dd($sub_category_id);
            $post_id = PostSubCategory::where('sub_category_id',$sub_category_id)->pluck('post_id');
            // dd($post_id);
            
            $posts = Post::with('user', 'postComments')->whereIn('id', $post_id)->orderBy('updated_at','desc')->get();
            // dd($posts);
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            // dd($likes);
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->orderBy('updated_at','desc')->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->orderBy('updated_at','desc')->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories','subCategories', 'like','likeCounts', 'post_comment','commentCounts'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments','subCategories')->findOrFail($post_id);
        // dd($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::with('subCategories')->get();
        // $sub_categories = SubCategory::get();
        // dd($sub_categories);
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $sub_category = $request->post_category_id;
        // dd($sub_category);
        $subPost = PostSubCategory::create([
            'post_id' => $post->id,
            'sub_category_id' => $sub_category
        ]);
        // dd($subPost);
        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(CategoryFormRequest $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }
    public function subCategoryCreate(SubCategoryFormRequest $request){
        // dd($request);
        $main_category_id = $request->main_category_id;
        // 応急処置でif使用　バリデーションで解決する方法を考える
        // if($main_category_id != "none"){
            SubCategory::create([
                'main_category_id' => $main_category_id,
                'sub_category' => $request->sub_category_name
            ]);
        // }
        return redirect()->route('post.input');
    }
    public function commentCreate(PostFormRequest $request){
        // $aaa = $request->post_id;
        // dd($aaa);
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;
        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
