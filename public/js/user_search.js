$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

    // カテゴリーをクリックすると
  $('.mainCategory_conditions').on("click", function () {
    // クリックした次の要素を開閉(subCategory)
    $(this).next().slideToggle(300);
    // カテゴリーにopenクラスを付け外しして矢印の向きを変更
    $(this).toggleClass("open", 300);
  });
  
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});
