<?php
  $my_sql_host = 'localhost';
  $my_sql_user = 'heejun';
  $my_sql_pw = 'xhRbwhdm3!';
  $my_sql_db = 'heejun';

  //데이터베이스 연결 변수
  $conn = mysqli_connect($my_sql_host, $my_sql_user, $my_sql_pw, $my_sql_db);

  if(!$conn){ //db연결이 실패라면
    die('db연결실패 : '.mysqli_connect_error());
  }

  //세션 연결을 위해서 
  session_start();
?>
<?php
  // $my_sql_host = 'localhost';
  // $my_sql_user = 'root';
  // $my_sql_pw = '1234';
  // $my_sql_db = 'groovelab';

  // //데이터베이스 연결 변수
  // $conn = mysqli_connect($my_sql_host, $my_sql_user, $my_sql_pw, $my_sql_db);

  // if(!$conn){ //db연결이 실패라면
  //   die('db연결실패 : '.mysqli_connect_error());
  // }

  // //세션 연결을 위해서 
  // session_start();
?>