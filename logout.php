<?php
session_start();

if (isset($_SESSION["USERID"])) {
  $errorMessage = "用户已退出。";
}
else {
  $errorMessage = "session已经超时。";
}
$_SESSION = array();
//if (ini_get("session.use_cookies")) {
//    $params = session_get_cookie_params();
//    setcookie(session_name(), '', time() - 42000,
//        $params["path"], $params["domain"],
//        $params["secure"], $params["httponly"]
//    );
//}
@session_destroy();
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>退出</title>
  </head>
  <body>
  <h1>退出</h1>
  <div><?php echo $errorMessage; ?></div>
  <ul>
  <li><a href="login.php">前往登录</a></li>
  </ul>
  </body>
</html>