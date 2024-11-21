<?php
include('./php/dbconn.php');
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 장바구니</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- cart.php 스타일 시트 -->
  <link rel="stylesheet" href="./css/cart.css" type="text/css">
</head>

<body>
  <?php
  $mb_level = $_SESSION['userlevel']; //로그인한 사람의 mb_level;

  // 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
  if ($mb_level == 2) {
    echo "<script>alert('해당 등급의 회원은 이용할 수 없는 서비스입니다.');</script>";
    echo "<script>history.back();</script>";
  } else if ($mb_level == 1) {
  } else { //로그인 안되어 있을시 로그인 화면으로
    echo "<script>alert('로그인이 필요한 서비스입니다.');</script>";
    echo "<script>location.replace('./login_start.php');</script>";
  }

  $mb_no = $_SESSION['userno'];

  $sql = "SELECT
        c.cart_no,
        cl.cl_title,
        cl.cl_teacher,
        cl.cl_category,
        cl.cl_price,
        cl.cl_thumbnail,
        cl.cl_start,
        cl.cl_end
        FROM gl_cart c
        INNER JOIN gl_class cl ON c.cl_no = cl.cl_no
        WHERE c.mb_no = $mb_no
        ORDER BY c.cart_no DESC;";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn)); ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>장바구니</p>
  </nav>

  <form action="./php/cart_pay.php" method="post" id="cart_pay">
    <!-- 메인콘텐츠 영역 -->
    <main>
      <section class="cart_wrap">
        <?php
        $row = mysqli_fetch_array($result);
        if (!$row) {
        ?>
          <div class="no_info">
            <img src="./images/out_of_stock.png" alt="정보없음">
            <p>장바구니에 클래스가 없습니다.</p>
            <a href="class_list.php" title="클래스 목록">클래스 신청하기</a>
          </div>
        <?php
        } else {
        ?>
          <p class="chk_all">
            <input type="checkbox" name="chk_all" id="chk_all">
            <label for="chk_all" class="checkbox"></label>
            <label for="chk_all">전체선택</label>
          </p>
          <?php do { ?>
            <div class="cart_item">
              <div class="check_item">
                <input type="checkbox" name="select[]" id="<?= $row['cart_no'] ?>" value="<?= $row['cart_no'] ?>"
                  class="chk">
                <label for="<?= $row['cart_no'] ?>" class="checkbox"></label>
                <label for="<?= $row['cart_no'] ?>" class="cart_content">
                  <div class="thumbnail">
                    <img type="image" src="../admin/images/class/<?= $row['cl_thumbnail'] ?>" alt="클래스썸네일">
                  </div>
                  <div class="delete_btn">
                    <a href="./php/cart_delete.php?cart_no=<?= $row['cart_no'] ?>"><img src="./images/cart_delete.svg"
                        alt="클래스삭제"></a>
                  </div>
                  <p class="cart_gray">
                    <?= $row['cl_teacher'] ?>&#12539;<?= $row['cl_category'] ?>
                  </p>
                  <div class="cart_title">
                    <?= $row['cl_title'] ?>
                  </div>
                  <p class="cart_gray">클래스날짜 : <?= $row['cl_start'] ?> ~ <?= $row['cl_end'] ?></p>
                  <p class="cart_price"><span><?= number_format($row['cl_price']) ?></span>원</p>
                </label>
              </div>
              <div class="quick_pay">
                <a href="./php/cart_pay.php?cart_no=<?= $row['cart_no'] ?>">바로결제</a>
              </div>
            </div>
        <?php } while ($row = mysqli_fetch_array($result));
        } ?>
      </section>
    </main>

    <footer>
      <div class="lnb_wrap">
        <div class="total_price">
          <p>총 결제 금액</p>
          <p id="total_price">0원</p>
        </div>
        <div class="pay_btn"><input type="submit" value="선택 클래스 수강"></div>
      </div>
    </footer>
  </form>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="./script/goback.js"></script>
  <script src="./script/cart.js"></script>

</body>

</html>