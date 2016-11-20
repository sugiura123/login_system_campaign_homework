<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title></title>
  <link href="style.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<h3>応募ありがとうございました。</h3>
確認用パスワードをお控えください。<br>
生成されたパスワードは
<?php echo $_SESSION['password'];?>
です。
</div>
</body>
</html>

