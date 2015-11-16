<?php

//前台程式為了網友在公用電腦的安全性, 及show/hide layer在上一頁下一頁瀏覽後亂掉的問題
//避免initial.inc.php啟動網頁程式 post模式 暫存, 此處先設定強制不允許暫存
$no_cache = true;

//程式可存放於任何路徑, 起始皆使用相對路徑執行initial.inc.php
//再由initial.inc.php設定含括正確的initial.inc.php位置
//以簡化以後將整批scripts移動至任何目錄後, 需大批修改路徑設定
include_once("../../h/admin/initial.inc.php");

//調整路徑
$upload_path = "/2015momsday/upload/"; //存檔路徑, 相對路徑值保存於資料庫中, 檔案存取需加上 $_SERVER['DOCUMENT_ROOT'], URL連結需加上 http://$_SERVER['HTTP_HOST']
$upload_tmp_path = "/2015momsday/upload_tmp/"; //暫存檔相對路徑, 後台

?>