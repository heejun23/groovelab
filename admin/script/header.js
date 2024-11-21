          $(document).ready(function () {
            // 메뉴 열린거 다 숨기기
            $(".sub_menu").hide();
    
            // 헤더 메뉴 눌렀을때
            $(".gnb li a").click(function (e) {
              // 새로고침 방지
              // e.preventDefault();
    
    
    
              //내가 선택한 a만 서식적용, 꺽쇠 회전
              $('.gnb > li  a').removeClass('active').find('.open').removeClass('reverse');
              $(this).addClass('active').find('.open').addClass('reverse');
    
              //first_icon 색바꾸기
              $('.gnb > li  a').find('.first_icon').removeClass('white');
              $(this).find('.first_icon').addClass('white')
            
    
              // 선택한 상태라면
              if($(this).hasClass('active')){
                $(this).next('.sub_menu').slideDown().parent().siblings().find('.sub_menu').slideUp();
              }
          
            });
          });