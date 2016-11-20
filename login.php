<!-- 最初の画面 ログイン画面なので誰でも閲覧可能 -->
<!-- <DB→test1  table→campaign> -->

<?php
require_once('config.php');
require_once('functions.php');

session_start();
//何かしら$_SESSIONに入力すると値が入ってしまうので、index.phpに飛んでしまう
//仮に$_SESSION['id'] = 'dede';を書くとindex.phpに飛んでしまう。入力はname,passwordに限定させる。
//$_SESSION['id'] = 'dede';

if (!empty($_SESSION['id']))
{
    header('Location: index.php');
    exit;
}
//91行目でsubmitされた値がpostされたら
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = array();

    // バリデーション
    if ($email == '')
    {
        $errors['email'] = 'メールアドレスが未入力です';
    }

    if ($password == '')
    {
        $errors['password'] = 'パスワードが未入力です';
    }

    // バリデーション突破後
    if (empty($errors))
    {
        //$chusen = makeRandNum_1();
        //$_SESSION['chusen_number'] = $chusen;
        $dbh = connectDatabase();
        $sql = "select * from campaign where email = :email and password = :password";
        $stmt = $dbh->prepare($sql);
//値をbindする
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->execute();
//fetchは該当するレコードが合った場合、1行分取ってきてくれるということ。それを$rowという配列に格納する
        $row = $stmt->fetch();


        //var_dump($row);
        //echo '<hr>';
        //var_dump($errors);
      //  header('Location: login.php');
      //  exit;

//$rowで何か結果が入っていたとする
         if ($row)
        {
//[超重要]$_SESSION['id'] に $row['id']という値を持たせてindex.phpに飛ばす
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
            exit;
        }
        else
        {
            echo 'ログインできません';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン画面です！</h1>
<form action = "" method="post">
       メールアドレス:<input type="text" name="email">
        <?php if ($errors['email']) : ?>
            <?php echo h($errors['email']) ?>
        <?php endif; ?>
        <br>
        結果確認用パスワード: <input type="text" name="password">
        <?php if ($errors['password']) : ?>
            <?php echo h($errors['password']) ?>
        <?php endif; ?>
        <br>

      <input type="submit" value = "ログイン">
    </form>
    <a href="oubo.php">応募画面はこちら</a>
</body>
</html>