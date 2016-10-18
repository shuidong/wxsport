<?php
// require 'password.php';
require 'dbConfig.php';
session_start();

$errorMessage = "";

if (isset($_POST["login"])) {
  if (empty($_POST["userid"])) {
    $errorMessage = "请输入用户ID";
  } else if (empty($_POST["password"])) {
    $errorMessage = "请输入您的密码";
  } 

  if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
    $mysqli = new mysqli($dbIp, $dbUser, $dbPwd);
    if ($mysqli->connect_errno) {
      print('<p>连接数据库发生错误。</p>' . $mysqli->connect_error);
      exit();
    }

    $mysqli->select_db($dbNm);
    $mysqli->set_charset('utf8');

    $userid = $mysqli->real_escape_string($_POST["userid"]);

    $query = "SELECT * FROM $dbUserTbl WHERE name = '" . $userid . "'";
    $result = $mysqli->query($query);
    if (!$result) {
      print('查询数据库失败。' . $mysqli->error);
      $mysqli->close();
      exit();
    }

    $db_hashed_pwd = "";
    while ($row = $result->fetch_assoc()) {
      $db_hashed_pwd = $row['password'];
      $uid = $row['id'];
    }

    $mysqli->close();

    //if ($_POST["password"] == $pw) {
//    if (password_verify($_POST["password"], $db_hashed_pwd)) {
    if ($_POST["password"] == $db_hashed_pwd) {
      session_regenerate_id(true);
      $_SESSION["USERID"] = $_POST["userid"];
      $_SESSION["uid"] = $uid;
      header("Location: checkin.php");
      exit;
    } 
    else {
      $errorMessage = "用户名或者密码错误。";
    } 
  } else {
  } 
} 
 
?>
<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>登录</title>
  </head>
  <body>
  <h1>登录</h1>
  <!--<form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">-->
  <form id="loginForm" name="loginForm" action="" method="POST">
  <fieldset>
  <legend>登录</legend>
  <div><?php echo $errorMessage ?></div>
  <label for="userid">用户名</label><input type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
  <br>
  <label for="password">密码</label><input type="password" id="password" name="password" value="">
  <br>
  <input type="submit" id="login" name="login" value="登录">
  </fieldset>
  </form>
  <!-- <a href="regist.html">注册用户</a> -->
  </body>
</html>