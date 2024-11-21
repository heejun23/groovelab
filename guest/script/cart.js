$(document).ready(function () {

  //전체선택
  $('#chk_all').click(function () {
    let checked = $(this).is(':checked');
    if (checked) {
      $('.chk').prop('checked', true);
    } else {
      $('.chk').prop('checked', false);
    }

    totalPrice();
  });
  // 하나 선택 제거하면 전체선택 해제
  $('.chk').click(function () {
    let checked = $(this).is(':checked');
    if (!checked) {
      $('#chk_all').prop('checked', false);
    }

    totalPrice();
  });
  //전체선택시 전체선택 체크
  $('.chk').click(function () {
    var is_checked = true;
    //하나라도 체크되어 있지 않으면 false가 된다.
    $('.chk:not(#all)').each(function () {
      is_checked = is_checked && $(this).is(':checked');
    });
    $('#chk_all').prop('checked', is_checked);

    totalPrice();
  });

  //체크박스 변경시 총 결제가격 변경
  const totalPrice = () => {
    // alert('test');
    let totalPrice = 0;
    $('.chk').each(function (index) {
      if ($(this).is(':checked')) {
        const price = parseFloat($('.cart_price span').eq(index).text().replace(',', ''));
        // alert($('.cart_price span').eq(index).text());
        if (!isNaN(price)) {
          totalPrice += price;
        }
      }
    });
    totalPrice = totalPrice.toLocaleString();
    $('#total_price').text(totalPrice + '원');
  };

  $('#cart_pay').on('submit',function(){
    // alert('test');
    if($('#total_price').text()=="0원"){
      alert('구매한 클래스가 없습니다.');
      return false;
    }
  });

});