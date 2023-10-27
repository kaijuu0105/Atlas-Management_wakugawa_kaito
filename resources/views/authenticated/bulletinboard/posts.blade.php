@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="post-userName"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p class="post-title"><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="post-title">{{ $post->post_title }}</a></p>
      @foreach($post->subCategories as $subCategory)
        <p class="post-subCategory">{{ $subCategory->sub_category }}</p>
      @endforeach
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="comment-count comment_counts{{ $post->id }}">{{ $commentCounts[$post->id] }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $likeCounts[$post->id] }}</span></p>
            @else
            <p class="m-0"><i class="far fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $likeCounts[$post->id] }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div class="getion"><a class="getion-text" href="{{ route('post.input') }}">投稿</a></div>
      <div class="search-school">
        <input type="text" class="postSearch-form" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="postSearch-btn" value="検索" form="postSearchRequest">
      </div>
      <div class="like-myPost">
        <input type="submit" class="like-post" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" class="my-post" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      </div>
      <div class="search-category">
        <p class="search-category-text">カテゴリー検索</p>
        <ul>
          <!-- <div class="mainCategory_conditions"> -->
          @foreach($categories as $category)
            <div class="accordion-item">
              <li class="main_categories mainCategory_conditions" category_id="{{ $category->id }}"><span class="category-span">{{ $category->main_category }}<span></li>
              <ul class="subCategory">
                @foreach($category->subCategories as $subCategory)
                  <li><input type="submit" name="category_word" class="subCategory_btn  subCategory_conditions_inner_{{ $category->id }}" value="{{ $subCategory->sub_category }}" subCategory_id="{{ $subCategory->id }}" form="postSearchRequest" ></li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection