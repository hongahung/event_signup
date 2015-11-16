<?php
//-----------------------------------------------------------------------------
// signup_post.php 「Top50珠寶設計名家」報名
// Honga@2015-10-16
//-----------------------------------------------------------------------------

//程式可存放於任何路徑, 起始皆使用絕對路徑, 執行起始initial.inc.php
include_once("initial.inc.php");

//參數設定---------------------------------------------------------------------

$error = "";
$msg = "";

//程式開始---------------------------------------------------------------------

/*
if ($_POST['brand_name'] == "") {
	$error .= "．品牌不能空白\n";
}
*/
if ($_POST['name'] == "") {
	$error .= "● 姓名不能空白\n";
}
if (strlen($_POST['mobile_zone']) != 4 or !preg_match('/^([0-9]+)$/', $_POST['mobile_zone'])
	or strlen($_POST['mobile']) != 6 or !preg_match('/^([0-9]+)$/', $_POST['mobile'])
) {
	$error .= "● 手機不能空白或格式錯誤\n";
}
if (strlen($_POST['phone_zone']) < 2 or !preg_match('/^([0-9]+)$/', $_POST['phone_zone'])
	or strlen($_POST['phone']) < 6 or !preg_match('/^([0-9]+)$/', $_POST['phone'])
) {
	$error .= "● 電話及區碼不能空白或格式錯誤\n";
}
if (strlen($_POST['fax_zone']) > 0 and !preg_match('/^([0-9]+)$/', $_POST['fax_zone'])
	or strlen($_POST['fax']) > 0 and !preg_match('/^([0-9]+)$/', $_POST['fax'])
) {
	$error .= "● 傳真及區碼格式錯誤\n";
}
if ($_POST['city_zip'] == "" or $_POST['zip'] == "") {
	$error .= "● 縣市及地區未選擇\n";
}
if ($_POST['address'] == "") {
	$error .= "● 地址不能空白\n";
}
if ($_POST['address'] != "" and $_POST['address'] == $_POST['address_check']) {
	//與自動帶入的欄位一致, 代表後面路街完整地址沒填寫
	$error .= "● 請填寫完整地址\n";
}
if ($_POST['email'] == "" or !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$error .= "● Email未填或格式錯誤\n"; 
}
/*
if ($_POST['message'] == "") {
	$error .= "● 訊息留言不能空白\n";
}
*/
     
