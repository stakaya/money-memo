<?php
    header('Content-type:application/x-ofx');
    echo '<?OFX OFXHEADER="200" VERSION="200" SECURITY="NONE" OLDFILEUID="NONE" NEWFILEUID="NONE" ?>' . "\n";
    $date = date('YmdHms');
    $data = file_get_contents('money.dat');
?>
<OFX>
  <SIGNONMSGSRSV1>
    <SONRS>
      <STATUS>
        <CODE>0</CODE>
        <SEVERITY>INFO</SEVERITY>
      </STATUS>
      <DTSERVER><?= $date ?>[+9:JST]</DTSERVER>
      <LANGUAGE>JPN</LANGUAGE>
      <FI>
        <ORG>Monysong</ORG>
        <FID>00000</FID>
      </FI>
    </SONRS>
  </SIGNONMSGSRSV1>
  <BANKMSGSRSV1>
    <STMTTRNRS>
      <TRNUID>0</TRNUID>
      <STATUS>
        <CODE>0</CODE>
        <SEVERITY>INFO</SEVERITY>
      </STATUS>
      <STMTRS>
        <CURDEF>JPY</CURDEF>
        <BANKACCTFROM>
          <BANKID>Monysong</BANKID>
          <ACCTID>00000-000000</ACCTID>
          <ACCTTYPE>CHECKING</ACCTTYPE>
        </BANKACCTFROM>
        <BANKTRANLIST>
          <DTSTART>20090701000000[+9:JST]</DTSTART>
          <DTEND><?= $date ?>[+9:JST]</DTEND>
          <?= $data ?>
        </BANKTRANLIST>
      </STMTRS>
    </STMTTRNRS>
  </BANKMSGSRSV1>
</OFX>
