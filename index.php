<?php
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    header('Content-Type: application/xhtml+xml; charset=UTF-8');
    define('COUNTER','count.dat');
    define('MONEY','money.dat');

    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == '消去') {
            @unlink(MONEY);
            die('消去しました。');
        } elseif ($_POST['submit'] == '登録') {
            $cnt = file_get_contents(COUNTER);
            if ($cnt == '' || $cnt == 999) {
                $cnt = 0;
            }

            $data = $_POST['type' ] . "\t"
                  . date('Ymd') . '-'
                  . sprintf("%03d", $cnt++) . "\t"
                  . $_POST['year']
                  . $_POST['month']
                  . $_POST['day']
                  . "000000\t"
                  . $_POST['money'] . "\t"
                  . $_POST['note' ] . "\n";

            if ($_POST['type'] == 'PAYMENT') {
                $data = '<STMTTRN>'
                      .   '<TRNTYPE>' . $_POST['type'] . '</TRNTYPE>'
                      .   '<DTPOSTED>'. date('Ymd') .'000000[+9:JST]</DTPOSTED>'
                      .   '<TRNAMT>-'. $_POST['money'] .'</TRNAMT>'
                      .   '<FITID>'
                      .    $_POST['year'] . $_POST['month'] . $_POST['day']
                      .    '-' . sprintf("%03d", $cnt++)
                      .   '</FITID>'
                      .   '<NAME>' . $_POST['note'] . '</NAME>'
                      . '</STMTTRN>';
            } else {
                $data = '<STMTTRN>'
                      .   '<TRNTYPE>' . $_POST['type'] . '</TRNTYPE>'
                      .   '<DTPOSTED>'. date('Ymd') .'000000[+9:JST]</DTPOSTED>'
                      .   '<TRNAMT>'. $_POST['money'] .'</TRNAMT>'
                      .   '<FITID>'
                      .    $_POST['year'] . $_POST['month'] . $_POST['day']
                      .    '-' . sprintf("%03d", $cnt++)
                      .   '</FITID>'
                      .   '<NAME>' . $_POST['note'] . '</NAME>'
                      . '</STMTTRN>';
            }

            if (($fp = fopen(COUNTER, 'w'))) {
                fwrite($fp, "$cnt");
                fclose($fp);
            }

            if (($fp = fopen(MONEY, 'a'))) {
                fwrite($fp, $data);
                fclose($fp);
            }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>マネーメモ</title>
    <style type="text/css">
    <![CDATA[
        a:link{color:#ffcc33;}
        a:visited{color:#ffcc33;}
    ]]>
    </style>
  </head>
  <body style="color:#333333;">
    <div style="text-align:center;">マネーメモ</div>
    <hr style="border-style:solid;border-color:#ffcc33;" />
    <form action="" method="post">
      <div style="text-align:left;font-size:xx-small;">
        <blockquote>
          種別
          <select name="type">
            <option value="PAYMENT" selected="selected">出金</option>
            <option value="DEP">入金</option>
          </select><br />
          日付
          <input style="-wap-input-format:'*<ja:n>'" type="text" name="year"  size="4" maxlength="4" value="<?= date('Y') ?>"/>年
          <input style="-wap-input-format:'*<ja:n>'" type="text" name="month" size="2" maxlength="2" value="<?= date('m') ?>"/>月
          <input style="-wap-input-format:'*<ja:n>'" type="text" name="day"   size="2" maxlength="2" value="<?= date('d') ?>"/>日<br />
          金額
          <input style="-wap-input-format:'*<ja:n>'" type="text" name="money" size="9" maxlength="6" value=""/>円<br />
          備考
          <input type="text" name="note"  size="18" maxlength="30" value=""/><br />
        </blockquote>
      </div>
      <div style="text-align:center;font-size:xx-small;">
        <input type="submit" name="submit" value="登録"/>
        <input type="submit" name="submit" value="消去"/>
      </div>
    </form>
    <hr style="border-style:solid;border-color:#ffcc33;" />
  </body>
</html>
