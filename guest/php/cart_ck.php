<?php
include("./dbconn.php");

// 1. 로그인 확인
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href='../login.php';</script>";
    exit;
}
// if($_SESSION['userlevel']=='2'||$_SESSION['userlevel']==''||$_SESSION['userlevel']=='3'){
//     echo "<script>alert('학생회원 아이디로 로그인 해주세요'); location.href='../login.php';</script>";
//     exit;
// }

$cl_no = $_GET['cl_no'];

// 2. 장바구니 중복 확인
$sql = "SELECT * FROM gl_cart WHERE mb_no = '{$_SESSION['userno']}' AND cl_no = '$cl_no'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('이미 장바구니에 담긴 클래스입니다.');
    location.href = '../class_view.php?cl_no=".$cl_no."';
    </script>";
    exit;
}

// 3. 구매 이력 확인
$sql = "SELECT * FROM gl_class_member WHERE mb_no = '{$_SESSION['userno']}' AND cl_no = '$cl_no'";
$result2 = mysqli_query($conn, $sql);

if (mysqli_num_rows($result2) > 0) {
    echo "<script>
    alert('이미 구매한 클래스입니다.');
    location.href = '../class_view.php?cl_no=".$cl_no."';
    </script>";
    exit;
}


// 5. 장바구니에 추가 (위 조건을 모두 통과한 경우)
$sql = "INSERT INTO gl_cart SET
    mb_no = '{$_SESSION['userno']}',
    cl_no = '$cl_no'";
$result4 = mysqli_query($conn, $sql);

if($result4){
    echo "
    <script>
    if (confirm('장바구니에 추가되었습니다. 바로 장바구니로 이동하시겠습니까?')) {
        location.href = '../cart.php';
    } else {
        history.back();
    }
    </script>
    ";
}
mysqli_close($conn);
?>
