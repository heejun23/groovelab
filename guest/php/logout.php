<?php
  include('dbconn.php');

  // 세션 변수 해제
  session_unset();
  
  // 세션ID 삭제
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
      session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
?>

<script>
  alert('로그아웃 되었습니다.');
  location.replace('../login_start.php');
</script>