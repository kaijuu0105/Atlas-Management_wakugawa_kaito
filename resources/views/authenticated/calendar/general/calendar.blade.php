@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border m-auto pt-5 pb-5" style="width: 73rem; border-radius:5px; background:#FFF;">
    <div class="m-auto calender-general" style="width: 65rem; border-radius:5px;">

      <p class="text-center calendar-month">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right m-auto">
      <input type="submit" class="btn btn-primary general-calendar-btn" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <form action="/delete/calendar" method="post" id="deleteParts">
        <div style="display: flex;justify-content: center;">
          <div style="width: 30rem;">
            <p>予約日：<span id="modal_values"></span></p>
            <p>時間：<span id="modal_reserve_parts"></span></p>
            <p>上記の予約をキャンセルしてもよろしいですか？</p>
            <!-- input fromが入力されていないと内容も一緒に送れない -->       
            <input type="hidden" name="getPart" id="modal_reserve_part" form="deleteParts">
            <input type="hidden" name="getData" id="modal_value" form="deleteParts">
            <input type="hidden" name="part" id="part" form="deleteParts">
            <!-- class="js-modal-close"を記入した事によりデータを押し上げる前に閉じる処理が行われている -->
            <!-- js-modal-closeを記入しなくても閉じる処理が行われた -->
            <div style="display: flex;justify-content: space-between;">
              <input type="submit" class="js-modal-close btn btn-primary" value="閉じる">
              <input type="submit" class="btn btn-danger" value="キャンセル" form="deleteParts">
            </div>
          </div>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>
@endsection