<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩 : 회원수정</title>

  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/member_list_view.css" />
  <link rel="stylesheet" href="css/member_list_upload.css">

  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<?php 
include('./php/dbconn.php');

$mb_no = $_SESSION["userno"];

$sql = "select mb_level from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_level = $row[0]; //로그인한 사람의 mb_level;

// 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
if ($mb_level == 2) {
  echo "<script>alert('관리자 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
} else if ($mb_level == 3) {
} else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
  echo "<script>alert('관리자 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
}

?>

  <!-- 헤더 -->
  <?php include('./header.php');

  $mb_no = $_GET['mb_no'];
  $sql = "SELECT * FROM gl_member WHERE mb_no = '$mb_no'";
  $profile_result = mysqli_query($conn, $sql);
  $profile = mysqli_fetch_array($profile_result);

  ?>
  <!-- 브랜치 -->
  <p class="branch">회원관리 &#x003E; 회원수정</p>

  <main>
    <form name="update" id="update_form" action="./php/member_list_modify.php" method="post" enctype="multipart/form-data">
      <input type="hidden" value="<?= $mb_no ?>" name="mb_no" id="mb_no">
      <input type="hidden" value="<?= $profile['mb_id'] ?>" name="mb_id">
      <section id="center">
        <h2 class="blind">회원수정</h2>
        <!-- 프로필 -->
        <article id="profile">
          <h2>프로필</h2>

          <!-- 프사 -->
          <div class="sign_profile">
            <div class="sign_profile_photo">
              <img src="../guest/images/profile/<?= $profile['mb_photo'] ?>" alt="프로필 사진">
            </div>
            <label for="sign_profile_photo" class="sign_image_upload"><img src="./images/edit_white.svg" alt="이미지 첨부"></label>
            <input type="file" name="sign_profile_photo" id="sign_profile_photo" accept="image/gif, image/jpeg, image/jpg, image/png" onchange="setThumbnail(event);">
            <input type="hidden" name="profile_default" value="<?= $profile['mb_photo'] ?>">
          </div>

          <table class="p_con">
            <tr>
              <td><label for="mb_name">이름</label></td>
              <td><input type="text" name="mb_name" id="mb_name" value="<?php echo $profile['mb_name'] ?>"></td>
            </tr>
            <tr>
              <td><label for="mb_nick">닉네임</label></td>
              <td>
              <p class="nick_result"></p>
                <input type="text" name="mb_nick" id="mb_nick" value="<?php echo $profile['mb_nick'] ?>"></td>
            </tr>
            <tr>
              <td><label for="mb_email">이메일</label></td>
              <td>
              <p class="email_result"></p>
                <input type="email" name="mb_email" id="mb_email" value="<?php echo $profile['mb_email'] ?>"></td>
            </tr>
            <tr>
              <td><label for="mb_tel">휴대폰</label></td>
              <td><input type="text" name="mb_tel" id="mb_tel" value="<?php echo $profile['mb_tel'] ?>"></td>
            </tr>
            <tr>
              <td>관심사</td>
              <td>
                <div class="interest">
                  <input type="checkbox" name="mb_interest[]" id="cate01" value="cate01" <?= strpos($profile['mb_interest'],'cate01') !==false ?'checked' : '' ?>>
                  <label for="cate01">보컬</label>
                  <input type="checkbox" name="mb_interest[]" id="cate02" value="cate02" <?= strpos($profile['mb_interest'],'cate02') !==false ?'checked' : '' ?>>
                  <label for="cate02">힙합</label>
                  <input type="checkbox" name="mb_interest[]" id="cate03" value="cate03" <?= strpos($profile['mb_interest'],'cate03') !==false ?'checked' : '' ?>>
                  <label for="cate03">뮤지컬/재즈/클래식</label>
                  <input type="checkbox" name="mb_interest[]" id="cate04" value="cate04" <?= strpos($profile['mb_interest'],'cate04') !==false ?'checked' : '' ?>>
                  <label for="cate04">프로듀싱</label>
                  <input type="checkbox" name="mb_interest[]" id="cate05" value="cate05" <?= strpos($profile['mb_interest'],'cate05') !==false ?'checked' : '' ?>>
                  <label for="cate05">작사/작곡</label>
                  <input type="checkbox" name="mb_interest[]" id="cate06" value="cate06" <?= strpos($profile['mb_interest'],'cate06') !==false ?'checked' : '' ?>>
                  <label for="cate06">음향관리/엔지니어링</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>가입일</td>
              <td><?php echo substr($profile['reg_date'], 0, 10) ?></td>
            </tr>
            <tr>
              <td>포인트</td>
              <td><?php echo $profile['mb_point'] ?></td>
            </tr>
            <tr>
              <td><label for="mb_level">등급</label></td>
              <td>
                <select name="mb_level" id="mb_level">
                  <option value="">등급</option>
                  <option value="1" <?php if ($profile['mb_level'] == 1) { echo 'selected'; } ?>>학생</option>
                  <option value="2" <?php if ($profile['mb_level'] == 2) { echo 'selected'; } ?>>크리에이터</option>
                </select>
              </td>
            </tr>
          </table>


        </article>

        <div class="flex_box btn_center">
          <input type="submit" value="회원수정" class="up_btn">
          <a href="" title="회원탈퇴" class="del_btn">회원탈퇴</a>
        </div>
      </section>
    </form>
  </main>
  <script>
    $(document).ready(function() {
      // 메뉴 열린거 다 숨기기
      $(".sub_menu").hide();
      //첫째만 열려있기
      $(".gnb li:eq(0) ul").show();

      // 헤더 메뉴 눌렀을때
      $(".gnb li a").click(function() {
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


      //닉네임 중복검사
      $('#mb_nick').on('keyup', function() {
        let mb_no = $('#mb_no').val();
        let mb_nick = $(this).val();

        $.post(
        "./php/nick_dbck.php",
        { mb_nick: mb_nick,
          mb_no: mb_no
         },
        function (data) {
          if (data) {
            $('.nick_result').text(data);
          }
        }
      )
    })

      // 이메일 중복검사
      $('#mb_email').on('keyup', function() {
        let mb_no = $('#mb_no').val();
        let mb_email = $(this).val();

        $.post(
        "./php/email_dbck.php",
        { mb_email: mb_email,
          mb_no: mb_no
         },
        function (data) {
          if (data) {
            $('.email_result').text(data);
          }
        }
      )
    })

      // 유효성검사
      $('#update_form').submit(function() {
        let mb_name = $('#mb_name').val();
        let mb_nick = $('#mb_nick').val();
        let mb_email = $('#mb_email').val();
        let mb_tel = $('#mb_tel').val();
        let mb_level = $('#mb_level').val();

        if (mb_name.length < 2) {
          alert('이름은 최소 2자 이상 입력해주세요.')
          return false
        }
        let nameReg = /^[가-힣]+$/;
        if (!nameReg.test(mb_name)) {
          alert('이름을 정확히 입력해주세요.')
          return false
        }
        if (mb_nick == '') {
          alert('닉네임을 입력해주세요.')
          return false
        }
        if($('.nick_result').text().trim() == '이미 사용중인 닉네임입니다. 다른 닉네임을 입력해주세요'){
          alert('이미 사용중인 닉네임입니다. 다른 닉네임을 입력해주세요.')
          return false
        }
        if (mb_email == '') {
          alert('이메일을 입력해주세요.')
          return false
        }
        let emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{3,4}$/;
        if (!emailReg.test(mb_email)) {
          alert("유효한 이메일 주소를 입력해주세요.");
          return false;
        }
        if($('.email_result').text().trim() == '이미 사용중인 이메일입니다. 다른 이메일을 입력해주세요'){
          alert('이미 사용중인 이메일입니다. 다른 이메일을 입력해주세요.')
          return false
        }
        if (mb_tel == '') {
          alert('번호를 입력해주세요.')
          return false
        }
        let telReg = /^\d{9,11}$/;
        if (!telReg.test(mb_tel)) {
          alert('전화번호는 11자 숫자조합이어야 합니다.')
          return false
        }
        if (mb_level == '') {
          alert('등급을 선택해주세요.')
          return false
        }
        // 모든 유효성 검사를 통과한 경우, 폼 제출
        this.submit();
      })



    });

    //이미지 파일 업로드시 썸네일 이미지 변경하기
    function setThumbnail(event) {
      let reader = new FileReader();

      reader.onload = function(event) {
        let img = document.querySelector('.sign_profile_photo > img');
        img.setAttribute("src", event.target.result);
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</body>

</html>