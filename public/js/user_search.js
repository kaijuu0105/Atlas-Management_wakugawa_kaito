$(function () {
  $('.search_conditions_inner').hide();
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $('.search_conditions').toggleClass("open");
  });

    // カテゴリーをクリックすると
  $('.mainCategory_conditions').on("click", function () {
    // クリックした次の要素を開閉(subCategory)
    $(this).next().slideToggle(300);
    // カテゴリーにopenクラスを付け外しして矢印の向きを変更
    $(this).toggleClass("open", 300);
  });
  
  $('.subject_inner').hide();
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $('.subject_edit_btn').toggleClass("open");
  });
});
