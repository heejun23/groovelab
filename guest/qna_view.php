<?php
// login.php
include('./php/dbconn.php');

$qna_no = $_GET['qna_no'];

$sql = "select * from gl_qna where qna_no='$qna_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : QNA</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- qna_view.css -->
  <link rel="stylesheet" href="./css/qna_view.css" type="text/css">

</head>

<body>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php'); ?>
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>QNA</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="qna_view">
      <h2 class="blind">QNA질문</h2>
      <!-- 제목 프로필 박스 -->
      <div class="qna_view_head">
        <p class="qna_view_title"><?php echo $row['qna_title'] ?></p>
        <p class="qna_view_date"><?php echo substr($row['qna_datetime'], 0, 10) ?></p>

        <?php
        $mb_no = $row['mb_no'];
        $sql2 = "select mb_photo, mb_nick, mb_level from gl_member where mb_no = '$mb_no'";
        $result2 = mysqli_query($conn, $sql2);
        $mb = mysqli_fetch_assoc($result2);
        ?>
        <div class="qna_view_profile_box">
          <div class="qna_view_profile">
            <img src="./images/profile/<?= $mb['mb_photo'] ?>" alt="프로필사진">
          </div>
          <p class="qna_view_usernick"><?php echo $mb['mb_nick'] ?></p>
        </div>
      </div>

      <!-- 사진 글내용 박스 -->
      <div class="qna_view_img_txt">
        <?php if (!empty($row['qna_image'])) { ?>
          <div class="qna_view_body_img">
            <img src="./images/qna/<?= $row['qna_image'] ?>" alt="질문사진">
          </div>
          <p class="qna_view_body_txt">
            <?php echo nl2br($row['qna_content']) ?>
          </p>

        <?php } else { ?>
          <p class="qna_view_body_txt">
            <?php echo nl2br($row['qna_content']) ?>
          </p>
        <?php } ?>
      </div>

      <?php
      // 답변완료 상태일때 버튼이 보이지않는다.
      $qna_no = $row['qna_no'];
      $sql3 = "select * from gl_qna where qna_parent_no='$qna_no'";
      $result3 = mysqli_query($conn, $sql3);
      $row3 = mysqli_fetch_array($result3);
      if (!isset($row3['qna_no'])) { ?>

        <?php
        // 나의 계정일때만 버튼이 보인다.
        $sql4 = "select mb_no from gl_qna where qna_no='$qna_no'";
        $result4 = mysqli_query($conn, $sql4);
        $my_account = mysqli_fetch_array($result4);

        if ($mb_no = $_SESSION['userno'] == $my_account['mb_no']) { ?>
          <!-- 삭제/수정 버튼 -->
          <div class="qna_view_btn">
            <a href="./php/qna_delete.php?qna_no=<?php echo $row['qna_no'] ?>" id="qna_view_del"><img src="./images/delete_white.svg" alt="삭제">삭제</a>
            <a href="qna_modify.php?qna_no=<?php echo $row['qna_no'] ?>" id="qna_view_edit"><img src="./images/edit_black.svg" alt="수정">수정</a>
          </div>
        <?php }
      } else { ?>


      <?php } ?>
      <!-- 계정 level이 2일 경우에 답글이 나온다. -->
      <?php
      $sql5 = "select * from gl_member where mb_level = 2";
      $result5 = mysqli_query($conn, $sql5);
      $row5 = mysqli_fetch_array($result5);
      $mb_level = $_SESSION['userlevel'];
      if ($mb_level == $row5['mb_level'] && !isset($row3['qna_parent_no'])) { ?>
        <form action="./php/qna_reply.php?qna_no=<?php echo $row['qna_no'] ?>" method="post" id="qna_upload">
          <div class="qna_view_reply_wrap">
            <h3>답변</h3>
            <div class="qna_view_reply">

              <textarea name="qna_reply" id="qna_reply" cols="30" rows="10" placeholder="답글을 작성해주세요." required></textarea>

            </div>
            <div class="qna_view_reply_btn">
              <input type="reset" id="qna_reply_del" value="답변취소">
              <input type="submit" id="qna_reply_edit" value="답변완료"></input>
            </div>
          </div>
        </form>
      <?php }

      if (isset($row3['qna_parent_no']) && $_SESSION['userlevel'] == 1) {
      ?>
        <div class="qna_view_reply_wrap">
          <h3>답변</h3>
          <div class="qna_view_reply_pf">
            <?php
            $mb_no = $row3['mb_no'];
            $reply_photo = "SELECT mb_photo,mb_nick FROM gl_member where mb_no = '$mb_no'";
            $mb_photo_re = mysqli_query($conn, $reply_photo);
            $mp = mysqli_fetch_array($mb_photo_re); ?>
            <div class="reply_img">
              <img src="./images/profile/<?php echo $mp['mb_photo'] ?> " alt="강사프로필">
              <p class="reply_nick"><?php echo $mp['mb_nick'] ?></p>
              <span><?php echo substr($row3['qna_datetime'], 0, 10) ?> </span>
            </div>
            <p class="reply_done"><?php echo nl2br($row3['qna_content']) ?></p>

          </div>
        <?php } ?>

        <?php if (isset($row3['qna_parent_no']) && $_SESSION['userlevel'] == 2) { ?>
          <form action="./php/qna_reply_modify.php?qna_no=<?php echo $row3['qna_no'] ?>" method="post" id="qna_upload">
            <div class="qna_view_reply_wrap">
              <h3>답변수정</h3>
              <div class="qna_view_reply">

                <textarea name="qna_reply" id="qna_reply" cols="30" rows="10" placeholder="답글을 작성해주세요." required><?php echo $row3['qna_content'] ?></textarea>

              </div>
              <div class="qna_view_reply_btn">
                <a href="#" onclick="goBack();" id="qna_reply_del">수정취소</a>
                <input type="submit" id="qna_reply_edit" value="수정완료"></a>
              </div>
            </div>
          </form>
        <?php } ?>
    </section>
  </main>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>
</body>

</html>