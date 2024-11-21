 $(document).ready(function () {
  // 메뉴 열린거 다 숨기기
  $(".sub_menu").hide();
  //첫째만 열려있기
  $(".gnb li:eq(0) ul").show()

  // 헤더 메뉴 눌렀을때
  $(".gnb li a").click(function () {
    //내가 선택한 a만 서식적용, 꺽쇠 회전
    $(".gnb > li  a")
      .removeClass("active")
      .find(".open")
      .removeClass("reverse");
    $(this).addClass("active").find(".open").addClass("reverse");

    //first_icon 색바꾸기
    $(".gnb > li  a").find(".first_icon").removeClass("white");
    $(this).find(".first_icon").addClass("white");

    // 선택한 상태라면
    if ($(this).hasClass("active")) {
      $(this)
        .next(".sub_menu")
        .slideDown()
        .parent()
        .siblings()
        .find(".sub_menu")
        .slideUp();
    }
  });


    $('.chart').each(function() {
      let chart = $(this);
      let cl_no = chart.data('cl_no');
      let mb_no = chart.data('mb_no');

      $.post(
        "../admin/php/progress.php", {
          cl_no: cl_no,
          mb_no: mb_no
        },
        function(data) {
          if (data) {
            let numData = (parseFloat(data) / 100) * 360; // 문자열을 숫자로 변환하고 그래프에 맞는 진행도로 변환
            chart.css('background', 'conic-gradient(#333 0deg, #333 ' + numData + 'deg, #eee 0deg)');
            // console.log(numData)
          }
        }
      )
    });


});