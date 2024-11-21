 // 베스트강의 스와이퍼
var swiper = new Swiper(".mySwiper", {
  spaceBetween: 20,
  speed: 1500,
  autoplay:{
    delay: 3000,
  }
});

// 신규과정 스와이퍼
var swiper = new Swiper(".mySwiper4", {
  width:170,
    spaceBetween: 20,
    breakpoints:{
      380: {
        width:210,
      },
      450:{
        width:230,
      },
      680: {
        width:320,
      },
      1024: {
        width:550,
      }
    }
});

// 띠배너 스와이퍼
var swiper = new Swiper(".mySwiper2", {
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

  // 리뷰평가 스와이퍼
  var swiper = new Swiper(".mySwiper3", {
    width:170,
    spaceBetween: 20,
    breakpoints:{
      380: {
        width:210,
      },
      450:{
        width:230,
      },
      680: {
        width:320,
      },
      1024: {
        width:550,
      }
    }
  });