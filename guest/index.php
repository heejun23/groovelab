<?php 
include ('./php/dbconn.php');
$mb_id = $_SESSION['userid'] ?? "";

// 사용자가 이미 리디렉션된 적이 있는지 확인
// if (!isset($_SESSION['redirected'])) {
//   $_SESSION['redirected'] = true;

//   if (!isset($_SESSION["userid"])) {
//     echo "<script>location.href='./login_start.php'</script>";
//     exit();
//   }

//   // 데이터베이스에서 사용자 정보 가져오기
//   $sql = "SELECT * FROM gl_member WHERE mb_id = '$mb_id'";
//   $result = mysqli_query($conn, $sql);
//   $row = mysqli_fetch_row($result);

//   $_SESSION['userid'] = $row[1];
// }

// 오늘 방문 여부를 확인하기 위해 쿠키를 사용
$today = date('Y-m-d');
if (!isset($_COOKIE['visited_today']) || $_COOKIE['visited_today'] !== $today) {
    // 오늘 처음 방문한 경우 쿠키 설정 (하루 동안 유효)
    setcookie('visited_today', $today, time() + 86400, "/");
}

// 사용자가 최초 방문했는지 확인하기 위해 쿠키를 사용
if (!isset($_COOKIE['first_visit'])) {
    // 최초 방문한 사용자라면 쿠키 설정 (예: 1년 동안 유효)
    setcookie('first_visit', 'true', time() + (86400 * 365), "/");
    header("Location: onboarding.php");
    exit();
}

