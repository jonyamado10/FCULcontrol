<?php
$curl = curl_init();
curl_setopt_array(
  $curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'controlodeacessos.azurewebsites.net/Cron/corrige_acessos'
  )
);
curl_exec($curl);
curl_close($curl);
?>