//錯誤檢查完畢---------------------------------------------------------------------
if ($error == "") {

	//寫入資料庫
	$create_time = date("Y-m-d H:i:s");
	if ($error == "") {
		$sql = "INSERT `event_signup` (
			event_id,
			brand_name,
			name,
			mobile_zone,
			mobile,
			phone_zone,
			phone,
			fax_zone,
			fax,
			contact_time,
			city_zip,
			zip,
			address,
			email,
			message,
			create_time,
			create_ip
		) VALUES (
			'".$_POST['event_id']."',
			'".$_POST['brand_name']."',
			'".$_POST['name']."',
			'".$_POST['mobile_zone']."',
			'".$_POST['mobile']."',
			'".$_POST['phone_zone']."',
			'".$_POST['phone']."',
			'".$_POST['fax_zone']."',
			'".$_POST['fax']."',
			'".$_POST['contact_time']."',
			'".$_POST['city_zip']."',
			'".$_POST['zip']."',
			'".$_POST['address']."',
			'".$_POST['email']."',
			'".$_POST['message']."',
			'".$create_time."',
			'".$_SERVER['REMOTE_ADDR']."'
		)";
		$result = db_query($sql);
	
		//寄出通知信----------------------------------------------------------------
	
		//收信人
		$receiver_name = $_POST['name'];
		$receiver_email = $_POST['email'];

		//信件主旨
		$mail_subject = "感謝您參加「Top50珠寶設計名家」，您已經完成回覆表單";

		//信件內容範本
		$mail_body = '
感謝您參加「Top50珠寶設計名家」，您已經完成回覆表單

在此確認收到您的資料如下：
品牌名稱：<{$brand_name}>
姓名：<{$name}>
手機：<{$mobile_zone}>-<{$mobile}>
電話：<{$phone_zone}>-<{$phone}>
傳真：<{$fax_zone}>-<{$fax}>
可聯絡時間：<{$contact_time}>
郵遞區號：<{$city_zip}>, <{$zip}>
地址：<{$address}>
Email：<{$email}>
訊息留言：<{$message}>
填寫時間：<{$create_time}>

我們將有專人與您聯絡，謝謝。

----
<{$website_name}>
網址 : <{$homepage_url}>
<{$service_name}>
客服信箱 : <{$service_email}>
客服電話 : <{$service_phone}>
		';
		
		$mail_body = str_replace('<{$name}>', $receiver_name, $mail_body);
		$mail_body = str_replace('<{$email}>', $receiver_email, $mail_body);
		$mail_body = str_replace('<{$brand_name}>', $_POST['brand_name'], $mail_body);
		$mail_body = str_replace('<{$name}>', $_POST['name'], $mail_body);
		$mail_body = str_replace('<{$mobile_zone}>', $_POST['mobile_zone'], $mail_body);
		$mail_body = str_replace('<{$mobile}>', $_POST['mobile'], $mail_body);
		$mail_body = str_replace('<{$phone_zone}>', $_POST['phone_zone'], $mail_body);
		$mail_body = str_replace('<{$phone}>', $_POST['phone'], $mail_body);
		$mail_body = str_replace('<{$fax_zone}>', $_POST['fax_zone'], $mail_body);
		$mail_body = str_replace('<{$fax}>', $_POST['fax'], $mail_body);
		$mail_body = str_replace('<{$contact_time}>', $_POST['contact_time'], $mail_body);
		
		//縣市兩階層值
		$city_zip_part = explode(".", $_POST['city_zip']);
		$city_zip = $city_zip_fields[$city_zip_part[0]];
		if ($city_zip != $city_zip_fields[$_POST['city_zip']]) {
			//若縣市兩階名稱不相同, 才加上第二階的名稱, ex: 嘉義市嘉義市
			$city_zip .= $city_zip_fields[$_POST['city_zip']];
		}
		
		$mail_body = str_replace('<{$city_zip}>', $city_zip, $mail_body);
		$mail_body = str_replace('<{$zip}>', $_POST['zip'], $mail_body);
		$mail_body = str_replace('<{$address}>', $_POST['address'], $mail_body);
		$mail_body = str_replace('<{$email}>', $_POST['email'], $mail_body);
		$mail_body = str_replace('<{$message}>', $_POST['message'], $mail_body);
		$mail_body = str_replace('<{$create_time}>', $create_time, $mail_body);

		//系統參數 參數合成
		$mail_body = str_replace('<{$website_name}>', $website_name, $mail_body);
		$mail_body = str_replace('<{$service_name}>', $service_name, $mail_body);
		$mail_body = str_replace('<{$service_email}>', $service_email, $mail_body);
		$mail_body = str_replace('<{$service_phone}>', $service_phone, $mail_body);
		$mail_body = str_replace('<{$homepage_url}>', $absolute_homepage_url, $mail_body);
		
		$to = array(
			$receiver_email => $receiver_name,
		);
		//$options['is_html'] = ture;
		$options['add_bcc'] = array(
			"honga@4c99.com" => "Honga",
			//"service@4c99.com" => "Service",
		);
		
		//使用phpmailer發信
		include_once($includes_path."phpmailer.inc.php");
		$mail_result = phpmailer($to, $mail_subject, $mail_body, $options);
		
		//回傳資料 
		//$value['name'] = $_POST['name'];
	}
}

//結果輸出---------------------------------------------------------------------

//輸出json, 回傳給ajaxfileupload.js
$result = array(
	'error' => $error,
	'msg' => $msg,
	'value' => $value,
);
echo json_encode($result);


exit;

?>