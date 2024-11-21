$(document).ready(function () {
  $('#gnb').hide() //숨기고 시작
  $(".gnb_btn, .f_gnb li:first-child").click(function () {
    $("#gnb").show();
  });

  $(".close_btn").click(function () {
    $("#gnb").hide();
  });

  $(".sub_mnu").hide(); //숨기고 시작
  $("#gnb li").click(function () {
    // 모든 형제 li의 sub_mnu 닫기
    $(this).siblings().find(".sub_mnu").slideUp();
    $(this).siblings().find("img").removeClass('reverse');
    $(this).find("img").toggleClass("reverse");
    $(this).find(".sub_mnu").slideToggle();
  });

  // 하단 gnb와 연결
  //헤더가 안보이는 페이지의 css애
  // .t_header{
  //   display: none !important;
  // }
  // 추가해야함
});
