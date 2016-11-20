<!-- mysql→test1(DB)→campaign(table)
 -->

<?php
require_once('config.php');
require_once('functions.php');

session_start();


//以下の'POST'は133行目のsubmitが押されたら､実行されるという意味
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $checkbox  = $_POST['checkbox'];

    //バリデーションの判定の変数として
    $errors = array();
    // バリデーション echo使わなくても以下のような書き方が可能
    if ($name == '')
    {
        //未入力なら87行目に名前が未入力ですと表示するPHPを挿入
        $errors['name'] = '名前が未入力です';
    }
    if ($email == '')
    {
        //未入力なら95行目にemailが未入力ですと表示するPHPを挿入
        $errors['email'] = 'emailが未入力です';
    }


    if ($number == '')
    {
        //未入力なら104行目に郵便番号が未入力ですと表示するPHPを挿入
        $errors['number'] = '郵便番号は半角数字で入力ください。';
    }

    if (preg_match("/^[0-9]+$/", $number )) {
        $number = $number;
    }
    else{
        $errors['number'] = '郵便番号は半角数字で入力ください。';
    }

    if ($address == '')
    {
        //未入力なら114行目に住所が未入力ですと表示するPHPを挿入
        $errors['address'] = '住所が未入力です';
    }
    if ($checkbox == '')
    {
        //未チェックなら123行目にチェックされてませんと表示するPHPを挿入
        $errors['checkbox'] = 'チェックされていません。';
    }

    if ($email) {
    $dbh = connectDatabase();
    $sql = "select * from campaign where email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $errors['email']  = "このメールアドレスは既に登録されています";
              }
                }


// バリデーション突破後
    if (empty($errors))
    {
        //ランダムパスワード生成する
        $random_pass = makeRandNum();
        //以下の['password']は['password123']でもOKだが、oubo_kannryo.phpの17行目と合わせる
        $_SESSION['password'] = $random_pass;
        $dbh = connectDatabase();
        $sql = "insert into campaign (name, email, number,address, password, result  ) values
                (:name, :email, :number, :address, :password, :result );";
//なぜこの時点で$nameではなく:nameにする??→発行するsql文に$を入れると認識しない。なのでbindParamで:の内容を入力する。
        $result   = mt_rand(0, 1);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":number", $number);
        $stmt->bindValue(":address", $address);
        $stmt->bindValue(":password", $random_pass);
        $stmt->bindParam(":result", $result);
        $stmt->execute();
        var_dump($_POST);
        echo '<hr>';
        var_dump($errors);

//function.php でmakeRandNum($length) を実行してランダム数字を発行してincert intoのSQL分も同時に発行
//insert into でデータを登録するだけでなくoubo_kannryo.phpにも飛ぶようにする
        header('Location: oubo_kannryo.php');
        exit;
    }
}
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
<form action="" method="post">
<h3>お問い合わせ</h3>
<table>
  <tr>
    <th>お名前 </th>
    <td>
        <input type="text" name="name" value="<?php echo h($name) ?>">
        <?php if ($errors['name']): ?>
        <div class="error"><?php echo h($errors['name']) ?></div>
        <?php endif ?>
    </td>
  </tr>
  <tr>
    <th>メールアドレス </th>
    <td>
        <input type="text" name="email" value="<?php echo h($email) ?>">
        <?php if ($errors['email']): ?>
        <div class="error"><?php echo h($errors['email']) ?></div>
        <?php endif ?>
    </td>
  </tr>
  <tr>
    <th>郵便番号 </th>
    <td>
        <input type="text" name="number" value="<?php echo h($number) ?>">
        <?php if ($errors['number']): ?>
        <div class="error"><?php echo h($errors['number']) ?></div>
        <?php endif ?>
    </td>
  </tr>
  <tr>
    <th>住所</th>
    <td>
        <input type="text" name="address" value="<?php echo h($address) ?>">
        <?php if ($errors['address']): ?>
        <div class="error"><?php echo h($errors['address']) ?></div>
        <?php endif ?>
    </td>
  </tr>
    <tr>
    <th>応募に同意する</th>
    <td>
        <input type="checkbox" name='checkbox[]' value='checkbox'>
        <?php if ($errors['checkbox']): ?>
        <div class="error"><?php echo h($errors['checkbox']) ?></div>
        <?php endif ?>
    </td>
  </tr>
</table>

<br>
応募規約
<br>
ドーナツは抽選で当たった方にプレゼントします。
<br>
<div style="margin-left: 250px;"><button type="submit" style="background: #367ac3;">
上記内容でキャンペーンに応募する</button></div>
</form>
</div>
</body>
</html>