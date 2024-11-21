//뒤로가기 버튼
$('#history_back').click(function () {
  history.back();
})

//이미지 파일 업로드시 썸네일 이미지 변경하기
function setThumbnail(event) {
  let reader = new FileReader();

  reader.onload = function (event) {
    let img = document.querySelector('.sign_profile_photo > img');
    img.setAttribute("src", event.target.result);
  };
  reader.readAsDataURL(event.target.files[0]);
}

//부트스트랩 유효성검사
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to

  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

//닉네임 중복검사
$('#mb_nick').on('keyup', function () {
  let mb_no = $('#mb_no').val();
  let mb_nick = $(this).val();

  $.post(
    "./php/nick_dbck.php",
    {
      mb_nick: mb_nick,
      mb_no: mb_no
    },
    function (data) {
      if (data) {
        $('.nick.valid-feedback').html(data);
      }
    }
  )
})

//이메일 중복검사
$('#mb_email').on('keyup', function () {
  let mb_no = $('#mb_no').val();
  let mb_email = $(this).val();

  $.post(
    "./php/email_dbck.php",
    {
      mb_email: mb_email,
      mb_no: mb_no
    },
    function (data) {
      if (data) {
        $('.email.valid-feedback').html(data);
      }
    }
  )
})


//유효성검사
let namereg = /[ㄱ-ㅎ가-힣a-zA-Z]$/;
let telreg = /^(?=.*?[0-9]).{11,11}$/;

function form_check() {
  // alert($('.id.valid-feedback').text().trim() != "중복되지 않는 아이디입니다.");
  let result = true;
  if (false === namereg.test($('#mb_name').val())) {
    alert('이름은 한글 영문 조합이어야 합니다.');
    result = false;
  } else if ($('.nick.valid-feedback').text().trim() != "사용가능한 닉네임입니다.") {
    alert('이미 있는 닉네임입니다.');
    result = false;
  } else if ($('.email.valid-feedback').text().trim() != "사용가능한 이메일입니다.") {
    alert('이미 있는 이메일입니다.');
    result = false;
  } else if (false === telreg.test($('#mb_tel').val())) {
    alert('전화번호는 11자 숫자조합이어야 합니다.');
    result = false;
  }
  return result;
}

