<?php
// DB接続
function connectDatabase()
{
  try
  {
    return new PDO(DSN, USER, PASSWORD);
  }
  catch (PDOException $e)
  {
    echo $e->getMessage();
    exit;
  }
}
// エスケープ処理
function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}



//ランダム文字列生成 (数字) $length: 生成する文字数
//function makeRandNum($length) {   →これでもOK
function makeRandNum() {
  for ($i = 0; $i < 7; $i++) {
//randはrandomの略(0~9のランダム)
    $num = rand(0, 9);
//ドットでつなげていく為.を入れている。ドットがないと最初か最後の一桁しか表示されない。
    $r_str .= $num;
  }
//↓returnで返してきた結果をmakeRandNumに返している。
  return $r_str;
}

// * 配列から１つの要素キーを抽選する。
// * $entries: array($key => $weight, ...)
// * 配列の値に抽選の割合(重み)を整数値で指定。
function array_rand_weighted($entries){
    $sum  = array_sum($entries);
    $rand = rand(1, $sum);

    foreach($entries as $key => $weight){
        if (($sum -= $weight) < $rand) return $key;
    }
}

//当たり外れを表示するための関数
function makeRandNum_1() {
  for ($i = 0; $i < 2; $i++) {
//randはrandomの略(0と1のランダム)
    $num = rand(0, 1);
//ドットでつなげていく為.を入れている。ドットがないと最初か最後の一桁しか表示されない。
    $r_str = $num;
  }
//↓returnで返してきた結果をmakeRandNumに返している。
  return $r_str;
}

