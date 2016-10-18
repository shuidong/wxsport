<html>
  <meta charset="UTF-8">
  <head>
    <title>添加用户</title>
  </head>
  <body>
<?php
// require 'password.php';
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
//$mysqli->query("SET timezone = '+8:00'");
$result = mysql_query("SELECT name,password FROM $dbUserTbl");
if (!$result) {
    die('SELECT查询失败。'.mysql_error());
}

$name = $_POST['name'];
$realName = $_POST['realName'];
$password = $_POST['password'];
$hashpass = $password;//password_hash($password, PASSWORD_DEFAULT);
$avatar = "";
try{
  if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
    $password = $_POST['password'];
    $avatar = "./avatar/$name".$_FILES['avatar']['name'];
    $extNm = strtolower(strrchr($avatar, "."));
    //echo $extNm;

    if($extNm <> ".png" && $extNm <> ".jpg" && $extNm <> ".jpeg"){
      die('仅支持上传png，jpg，jpeg格式的图片！<br><a href="regist.html">返回注册</a>');
    }
    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
  }
}catch(Exception $e) {
  echo '错误：', $e->getMessage().PHP_EOL;
}



$sql = "INSERT INTO t_users (name, password, realName, avatar) VALUES ('$name','$hashpass', '$realName', '$avatar')";
$result_flag = mysql_query($sql);

if (!$result_flag) {
    die('INSERT失败。可能是已经存在同名的用户。请换一个用户名。。<br><a href="regist.html">戻る</a>');
}

print('<p>' . $name . '用户注册成功。</p>');

$close_flag = mysql_close($link);

?>
  <a href="login.php">前往签到</a>
  </body>
</html>