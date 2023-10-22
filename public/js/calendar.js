// モーダル投稿機能
$(function () {
    // 編集ボタン(class="js-modal-open")が押されたら発火
    // $("js-model-open").each(function) {
    $('.js-modal-open').on('click', function () {
      // モーダルの中身(class="js-modal")の表示
      $('.js-modal').fadeIn();
      // 押されたボタンから投稿内容を取得し変数へ格納
      var reserve_part = $(this).attr('reservePart');
      // 押されたボタンから投稿のidを取得し変数へ格納（どの予約をキャンセルするか特定するのに必要な為）
      var value = $(this).attr('value');
      var part = $(this).attr('part');
  
      // 取得した投稿内容をモーダルの中身へ渡す
      $('#modal_reserve_parts').text(reserve_part);
      $('#modal_reserve_part').val(reserve_part);
      // 取得した投稿のidをモーダルの中身へ渡す
      $('#modal_values').text(value);
      $('#modal_value').val(value);
      $('#part').val(part);
      return false;
    });

    // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
    $('.js-modal-close').on('click', function () {
      // モーダルの中身(class="js-modal")を非表示
      $('.js-modal').fadeOut();
      return false;
    });
});
