
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

    //아이디 중복검사
    $('#id_check_btn').click(function () {
      // alert('test');
      let mb_id = $('#mb_id').val();
      $.post(
        "./php/id_check.php",
        { mb_id: mb_id },
        function (data) {
          if (data) {
            $('.id.valid-feedback').html(data);
            $('.id.valid-feedback').show();
          }
        }
      );
    })
    //아이디 수정할시 다시
    $('#mb_id').on('keyup', function () {
      $('.id.valid-feedback').html("아이디 중복 확인 해주세요.");
    })

    //닉네임 중복검사
    $('#mb_nick').on('keyup', function () {
      let mb_nick = $(this).val();

      $.post(
        "./php/nick_check.php",
        { mb_nick: mb_nick },
        function (data) {
          if (data) {
            $('.nick.valid-feedback').html(data);
          }
        }
      )
    })

    //이메일 중복검사
    $('#mb_email').on('keyup', function () {
      let mb_email = $(this).val();

      $.post(
        "./php/email_check.php",
        { mb_email: mb_email },
        function (data) {
          if (data) {
            $('.email.valid-feedback').html(data);
          }
        }
      )
    })

    //전체선택
    $('#all').click(function(){
      let checked = $(this).is(':checked');
      if(checked){
        $('.contract p input').prop('checked', true);
      }else{
        $('.contract p input').prop('checked', false);
      }
    });
    // 하나 선택 제거하면 전체선택 해제
    $('.contract p input').click(function() {
      let checked = $(this).is(':checked');
      if (!checked) {
        $('#all').prop('checked', false);
      }
    });
    //전체선택시 전체선택 체크
    $('.contract p input').click(function() {
      var is_checked = true;
      //하나라도 체크되어 있지 않으면 false가 된다.
      $('.contract p input:not(#all)').each(function(){
          is_checked = is_checked && $(this).is(':checked');
      });
      $('#all').prop('checked', is_checked);
    });
  


    //유효성검사
    let idreg = /^(?=.*?[a-zA-Z])(?=.*?[0-9]).{6,20}$/;
    let pwreg = /^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/;
    let telreg = /^(?=.*?[0-9]).{11,11}$/;

    function form_check() {
      // alert($('.id.valid-feedback').text().trim() != "중복되지 않는 아이디입니다.");
      let result = true;
      if ($('#mb_id').val().length < 1) {
        alert('아이디를 입력해 주세요.');
        result = false;
      } else if (false === idreg.test($('#mb_id').val())) {
        alert('아이디는 6자 이상 20자 이하 영문 숫자 조합이어야 합니다.');
        result = false;
      } else if ($('.id.valid-feedback').text().trim() != "중복되지 않는 아이디입니다.") {
        alert('아이디 중복 확인을 해주세요.');
        result = false;
      } else if ($('#mb_password').val().length < 1) {
        alert('비밀번호를 입력해 주세요.');
        result = false;
      } else if (false === pwreg.test($('#mb_password').val())) {
        alert('비밀번호는 8자 이상 20자 이하 영문 숫자 특수문자(#?!@$%^&*-) 조합이어야 합니다.');
        result = false;
      } else if ($('#mb_password').val() !== $('#mb_password_re').val()) {
        alert('비밀번호가 일치하지 않습니다.');
        result = false;
      } else if ($('#mb_name').val().length < 1) {
        alert('이름을 입력해 주세요.');
        result = false;
      } else if ($('#mb_nick').val().length < 1) {
        alert('닉네임을 입력해 주세요.');
        result = false;
      } else if ($('.nick.valid-feedback').text().trim() != "중복되지 않는 닉네임입니다.") {
        alert('이미 있는 닉네임입니다.');
        result = false;
      } else if ($('#mb_email').val().length < 1) {
        alert('이메일을 입력해 주세요.');
        result = false;
      } else if ($('.email.valid-feedback').text().trim() != "중복되지 않는 이메일입니다.") {
        alert('이미 있는 이메일입니다.');
        result = false;
      } else if (false === telreg.test($('#mb_tel').val())){
        alert('전화번호는 11자 숫자조합이어야 합니다.');
        result = false;
      } else if (!$('#personal_contract').is(':checked') && !$('#usage_contract').is(':checked')){
        alert('필수약관에 동의해 주세요.');
        result = false;
      }
      return result;
    }