// 사용자가 로그인했는지 확인하기 위해 세션을 사용
if (!isset($_SESSION['userid'])) {
    // 사용자가 로그인 페이지나 온보딩 페이지에서 온 경우를 확인
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';
    if (strpos($referrer, 'login_start.php') === false && strpos($referrer, 'onboarding.php') === false && (!isset($_COOKIE['visited_today']) || $_COOKIE['visited_today'] !== $today)) {
        // 로그인하지 않은 사용자라면 로그인 페이지로 리디렉션
        header("Location: login_start.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩</title>
      <!-- 파비콘 -->
      <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 메인 스타일시트 -->
  <link rel="stylesheet" href="./css/main.css" type="text/css">
  <!-- 스와이퍼 스타일시트 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
  <!-- 상단헤더서식 -->
  <header>
    <?= include('header_m.php')?>
    <?php include('./bottom_gnb.php'); ?>
  </header>
  <!-- 탑버튼 -->
  <button class="custom-button"><img src="./images/custom_btn.png" alt="챗봇버튼"></button>
  <div id="top_btn">
    <a href="#top"><img src="./images/top_btn_mobile.svg" alt="탑버튼"></a>
  </div>

  <!-- 메인서식 -->
  <main>
    <!--첫번째 콘텐츠 메인동영상 -->
    <article class="cont1_video">
      <h2 class="blind">메인동영상</h2>
      <!-- 음소거 / 자동재생 / 전체화면방지 / 반복재생 -->
      <video src="./images/video/groovelab_main_video.mp4" style="width:100%" id="main_video" muted autoplay playsinline loop>
      </video>
      <!-- 동영상 정지버튼 -->
      <button id="video_pause"><img src="./images/pause_white.svg" alt="동영상 멈추기" id="toggle_play"></button>
      <p>무한한 <span class="main_bold">잠재력</span>으로 <br>  
      <span class="main_bold">창의적인 아티스트</span>가 되도록
      </p>
    </article>

    <!-- 두번째 콘텐츠 아이콘 소개 -->
    <section class="cont2_simple_intro">
      <h2 class="blind">간단소개</h2>
      <div class="cont2_wrap">
        <a href="./class_list.php" class="cont2_box" alt="클래스">
            <img src="./images/class_white.svg" alt="클래스">
            <p>클래스</p>
            <span>전문가의 경험과 기술</span>
        </a>
        <a href="#" class="cont2_box" alt="스튜디오">
          <img src="./images/studio_white.svg" alt="스튜디오" class="studio" style="width:25px">
          <p>스튜디오</p>
          <span>놀라움을 선사하는 공간</span>
        </a>
        <a href="#" class="cont2_box" alt="스토어">
          <img src="./images/store_white.svg" alt="스토어">
          <p>스토어</p>
          <span>클래스에 필요한 준비물</span>
        </a>
        <a href="#" class="cont2_box" alt="아트랩">
          <img src="./images/main_artlab_white.svg" alt="아트랩" class="artlab">
          <p>아트랩</p>
          <span>영감과 모든 노하우</span>
        </a>
      </div> <!--cont2_wrap-->
    </section>

    <!-- 세번째 콘텐츠 주간베스트TOP3 -->
    <section class="cont3_week_best section">
      <h2>주간베스트 TOP3👑</h2>
      <!-- 그라디언트 -->
      <div class="main_gradient"></div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="cont3_slider-item swiper-slide">
              <div class="cont3_img_box">
                <a href="./class_list.php" alt="기리보이"><img src="./images/main_best_giriboy.png" alt="기리보이"></a>
              </div>
              <div class="cont3_txt_box">
                <h3>기리보이의 프로듀싱 클래스</h3>
                <p class="cont3_cate">프로듀싱 클래스</p>
                <span>85,500원</span>
                <div class="star">
                  <img src="./images/review_star_mainColor.svg" alt="별점">
                  <p>4.8</p>
                </div>
              </div> 
            </div> <!--cont3_slider_item-->
            
            <div class="cont3_slider-item swiper-slide">
              <div class="cont3_img_box">
                <a href="class_list.php" alt="박재범"><img src="./images/main_best_jaypark.png" alt="박재범"></a>
              </div>
              <div class="cont3_txt_box">
                <h3>박재범의 힙합 클래스</h3>
                <p class="cont3_cate">힙합 클래스</p>
                <span>95,000원</span>
                <div class="star">
                  <img src="./images/review_star_mainColor.svg" alt="별점">
                  <p>5.0</p>
                </div>
              </div> 
            </div> <!--cont3_slider_item-->

            <div class="cont3_slider-item swiper-slide">
              <div class="cont3_img_box">
                <a href="class_list.php" alt="에일리"><img src="./images/main_best_ailee.png" alt="에일리"></a>
              </div>
              <div class="cont3_txt_box">
                <h3>에일리의 보컬 클래스</h3>
                <p class="cont3_cate">보컬 클래스</p>
                <span>65,000원</span>
                <div class="star">
                  <img src="./images/review_star_mainColor.svg" alt="별점">
                  <p>4.5</p>
                </div>
              </div> 
            </div> <!--cont3_slider_item-->
        </div>
      </div> 
      <a href="class_list.php" title="자세히보기" class="more_btn">자세히보기<img src="./images/arrow_down.svg" alt="자세히보기"></a>
    </section>

    <!-- 네번째 콘텐츠 실시간순위 -->
    <section class="cont4_live_rank section">
      <h2>실시간 랭킹 TOP5🔥</h2>
          <ul class="live_rank_wrap">
          <?php
            $sql = "SELECT c.*
            FROM gl_class c
            INNER JOIN (
              SELECT cl_no, COUNT(*) AS order_count
              FROM gl_class_member
              GROUP BY cl_no
            ) AS top_classes ON c.cl_no = top_classes.cl_no
            WHERE c.cl_start <= NOW() AND c.cl_end >= NOW()
            ORDER BY order_count DESC
            LIMIT 5";
            $result = mysqli_query($conn, $sql);
            $count = 1;
            while($row = mysqli_fetch_array($result)){
            ?>
            <li>
              <a href="class_view.php?cl_no=<?= $row['cl_no'] ?>">
                <h3><?= $count ?></h3>
                  <div class="cont4_box">
                    <div class="cont4_profile"><img src="../admin/images/class/<?= $row['cl_thumbnail'] ?>" alt="강의사진"></div>
                    <div class="cont4_txt">
                      <p><?= $row['cl_teacher']?>&#x00B7;<?= $row['cl_category'] ?></p>
                      <h4><?= $row['cl_title'] ?></h4>
                    </div>
                  </div>
                <img src="./images/arrow_side_white.svg" alt="화살표" id="arrow">
              </a>
            </li>
          <?php $count++; } ?>
          </ul>
      <a href="class_list.php" title="자세히보기" class="more_btn">자세히보기<img src="./images/arrow_down.svg" alt="자세히보기"></a>
    </section>

    <!-- 다섯번째 콘텐츠 신규과정 -->
    <section class="cont5_new_class section">
      <h2>신규과정</h2>
    <div class="main_gradient"></div>
    <div class="cont5_new_class_wrap swiper mySwiper4">
      <div class="inner-grp swiper-wrapper">
        <?php 
        $sql2 = "SELECT * FROM gl_class
        WHERE cl_end IS NULL OR cl_end > CURDATE()
        ORDER BY cl_no DESC
        LIMIT 5";
        $result2 = mysqli_query($conn, $sql2);
        $rowCount = 0;
        while($row2 = mysqli_fetch_array($result2)){
          $rowCount++;
        ?>
          <a href="class_view.php?cl_no=<?= $row2['cl_no'] ?>" class="cont5_new_class_box swiper-slide">
            <div class="cont5_img_box">
              <img src="../admin/images/class/<?= $row2['cl_thumbnail'] ?>" alt="">
            </div>
            <div class="cont5_txt_box">
              <p class="cont5_cate"><?= $row2['cl_teacher']?>&#x00B7;<?php echo $row2['cl_category'] ?></p>
              <p class="cont5_title"><?php echo $row2['cl_title'] ?></p>
              <p class="cont5_price"><?php echo number_format($row2['cl_price']) ?>원</p>
              <div class="cont5_like"></div>
            </div>
          </a>
        <?php }?>
        </div>
      </div>
      <a href="class_list.php" title="자세히보기" class="more_btn">자세히보기<img src="./images/arrow_down.svg" alt="자세히보기"></a>
    </section>

    <!-- 여섯번째 콘텐츠 띠배너 -->
    <article class="cont6_banner">
      <div class="swiper mySwiper2">
        <div class="swiper-wrapper">
          <a href="#" class="swiper-slide cont6_slide"><img src="./images/banner_01.png" alt="배너01"></a>
          <a href="#" class="swiper-slide cont6_slide"><img src="./images/banner_02.png" alt="배너02"></a>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </article>

    <!-- 일곱번쨰 콘텐츠 클래스평가 -->
    <section class="cont7_class_review section">
      <h2>클래스 평가</h2>
      <div class="main_gradient"></div>
      <div class="swiper mySwiper3">
        <div class="cont7_class_wrap swiper-wrapper">
        <?php
        $sql3 = "select * from gl_review ORDER BY review_no DESC LIMIT 5";
        $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_array($result3)){
          $cl_no = $row3['cl_no'];
          $query = "SELECT gr.review_no, gc.cl_thumbnail, gc.cl_title, gc.cl_category, gc.cl_teacher
          FROM gl_review gr
          INNER JOIN gl_class gc ON gc.cl_no = $cl_no";
          $result_class = mysqli_query($conn, $query);
          $cl = mysqli_fetch_array($result_class);
        ?>
          <div class="review_mypage_box swiper-slide">
            <div class="review_mypage_img">
              <img src="../admin/images/class/<?= $cl['cl_thumbnail']?>" alt="">
            </div>
              <div class="review_mypage_title">
                <h3><a href="./review_mypage.php"><?= $cl['cl_title']?></a></h3>
                <p class="cate"><?= $cl['cl_teacher']?>&#x00B7;<?= $cl['cl_category']?></p>
                <div class="star">
                  <div class="review_star">
                    <!-- 색이없음 -->
                    <img src="./images/review_star_noneColor.svg" alt="별">
                    <img src="./images/review_star_noneColor.svg" alt="별">
                    <img src="./images/review_star_noneColor.svg" alt="별">
                    <img src="./images/review_star_noneColor.svg" alt="별">
                    <img src="./images/review_star_noneColor.svg" alt="별">
                  </div>
                  <div class="review_star" style="width:calc(<?php echo $row3['rv_star'] ?>*25px);">
                    <!-- 색이 있음 -->
                    <img src="./images/review_star_mainColor.svg" alt="별">
                    <img src="./images/review_star_mainColor.svg" alt="별">
                    <img src="./images/review_star_mainColor.svg" alt="별">
                    <img src="./images/review_star_mainColor.svg" alt="별">
                    <img src="./images/review_star_mainColor.svg" alt="별">
                  </div>
                </div>
                <div class="review_date_nick">
                  <p><?php echo substr($row3['rv_datetime'],0,10)?></p>
                <?php 
                $mb_no = $row3['mb_no'];
                $query2 = "SELECT gr.review_no, gm.mb_nick
                FROM gl_review gr
                INNER JOIN gl_member gm ON gm.mb_no = $mb_no";
                $result_mb = mysqli_query($conn, $query2);
                $mb = mysqli_fetch_array($result_mb);
                ?>
                  <p><?= $mb['mb_nick']?></p>
                </div>
              </div>
          </div>
        <?php } ?>
        </div>
      </div> 

      <a href="review_mypage.php" title="자세히보기" class="more_btn">자세히보기<img src="./images/arrow_down.svg" alt="자세히보기"></a>
    </section>
  </main>
  
  <!-- 하단 푸터 서식 -->
  <footer>
    <div class="f_wrap">
      <div class="f_top">
        <a href="#">이용약관</a>
        <a href="#"><span class="main_bold">개인정보처리방침</span></a>
        <a href="#">환불규정</a>
      </div>
      <div class="f_bottom">
        <h2 class="f_logo"><a href="index.php" title="메인으로바로가기"><img src="./images/logo_whiteColor.svg" alt="로고화이트"></a></h2>
        <ul class="sns">
          <li><a href="#" title="인스타그램"><img src="./images/sns_insta_mobile.svg" alt="인스타그램"></a></li>
          <li><a href="#" title="페이스북"><img src="./images/sns_facebook_mobile.svg" alt="페이스북"></a></li>
          <li><a href="#" title="트위터"><img src="./images/sns_x-twitter_mobile.svg" alt="트위터-x"></a></li>
          <li><a href="#" title="유튜브"><img src="./images/sns_youtube_mobile.svg" alt="유튜브"></a></li>
        </ul>

        <p>주식회사 그루브랩</p>
        <address>
          대표자: 원희준 | 개인정보관리책임자: 이선재 <br>
          사업자번호: 000-00-0000 | tel: 00-000-0000 <br>
          Email: abcd@naver.com <br>
          서울특별시 강남구 도산대로 00빌딩 7층 <br>
          
          <span>Copyright&copy;GrooveLab All rights reserved.</span>
        </address>
      </div>
    </div>
  </footer>

  <!-- 제이쿼리 cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>
  <!-- 메인 스크립트 -->
  <script src="./script/main.js"></script>
  <!-- 스와이퍼 스크립트 -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="./script/swiper.js"></script>
  <script>
    // 동영상 제어
    function videoBtn(){
      let pauseBtn = document.getElementById('video_pause');
      let video = document.getElementById('main_video');
      let btnImg =  document.getElementById('toggle_play');
      pauseBtn.addEventListener('click', function(){
        if(btnImg.src.match("play_white")){
          btnImg.src = './images/pause_white.svg';
          video.play();
        }else{
          btnImg.src = './images/play_white.svg';
          video.pause();
        }
      });
    }
    videoBtn();
  </script>

  <script>
    (function(){var w=window;if(w.ChannelIO){return w.console.error("ChannelIO script included twice.");}var ch=function(){ch.c(arguments);};ch.q=[];ch.c=function(args){ch.q.push(args);};w.ChannelIO=ch;function l(){if(w.ChannelIOInitialized){return;}w.ChannelIOInitialized=true;var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="https://cdn.channel.io/plugin/ch-plugin-web.js";var x=document.getElementsByTagName("script")[0];if(x.parentNode){x.parentNode.insertBefore(s,x);}}if(document.readyState==="complete"){l();}else{w.addEventListener("DOMContentLoaded",l);w.addEventListener("load",l);}})();

      ChannelIO('boot', {
        "pluginKey": "3defb8c4-59c8-4df6-9f0f-5d6d5ac0f55c",
        "customLauncherSelector": ".custom-button",
  "hideChannelButtonOnBoot": true
      });
  </script>
</body>
</html>