<?php
session_start();

// 判断是否登录过
if (!isset($_SESSION["USERID"])) {
  header("Location: logout.php");
  exit;
}

//require 'password.php';
require 'dbConfig.php';
$link = mysql_connect($dbIp, $dbUser, $dbPwd);
if (!$link) {
    die('连接数据库失败。'.mysql_error());
}

$db_selected = mysql_select_db($dbNm, $link);
if (!$db_selected){
    die('选择数据库失败。'.mysql_error());
}

mysql_set_charset('utf8', $link);

$sql = "INSERT INTO t_checkin (userId) VALUES ('" . $_SESSION["uid"] ."')";
$result_flag = mysql_query($sql);

if (!$result_flag) {
    die('签到数据插入失败，请联系管理员。<br><a href="login.php">戻る</a>');
}

print('<p>' . $_SESSION["USERID"] . '用户签到成功。</p>');

$close_flag = mysql_close($link);

?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>签到</title>
  </head>
  <body>
  <h1>签到</h1>

  <p>欢迎您，<?=htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?> </p>
  <ul>
  <li><a href="logout.php">退出</a></li>
  </ul>
  </body>
</html>