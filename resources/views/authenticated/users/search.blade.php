@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
      <div class="border one_person">
        <div style="display: grid;min-height: -webkit-fill-available">
          <div>
            <span style="color: gray;">ID : </span><span>{{ $user->id }}</span>
          </div>
          <div class = "namnam">
            <div ><span style="color: gray;">名前 : </span>
              <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                <span>{{ $user->over_name }}</span>
                <span>{{ $user->under_name }}</span>
              </a>
            </div>
            <div>
              <span style="color: gray;">カナ : </span>
              <span>({{ $user->over_name_kana }}</span>
              <span>{{ $user->under_name_kana }})</span>
            </div>
          </div>
          <div >
            @if($user->sex == 1)
            <span style="color: gray;">性別 : </span><span>男</span>
            @elseif($user->sex == 2)
            <span style="color: gray;">性別 : </span><span>女</span>
            @else
            <span style="color: gray;">性別 : </span><span>その他</span>
            @endif
          </div>
          <div >
            <span style="color: gray;">生年月日 : </span><span>{{ $user->birth_day }}</span>
          </div>
          <div >
            @if($user->role == 1)
            <span style="color: gray;">権限 : </span><span>教師(国語)</span>
            @elseif($user->role == 2)
            <span style="color: gray;">権限 : </span><span>教師(数学)</span>
            @elseif($user->role == 3)
            <span style="color: gray;">権限 : </span><span>講師(英語)</span>
            @else
            <span style="color: gray;">権限 : </span><span>生徒</span>
            @endif
          </div>
          <div >
            @if($user->role == 4)
            <span style="color: gray;">選択科目 :</span>
            @foreach($user->subjects as $subject)
              <span>{{ $subject->subject }}</span>
            @endforeach
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="">
      <h4>検索</h4>
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class = "name-id">
        <lavel style="color: gray;margin-bottom: 0.5rem;">カテゴリ</lavel>
        <select form="userSearchRequest" name="category" class="select-name-id">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="birthday-time">
        <label style="color: gray;">並び替え</label>
        <select name="updown" form="userSearchRequest" class="select-birthday-time">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="">
        <p class="m-0 search_conditions" style="color: gray;"><span>検索条件の追加</span></p>
        <div class="search_conditions_inner">
          <div>
            <label style="color: gray; display: block; margin-top: 0.8rem;">性別</label>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <label style="color: gray; display: block; margin-top: 0.8rem;">権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label style="color: gray; display: block; margin-top: 0.8rem;">選択科目</label>
            <span>国語</span><input type="checkbox" name="subject" value="1" form="userSearchRequest">
            <span>数学</span><input type="checkbox" name="subject" value="2" form="userSearchRequest">
            <span>英語</span><input type="checkbox" name="subject" value="3" form="userSearchRequest">
          </div>
        </div>
      </div>
      <div>
        <input type="submit" class="search_btn" name="search_btn" value="検索" form="userSearchRequest" style="margin-top: 0.5rem;">
      </div>
      <div>
        <input type="reset" class="reset_btn" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
