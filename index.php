<!-- ログイン出来た人のみ閲覧可能 -->
<?php
require_once('config.php');
require_once('functions.php');
session_start();
//<参考>セッション解除
//$_SESSION = array();
//login.phpから引き継がれた$_SESSION['id']が空であったらlogin.phpに行く。
if (empty($_SESSION['id']))
{
    header('Location: login.php');
    exit;
}
        $dbh = connectDatabase();
        //$_SESSION['id']内の情報の内、idが登録されたidと同じであった場合は、その中のすべての情報を取ってくる。
        $sql = "select * from campaign where id = :id";
        $stmt = $dbh->prepare($sql);
        //:idに $_SESSION['id']を投入する
        $stmt->bindParam(":id", $_SESSION['id']);
        //その後SQLを発行する
        $stmt->execute();
        //SQL発行の結果取ってきた情報を取得fetchする
        $row = $stmt->fetch();
        //var_dump($row);

        // //DBに接続 && 抽選候補となる配列
        // $dbh = connectDatabase() && array_rand_weighted($entries)
        // //$_SESSION['id']内の情報の内、idが登録されたidと同じであった場合は、その中のすべての情報を取ってくる。
        // $sql = "select * from campaign where id = :id";
        // $stmt = $dbh->prepare($sql);
        // //:idに $_SESSION['id']を投入する
        // $stmt->bindParam(":id", $_SESSION['id']);
        // //その後SQLを発行する
        // $stmt->execute();
        // //SQL発行の結果取ってきた情報を取得fetchする
        // $row = $stmt->fetch();
        // var_dump($row);
        // $entries = array(
        //     "アタリ"  => 50,
        //     "ハズレ"  => 50,
        //                 );
        // // 抽選
        // $result_key = array_rand_weighted($entries);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>キャンペーン結果</title>
</head>
<body>
    <h1>キャンペーン結果</h1>
<!--     <?php echo h($result_key) ;?> -->
<!-- $rowの中にはid,name,passwordなどが含まれるので、nameだけを表示させたい時は$row['name']とする -->
    <p><?php echo h($row['name']) ?>さんとしてログインしています</p>

    <p>キャンペーン結果</p>
    <p class="result">
    <?php if ($row['result'] == 1): ?>
    　おめでとうございます！<br>　当たりです！
    <?php else: ?>
    　残念... ハズレです。
    <?php endif ?>
<br>
<a href="logout.php">ログアウト</a><br>
</body>
</html>