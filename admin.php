<?php
//require 'password.php';
require 'dbConfig.php';

$mysqli = new mysqli($dbIp, $dbUser, $dbPwd);
    if ($mysqli->connect_errno) {
      print('<p>连接数据库发生错误。</p>' . $mysqli->connect_error);
      exit();
    }

$mysqli->select_db($dbNm);
$mysqli->set_charset('utf8');
// $mysqli->query("SET timezone = '+8:00'");

// mysql_set_charset('utf8');
// $mysqli->select_db($dbNm);
$query = "SELECT A.avatar as avatar, A.name as name, A.realName as realName, B.checkinTime as checkinTime FROM $dbUserTbl as A, $dbChkinTbl as B WHERE A.id = B.userId order by B.checkinTime desc";
$result = $mysqli->query($query);
if (!$result) {
  print('查询数据库失败。' . $mysqli->error);
  $mysqli->close();
  exit();
}
?>

<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>签到情况</title>
  </head>
  <body>

<!--
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
  <a href="regist.html">注册用户</a>
  -->
  <table border="1" cellspacing="0" >
  	<tr><td>头像</td><td>昵称</td><td>真名</td><td>签到时间</td></tr>

<?php
while ($row = $result->fetch_assoc()) {

	$imgSrc = "";
	if($row['avatar'] != null || $row['avatar'] != ""){
		$imgSrc = "<img width='30' height='30' src=". $row['avatar'] .">";
	}
	echo "<tr><td>" . $imgSrc . "</td><td>" . $row['name'] . "</td><td>" . $row['realName'] . "</td><td>". $row['checkinTime'] . "</td></tr>";
	//echo $row['avatar'] . "-" . $row['name'] . "-" .$row['checkinTime'] . "-";
}
?>


  </table>

  </body>
</html>



<?php
$mysqli->close();
?>