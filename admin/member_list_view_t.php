<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩 : 회원상세보기</title>

  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/member_list_view.css" />

  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<?php include('./php/dbconn.php');

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

  //진행 클래스 정보 가져오기
  $sql = "SELECT *
  FROM gl_class
  WHERE cl_start <= CURDATE() AND cl_end >= CURDATE() AND mb_no ='$mb_no'
  ORDER BY cl_start DESC
  LIMIT 1;
";

  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  // 수강생 수 계산
  $cl_no = $row['cl_no'] ??"";
  $sql2 = "SELECT COUNT(*) as mb_count
                  FROM gl_class_member cm
                  INNER JOIN gl_class c ON cm.cl_no = c.cl_no
                  WHERE cm.cl_no = '$cl_no'";
  $result2 = mysqli_query($conn, $sql2);
  $count = mysqli_fetch_assoc($result2);

  //사진 나오게하기
  $sql3 = "SELECT m.mb_photo
              FROM gl_member m
              INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no
              WHERE cm.cm_status = 1 AND cm.cl_no = '$cl_no'
              ORDER BY cm.cm_randate DESC
              LIMIT 5;";
  $result3 = mysqli_query($conn, $sql3);



  //지난 클래스 정보 가져오기
  $sql4 = "SELECT *
    FROM gl_class
    WHERE cl_end <= CURDATE() AND mb_no ='$mb_no'
    ORDER BY cl_end DESC
    LIMIT 3;
  ";
  $result4 = mysqli_query($conn, $sql4);
  $row2 = mysqli_fetch_array($result4);





  ?>
  <!-- 브랜치 -->
  <p class="branch">회원관리 &#x003E; 회원상세</p>

  <main>
    <section id="center">
      <h2 class="blind">회원상세</h2>
      <!-- 프로필 -->
      <article id="profile">
        <h2>프로필</h2>

        <div class="flex_box">
          <div class="p_img">
            <img src="../guest/images/profile/<?= $profile['mb_photo'] ?>" alt="프로필사진">
          </div>

          <table class="p_con">
            <tr>
              <td>이름</td>
              <td><?php echo $profile['mb_name'] ?></td>
            </tr>
            <tr>
              <td>닉네임</td>
              <td><?php echo $profile['mb_nick'] ?></td>
            </tr>
            <tr>
              <td>이메일</td>
              <td><?php echo $profile['mb_email'] ?></td>
            </tr>
            <tr>
              <td>휴대폰</td>
              <td><?= preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $profile['mb_tel']); ?></td>
            </tr>
          </table>

          <table class="p_con">
            <tr>
              <td>관심사</td>
              <td><?php
                  $interest = $profile['mb_interest'];

                  // 한 번의 str_replace 호출로 여러 개의 치환 수행
                  $interestSTR = [
                    "cate01" => "보컬",
                    "cate02" => "힙합",
                    "cate03" => "뮤지컬/재즈/클래식",
                    "cate04" => "프로듀싱",
                    "cate05" => "작사/작곡",
                    "cate06" => "음향관리/엔지니어링",
                  ];

                  $modi_interest = str_replace(array_keys($interestSTR), array_values($interestSTR), $interest);

                  echo $modi_interest ?></td>
            </tr>
            <tr>
              <td>가입입</td>
              <td><?php echo substr($profile['reg_date'],0,10) ?></td>
            </tr>
            <tr>
              <td>포인트</td>
              <td>ㅡ</td>
            </tr>
            <tr>
              <td>등급</td>
              <td>
                <?php
                $level = $profile['mb_level'];

                $level_STR = [
                  "1" => "학생",
                  "2" => "크리에이터",
                  "3" => "관리자"
                ];

                $modi_level = str_replace(array_keys($level_STR), array_values($level_STR), $level);

                echo $modi_level ?></td>
            </tr>
          </table>
        </div>
      </article>

      <div class="flex_box" style="height:538px;">
        <!-- 진행클래스 -->
        <article id="now_class">
          <h2>진행중인 클래스</h2>
          <a href="class_ad_ongoing.php?mb_no=<?=$mb_no?>" title="진행중인 클래스">
            <img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>
          <?php


          if (empty($row)) {
            echo "
            <div class='no_class'>
            <img src='./images/out_of_stock.png' alt='클래스 정보없음'>
            <p>진행중인 클래스가 없습니다.</p>
            </div>
            ";
          } else {
            echo "
            <a href='class_ad_view.php?cl_no=".$row['cl_no']."' title='클래스' class='thum'>
            <img src='./images/class/" . $row['cl_thumbnail'] . "' alt='가장 최근 진행 클래스' />
            </a>
            <a href='class_ad_view.php?mb_no=".$mb_no."' title='클래스' class='info'>
              <h4>" . $row['cl_title'] . "</h4>
              <p>" . $row['cl_teacher'] . " &#x00B7; " . $row['cl_category'] . "</p>
              <p>" . $row['cl_start'] . " ~ " . $row['cl_end'] . "</p>
            </a>
            <div class='p_bottom flex_box'>";

            //수강생수 나오는 부분
            echo "<p><span>" . $count['mb_count'] . "</span>명 수강중&#128293;</p>";
            echo "<div class='img_box'>";

            //사진 나오는 부분
            while ($photo = mysqli_fetch_assoc($result3)) {
              echo "<img src='../guest/images/profile/" . $photo['mb_photo'] . "' alt='' />";
            }
            echo "</div>
            </div>
            ";
          }
          ?>
        </article>
        <!-- 클래스이력 -->
        <article id="history">
          <h2>클래스 이력</h2>
          <a href="class_ad_closed.php?mb_no=<?=$mb_no?>" title="클래스 이력"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>

          <?php

          if (empty($row2)) {
            echo "<div class='no_class'>
            <img src='./images/out_of_stock.png' alt='클래스 정보없음'>
            <p>클래스 진행 이력이 없습니다.</p>
            </div>";
          } else {
            do {
              echo "
              <a href='class_ad_view.php?cl_no=" . $row2['cl_no'] . "' title='' class='h_con flex_box'>
              <div class='class'><img src='./images/class/" . $row2['cl_thumbnail'] . "' alt=''></div>
  
              <div class='info'>
                <h4>" . $row2['cl_title'] . "</h4>
                <p>" . $row2['cl_teacher'] . " &#x00B7; " . $row2['cl_category'] . "</p>
                <p>" . $row2['cl_start'] . " ~ " . $row2['cl_end'] . "</p>";

              // 지난클래스 수강생 수 계산
              $cl_no2 = $row2['cl_no'];
              $c_sql = "SELECT COUNT(*) as mb_count_end
                  FROM gl_class_member cm
                  INNER JOIN gl_class c ON cm.cl_no = c.cl_no
                  WHERE cm.cm_status = 2 AND cm.cl_no = '$cl_no2'";
              $c_result = mysqli_query($conn, $c_sql);
              $count2 = mysqli_fetch_assoc($c_result);

              echo "
                <p><span>" . $count2['mb_count_end'] . "</span>명 수강&#128293;</p>";

              echo "</div>
  
              <div class='img_box'>";

              //지난강의 들은 사람 사진
              $sql5 = "SELECT m.mb_photo
    FROM gl_member m
    INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no
    WHERE cm.cm_status = 2 AND cm.cl_no = '$cl_no2'
    ORDER BY cm.cm_randate DESC
    LIMIT 5;";
              $result5 = mysqli_query($conn, $sql5);

              while ($photo2 = mysqli_fetch_assoc($result5)) {
                echo "<img src='../guest/images/profile/" . $photo2['mb_photo'] . "' alt='' />";
              }
              echo "</div>
            </a>
              ";
            } while ($row2 = mysqli_fetch_array($result4));
          }
          ?>
        </article>
      </div>
      <!-- 리뷰 -->
      <article id="review">
        <h2>수강생 평가</h2>
        <a href="review_ad_list.php?mb_no=<?=$mb_no?>" title="수강생 평가"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>

        <div class="grid">

          <?php

          $sql = "SELECT 
          r.review_no,
          r.rv_star,
          r.rv_content,
          r.rv_datetime,
          c.cl_thumbnail,
          c.cl_title,
          m.mb_photo,
          m.mb_nick
          FROM gl_review AS r
          INNER JOIN gl_class AS c ON r.cl_no = c.cl_no
          INNER JOIN gl_member AS m ON r.mb_no = m.mb_no
          WHERE r.cl_no IN (SELECT cl_no FROM gl_class WHERE mb_no = '$mb_no')
          ORDER BY r.rv_datetime DESC
          LIMIT 4;";

          $result = mysqli_query($conn, $sql);
          // if (!$result) {
          //   echo "에러: " . mysqli_error($conn);
          //   exit;
          // }
          if(mysqli_num_rows($result) == 0){
            echo "<div class='no_class'>
          <img src='./images/out_of_stock.png' alt='정보없음' style='width: 100px;'>
          <p>등록된 클래스 평가가 없습니다.</p>
          </div>";
          }else{
            while($rv = mysqli_fetch_array($result)){
              echo "
              <a href='review_ad_view.php?rv_no=" . $rv['review_no'] . "' title='리뷰' class='flex_box item'>
            <img src='./images/class/" . $rv['cl_thumbnail'] . "' alt='' >
            <div class='item_con'>
              <h4>" . $rv['cl_title'] . "</h4>
              <div>
                <img src='../guest/images/profile/".$rv['mb_photo']."' alt='프로필사진' class='psa'>
                <p class='nick'>".$rv['mb_nick']."</p>
                <div class='star_box'>
                <div class='review_star'>
                  <div class='star'>
                    <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                    <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                    <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                    <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                    <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                  </div>
                  <div class='star star2' style='width:calc(".$rv['rv_star']."*13px)'>
                    <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                    <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                    <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                    <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                    <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                  </div>
                  </div>
                  <p class='date'>" . substr($rv['rv_datetime'],0,10) . "</p></div>
              </div>
              <p class='review'>" . $rv['rv_content'] . "</p>
            </div>
          </a>
              ";
            }
          }
          ?>


        </div>
      </article>

      <div class="flex_box btn_center">
        <a href="member_list_upload.php?mb_no=<?= $mb_no ?>" title="회원수정" class="up_btn">회원수정</a>
        <a href="" title="회원탈퇴" class="del_btn">회원탈퇴</a>
      </div>
    </section>
  </main>
  <script>
    $(document).ready(function() {
      // 메뉴 열린거 다 숨기기
      $(".sub_menu").hide();
      //첫째만 열려있기
      $(".gnb li:eq(0) ul").show()

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
    });
  </script>
</body>

</html>