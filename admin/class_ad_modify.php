<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css서식 초기화 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 헤더 스타일 서식 -->
  <link rel="stylesheet" href="./css/header.css" type="text/css">
  <!-- 메인 스타일 서식 -->
  <link rel="stylesheet" href="./css/class_ad_upload.css" type="text/css">
  <title>그루브랩 : 클래스수정</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>

<?php

include ('./php/dbconn.php');


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


$cl_no = $_GET['cl_no'];
$sql = "select * from gl_class where cl_no = '$cl_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$cl_category = $row['cl_category'];
$cl_teacher = $row['cl_teacher'];
$cl_title = $row['cl_title'];
$cl_price = $row['cl_price'];
$cl_time = $row['cl_time'];
$cl_start = $row['cl_start'];
$cl_end = $row['cl_end'];
$cl_video = $row['cl_video'];
$cl_thumbnail = $row['cl_thumbnail'];
$cl_desc_image = $row['cl_desc_image'];
$cl_desc = $row['cl_desc'];
?>

  <header>
    <!-- 메인로고 -->
    <h1>
      <a href="mypage_ad.php" title="메인페이지"><img src="./images/logo_whiteColor.svg" alt="메인로고" /></a>
    </h1>
    <!-- <p class="menu">MENU</p> -->

    <!-- gnb -->
    <ul class="gnb">
      <li>
        <a href="#" title="회원관리 탭"><img src="./images/cs_manager.svg" alt="회원아이콘" class="first_icon" />회원관리<img
            src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" />
        </a>
        <ul class="sub_menu">
          <li><a href="member_list.php" title="전체회원">- 전체회원</a></li>
          <li><a href="member_creator.php" title="크리에이터">- 크리에이터</a></li>
          <li><a href="member_student.php" title="학생회원">- 학생회원</a></li>
        </ul>
      </li>
      <li>
        <a href="#" title="클래스관리 탭"><img src="./images/class_admin.svg" alt="동영상아이콘" class="first_icon" />클래스관리<img
            src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
        <ul class="sub_menu">
          <li><a href="class_ad_list.php" title="전체클래스">- 전체클래스</a></li>
          <li><a href="class_ad_ongoing.php" title="진행클래스">- 진행클래스</a></li>
          <li><a href="class_ad_closed.php" title="종료클래스">- 종료클래스</a></li>
          <li><a href="class_ad_upload.php" title="클래스등록">- 클래스등록</a></li>
          <li><a href="review_ad_list.php" title="클래스평가">- 클래스평가</a></li>
        </ul>
      </li>
      <li>
        <a href="#" title="게시판관리 탭"><img src="./images/board_admin.svg" alt="게시판아이콘" class="first_icon" />게시판관리<img
            src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
        <ul class="sub_menu">
          <li><a href="notice_ad_list.php" title="공지사항">- 공지사항</a></li>
          <li><a href="qna_ad_list.php" title="QNA">- QNA</a></li>
        </ul>
      </li>
      <li>
        <a href="#" title="스토어 탭"><img src="./images/store_admin.svg" alt="가게모양아이콘" class="first_icon" />스토어<img
            src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
        <ul class="sub_menu">
          <li><a href="#" title="결제관리">- 결제관리</a></li>
          <li><a href="#" title="내역조회">- 내역조회</a></li>
          <li><a href="#" title="문의">- 문의</a></li>
        </ul>
      </li>
    </ul>

    <!-- 수정한 부분 -->
    <!-- 프로필 -->
    <div class="profile">

      <div class="psa">

        <?php
        $mb_no = $_SESSION['userno'];
        $sql = "select * from gl_member where mb_no = '$mb_no'";
        $profile_result = mysqli_query($conn, $sql);
        $profile = mysqli_fetch_array($profile_result);
        ?>
        <img src="../guest/images/profile/<?= $profile['mb_photo'] ?? "" ?>" alt="프로필사진">
      </div>

      <strong><?= $profile['mb_nick'] ?>(<?= $profile['mb_id'] ?>)</strong>

      <table>
        <tr>
          <th>등급</th>
          <td colspan="2">
            <?php
            $level = $profile['mb_level'];
            if ($level == 2) {
              echo "크리에이터";
            } else {
              echo "관리자";
            }
            ?>
          </td>
        </tr>

        <tr>
          <th>진행클래스</th>
          <?php
          $sql = "SELECT COUNT(*) FROM gl_class WHERE cl_end >= CURDATE() and cl_start <= CURDATE();";
          $count_result = mysqli_query($conn, $sql);
          $count = mysqli_fetch_array($count_result);
          $cl_count = $count[0];
          ?>
          <td> <?= $cl_count ?> 개</td>
          <td><a href="class_ad_list.php" title="전체클래스">관리</a></td>
        </tr>

        <tr>
          <th>신규게시글</th>
          <?php
          $sql = "SELECT COUNT(*) FROM gl_qna WHERE qna_datetime > NOW() - INTERVAL 1 DAY";
          $count_result = mysqli_query($conn, $sql);
          $count = mysqli_fetch_array($count_result);
          $qna_count = $count[0];
          $sql = "SELECT COUNT(*) FROM gl_notice WHERE no_datetime > NOW() - INTERVAL 1 DAY";
          $count_result = mysqli_query($conn, $sql);
          $count = mysqli_fetch_array($count_result);
          $qna_count += $count[0];
          ?>
          <td> <?= $qna_count ?> 건</td>
          <td><a href="notice_ad_list.php" title="공지사항">관리</a></td>
        </tr>

        <tr>
          <th>신규회원</th>
          <?php
          $sql = "SELECT COUNT(*) FROM gl_member WHERE reg_date > NOW() - INTERVAL 1 DAY";
          $count_result = mysqli_query($conn, $sql);
          $count = mysqli_fetch_array($count_result);
          $new_user_count = $count[0];
          ?>
          <td> <?= $new_user_count ?> 명</td>
          <td><a href="member_list.php" title="전체회원">관리</a></td>
        </tr>

        <tr>
          <th>회원수</th>
          <?php
          $sql = "SELECT COUNT(*) FROM gl_member";
          $count_result = mysqli_query($conn, $sql);
          $count = mysqli_fetch_array($count_result);
          $user_count = $count[0];
          ?>
          <td> <?= $user_count ?> 명</td>
          <td><a href="member_list.php" title="전체회원">관리</a></td>
        </tr>

      </table>
    </div>

  </header>

  <!-- 상단 로그아웃/설정탭 -->
  <nav class="header2">
    <div class="btn_box">
      <a href="#" title="알림" class="bell"><img src="./images/bell_admin.svg" alt="종 아이콘"></a>
      <a href="./php/logout.php" title="로그아웃" class="logout_btn">로그아웃</a>
      <a href="" title="계정관리" class="setting_btn"><img src="./images/setting_admin.svg" alt="">계정관리</a>
    </div>
  </nav>

  <p class="branch">홈 > 클래스관리 > 클래스수정</p>

  <!-- 메인서식 -->
  <main>
    <!-- <p class=branch>클래스관리 > 전체클래스관리</p> -->
    <section class="class_ad_upload">
      <h2>클래스수정</h2>

      <!-- 강의등록 양식 -->
      <form action="./php/class_ad_modify_check.php?cl_no=<?php echo $row['cl_no'] ?>" name="class_ad_upload"
        method="post" id="class_ad_upload" enctype="multipart/form-data">
        <!-- 강의등록 / 강사선택박스 -->
        <div class="class_ad_upload_cate">
          <select name="cl_category" id="class_ad_upload_select_cl" class="class_ad_upload_select_cl">
            <option value="">클래스를 선택해주세요.</option>
            <option value="보컬클래스" <?php echo isset($cl_category) ? ($cl_category == "보컬클래스") ? 'selected' : '' : '' ?>>
              보컬클래스
            </option>
            <option value="힙합클래스" <?php echo isset($cl_category) ? ($cl_category == "힙합클래스") ? 'selected' : '' : '' ?>>
              힙합클래스
            </option>
            <option value="뮤지컬/재즈/클래식클래스" <?php echo isset($cl_category) ? ($cl_category == "뮤지컬/재즈/클래식클래스") ? 'selected' : '' : '' ?>>뮤지컬/재즈/클래식클래스</option>
            <option value="프로듀싱클래스" <?php echo isset($cl_category) ? ($cl_category == "프로듀싱클래스") ? 'selected' : '' : '' ?>>
              프로듀싱클래스</option>
            <option value="음향관리/엔지니어링클래스" <?php echo isset($cl_category) ? ($cl_category == "음향관리/엔지니어링클래스") ? 'selected' : '' : '' ?>>음향관리/엔지니어링클래스</option>
          </select>

          <!-- while문으로 해당강사의 mb_no , mb_nik 값 받아오기 -->
          <select name="cl_teacher" id="class_ad_upload_select_t" class="class_ad_upload_select_t">
            <option value="">강사를 선택해주세요.</option>
            <?php
            $sql = "select mb_no, mb_nick from gl_member where mb_level=2";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
              ?>
              <option value="<?= $row[1] ?>" <?php echo isset($cl_teacher) ? ($cl_teacher == $cl_teacher) ? 'selected' : '' : '' ?>>
                <?= $row[1] ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <!-- 강의명 입력 박스 -->
        <div class="class_ad_upload_cl_name">
          <input type="text" name="cl_title" id="cl_title" placeholder="클래스명을 입력하세요." value="<?= $cl_title ?>">
        </div>

        <!-- 가격, 시간, 시작일, 종료일박스 -->
        <div class="class_ad_upload_flexbox">
          <!-- 가격, 시간 -->
          <div class="class_ad_upload_left_box">
            <!-- 가격 -->
            <p>
              <label for="cl_price">가격</label>
              <input type="text" name="cl_price" id="cl_price"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                value="<?= $cl_price ?>">
            </p>

            <!-- 시간 -->
            <p>
              <label for="cl_time">총 시간</label>
              <input type="text" name="cl_time" id="cl_time" maxlength="3"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                value="<?= $cl_time ?>">
            </p>
          </div>
          <!-- 시작일, 종료일 -->
          <div class="class_ad_upload_right_box">
            <!-- 시작일 -->
            <p>
              <label for="cl_start">시작일</label>
              <input type="date" id="cl_start" name="cl_start" value="<?= $cl_start ?>">
            </p>
            <span class="class_ad_upload_conn">~</span>
            <!-- 종료일 -->
            <p>
              <label for="cl_end">종료일</label>
              <input type="date" id="cl_end" name="cl_end" value="<?= $cl_end ?>">
            </p>
          </div>
        </div> <!-- class_ad_upload_flexbox 끝 -->

        <!-- 클래스영상, 썸네일사진 등록 박스 -->
        <div class="class_ad_update_cl_thum">
          <!-- 클래스 영상 -->
          <div>
            <span>클래스영상<img src="./images/file_upload_admin.svg" alt="비디오"></span>
            <input type="file" name="cl_video" id="cl_video" accept="video/*">
          <div id="class_ad_update_video_box"><?= $cl_video ?></div>
          <input type="hidden" name="cl_video_hidden" value="<?= $cl_video ?>">
          <label for="cl_video">등록</label>
          </div>
          <!-- 썸네일 -->
          <div class="thum_margin_left">
            <span>썸네일<img src="./images/img_upload_admin.svg" alt="썸네일"></span>
            <input type="file" name="cl_thumbnail" id="cl_thumbnail"
              accept="image/gif, image/jpg, image/jpeg, image/png">
          <div id="class_ad_update_thum_box"><?= $cl_thumbnail ?></div>
          <input type="hidden" name="cl_thumbnail_hidden" value="<?= $cl_thumbnail ?>">
          <label for="cl_thumbnail">등록</label>
          </div>
        </div>

        <!-- 상세페이지 이미지 박스 -->
        <div class="class_ad_update_cl_detailbox">
          <span>상세페이지 이미지<img src="./images/img_upload_admin.svg" alt="상세페이지"></span>
          <input type="file" name="cl_desc_image" id="cl_desc_image"
            accept="image/gif, image/jpg, image/jpeg, image/png">
          <div id="class_ad_update_detail_box"><?= $cl_desc_image ?></div>
          <input type="hidden" name="cl_desc_image_hidden" value="<?= $cl_desc_image ?>">
          <label for="cl_desc_image">등록</label>
        </div>

        <!-- 클래스 소개글 박스 -->
        <div class="class_ad_update_cl_desc">
          <textarea name="cl_desc" id="cl_desc" cols="30" rows="10"
            placeholder="클래스 소개를 입력하세요."><?= $cl_desc ?></textarea>
        </div>

        <!-- 클래스 챕터 목록 -->
        <div class="class_ad_chapter_wrap">
          <div class="class_ad_chapter_btn">
            <button type="button" class="class_chapter_plus">챕터 추가</button>
            <button type="button" class="class_chapter_delete">마지막 챕터 삭제</button>
          </div>
          <ul class="class_ad_chapter_list">
            <?php
            $sql = "SELECT * from gl_class_chapter where cl_no = $cl_no order by cc_chapter_no asc";
            $cc_result = mysqli_query($conn, $sql);
            $cc_no = 1;
            while ($cc = mysqli_fetch_array($cc_result)) {
              ?>
              <li>
                <h4>챕터<?= $cc_no ?></h4>
                <label for="cc_title_<?= $cc_no ?>" class="blind">챕터 제목</label>
                <input type="text" name="cc_title[]" id="cc_title_<?= $cc_no ?>"
                  placeholder="챕터<?= $cc_no ?> 제목을 입력해 주세요." maxlength="50" value="<?= $cc['cc_title'] ?>">

                <div class="class_ad_chapter_videobox">
                  <span>챕터<?= $cc_no ?> 영상<img src="./images/file_upload_admin.svg" alt="비디오"></span>
                  <div class="cc_video_<?= $cc_no ?>_box"><?= $cc['cc_video'] ?></div>
                  <input type="hidden" name="cc_video_<?= $cc_no ?>_hidden" class="cc_video_<?= $cc_no ?>_hidden"
                    value="<?= $cc['cc_video'] ?>">
                  <label for="cc_video_<?= $cc_no ?>">등록</label>
                  <input type="file" name="cc_video[]" id="cc_video_<?= $cc_no ?>" accept="video/*">
                </div>
                <label for="cc_desc_<?= $cc_no ?>" class="blind">챕터 설명</label>
                <textarea name="cc_desc[]" id="cc_desc_<?= $cc_no ?>" cols="30" rows="10"
                  placeholder="챕터 설명을 입력해 주세요."><?= $cc['cc_desc'] ?></textarea>
              </li>
              <?php $cc_no++;
            } ?>
          </ul>
        </div>

        <!-- 강의등록버튼 -->
        <div class="class_ad_update_cl_btn">
          <input type="submit" id="class_ad_update_cl_btn" value="수정완료" name="submit">
          <a href="#" onclick="goBack();">취소</a>
        </div>
      </form>
    </section>
  </main>
  <!-- 헤더 스크립트 -->
  <script src="./script/header.js"></script>
  <!-- 이전페이지 함수 -->
  <script>
    function goBack() {
      history.back();
    }
  </script>

  <!-- 이미지/동영상 업로드한 주소 표시하기 -->
  <script>
    const input = document.getElementById('cl_thumbnail');
    const output = document.getElementById('class_ad_update_thum_box');
    const output2 = document.getElementById('class_ad_update_detail_box');
    const output3 = document.getElementById('class_ad_update_video_box');

    document.getElementById('cl_thumbnail').addEventListener('input', (event) => {
      const files = event.target.files
      output.textContent = Array.from(files).map(file => file.name).join('\n')
    });

    document.getElementById('cl_desc_image').addEventListener('input', (event) => {
      const files = event.target.files
      output2.textContent = Array.from(files).map(file => file.name).join('\n')
    });

    document.getElementById('cl_video').addEventListener('input', (event) => {
      const files = event.target.files
      output3.textContent = Array.from(files).map(file => file.name).join('\n')
    });
  </script>

  <!-- 유효성 검사 -->
  <script>
    // function formCheck() {
    $(document).ready(function () {

      $('#class_ad_upload').submit(function () {
        let result = true;
        // alert($('#class_ad_upload_select_cl').val());
        if ($('#class_ad_upload_select_cl').val().length < 1) {
          alert('클래스를 선택하지 않았습니다.');
          result = false;
        }
        if ($('#class_ad_upload_select_t').val().length < 1) {
          alert('강사를 선택하지 않았습니다.');
          result = false;
        }
        if (document.getElementById('cl_title').value.trim() == "") {
          alert('클래스명을 입력하지 않았습니다.');
          $('#cl_title').focus();
          result = false;
        }
        if ($('#cl_price').val().length < 1) {
          alert('가격을 입력하지 않았습니다.');
          $('#cl_price').focus();
          result = false;
        }
        if ($('#cl_time').val().length < 1) {
          alert('강의 시간을 입력하지 않았습니다.');
          $('#cl_time').focus();
          result = false;
        }
        if ($('#cl_start').val().length < 1) {
          alert('시작 날짜를 입력하지 않았습니다.');
          $('#cl_start').focus();
          result = false;
        }
        if ($('#cl_end').val().length < 1) {
          alert('종료 날짜를 입력하지 않았습니다.');
          $('#cl_end').focus();
          result = false;
        }
        if (($('#cl_video').get(0).files.length)) {
          if ($('#cl_video').get(0).files[0].size > (10 * 1024 * 1024)) {
            alert('동영상 용량은 10MB이하여야 합니다.');
            $('#cl_video').focus();
            result = false;
          }
        }
        // if (!($('#cl_video').get(0).files.length)) {
        //   alert('동영상을 삽입하지 않았습니다.');
        //   $('#cl_video').focus();
        //   result = false;
        // } else 
        // if ($('#cl_video').get(0).files[0].size > (10 * 1024 * 1024)) {
        //   alert('동영상 용량은 10MB이하여야 합니다.');
        //   $('#cl_video').focus();
        //   result = false;
        // }
        // if (!($('#cl_thumbnail').get(0).files.length)) {
        //   alert('썸네일을 삽입하지 않았습니다.');
        //   $('#cl_thumbnail').focus();
        //   result = false;
        // }
        // if (!($('#cl_desc_image').get(0).files.length)) {
        //   alert('강의 상세페이지를 삽입하지 않았습니다.');
        //   $('#cl_desc_image').focus();
        //   result = false;
        // }
        if ($('#cl_desc').val().length < 1) {
          alert('강의내용을 입력하지 않았습니다.');
          $('#cl_desc').focus();
          result = false;
        }
        return result;
      });
    });
  </script>

  <!-- 챕터 추가/삭제 -->
  <script>

    $(document).ready(function () {
      let chapterCount = $('.class_ad_chapter_list li').length;
      // alert(chapterCount);

      $('.class_chapter_plus').click(function () {
        chapterCount++;
        const no = chapterCount;
        $('.class_ad_chapter_list').append(`
                    <li>
                        <h4>챕터${no}</h4>
                        <label for="cc_title_${no}" class="blind">챕터 제목</label>
                        <input type="text" name="cc_title[]" id="cc_title_${no}" placeholder="챕터${no} 제목을 입력해 주세요." maxlength="50">

                        <div class="class_ad_chapter_videobox">
                            <span>챕터${no} 영상<img src="./images/file_upload_admin.svg" alt="비디오"></span>
                            <div id="cc_video_${no}_box"></div>
                            <label for="cc_video_${no}">등록</label>
                            <input type="file" name="cc_video[]" id="cc_video_${no}" accept="video/*">
                        </div>
                        <label for="cc_desc_${no}" class="blind">챕터 설명</label>
                        <textarea name="cc_desc[]" id="cc_desc_${no}" cols="30" rows="10" placeholder="챕터 설명을 입력해 주세요."></textarea>
                    </li>
                `);
      });

      // 이벤트 위임을 사용하여 폼 제출을 처리합니다.
      $('#class_ad_upload').on('submit', function (event) {
        let result = true;
        // alert('test');

        // 각 챕터를 검사합니다.
        $('.class_ad_chapter_list li').each(function (index) {
          const no = index + 1;
          if ($(`#cc_title_${no}`).val().length < 1) {
            alert(`챕터${no} 제목을 입력하세요.`);
            $(`#cc_title_${no}`).focus();
            result = false;
          }
          if ($(`.cc_video_${no}_hidden`).length === 0) {
            if (!($(`#cc_video_${no}`).get(0).files.length)) {
              alert(`챕터${no} 동영상을 삽입하지 않았습니다.`);
              $(`#cc_video_${no}`).focus();
              result = false;
            } else if ($(`#cc_video_${no}`).get(0).files[0].size > (10 * 1024 * 1024)) {
              alert(`챕터${no} 동영상 용량은 10MB이하여야 합니다.`);
              $(`#cc_video_${no}`).focus();
              result = false;
            }
          }
          if ($(`#cc_desc_${no}`).val().length < 1) {
            alert(`챕터${no} 설명을 입력하지 않았습니다.`);
            $(`#cc_desc_${no}`).focus();
            result = false;
          }
        });

        if (!result) {
          event.preventDefault(); // 폼 제출을 막습니다
        }
        return result;
      });

      // 동적으로 추가된 파일 입력의 이벤트 처리
      $('.class_ad_chapter_list').on('change', 'input[type="file"]', function (event) {
        const no = $(this).attr('id').match(/\d+/)[0];
        const files = event.target.files;
        $(this).parent().find('div').text(Array.from(files).map(file => file.name).join('\n'));
      });

      $('.class_chapter_delete').click(function () {
        count = $('.class_ad_chapter_list li').length;
        if (count == 1) {
          alert('최소 하나의 챕터는 있어야 합니다.');
        } else {
          $('.class_ad_chapter_list li').last().remove();
          chapterCount--;
        }
      });


      //메뉴 열어놓기
      $(document).ready(function () {
        $(".sub_menu").eq(1).show();
        $(".gnb > li > a").eq(1).addClass('active').find('.open').addClass('reverse');
        $(".gnb > li > a").eq(1).find('.first_icon').addClass('white')
      });
    });

  </script>

</body>

</html>