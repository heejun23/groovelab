$(document).ready(function () {
  // 내용 바꾸기
  let nav = $("#h_list li a");

  $.get("./all_list.php", function (data) {
    $("#class_info").html(data);
  });

  nav.click(function () {
    nav.removeClass("h_on");
    $(this).addClass("h_on");

    let url = $(this).attr("href");

    $.get(url, function (data) {
      $("#class_info").html(data);
    });
    return false;
  });
});
