<?php
//-----------------------------------------------------------------------------
// index.php 「Top50珠寶設計名家」
// Honga@2015-10-16
//-----------------------------------------------------------------------------

//test
//test pc
//test mac

//this is macbook air

//程式可存放於任何路徑, 起始皆使用絕對路徑, 執行起始initial.inc.php
include_once("initial.inc.php");

//縣市郵遞區號-----------------------------------------------------------------------------
//選項拆分成2層array
foreach ($city_zip_fields as $k => $v) {
	$k_array = explode(".", $k);
	if (count($k_array) == 1) {
		$city_zip_0[$k_array[0]] = $v;
	} else if (count($k_array) == 2) {
		$city_zip_1[$k_array[0]][$k] = $v; //layer $k值 使用完整值 ex 1.10, 以便寫入DB 
	}
}
//-----------------------------------------------------------------------------

?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="event_signup.css" rel="stylesheet" type="text/css">
<title>Top50珠寶設計名家</title>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script src="js/css3-mediaqueries.js"></script>
<![endif]-->
<!--[if IE]>
<link rel="stylesheet" href="set-ie.css" />
<![endif]-->

<!-- facebook website admin -->
<meta property="fb:admins" content="652766281" />
<!-- facebook open graph -->
<meta property="og:type" content="website" /> 
<meta property="og:url" content="<?php echo $absolute_homepage_url.$_SERVER['REQUEST_URI']; ?>">
<meta property="og:title" content="Top50珠寶設計名家 - 4C99珠寶網">
<meta property="og:description" content="4c99 珠寶網誠摯的邀請您參加Top50珠寶設計名家">
<meta property="og:image" content="http://www.4c99.com/event_signup/fbimg.png">
<!-- facebook app -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1566352943635495',
      xfbml      : true,
      version    : 'v2.3'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/zh_TW/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- /facebook -->

<!--jQuery-->
<script src="http://code.jquery.com/jquery-1.11.2.js"></script>

<!-- jquery.form -->
<script type="text/javascript" src="<?php echo $modules_url; ?>/jquery.form/jquery.form.min.js"></script>

<script type="text/javascript">

//city_zip---------------------------------------------------------------------
var city_zip_0_json = <?php echo json_encode($city_zip_0); ?>;
var city_zip_json = <?php echo json_encode($city_zip_1); ?>;
									
function change_options(val, myobj) {
	var num = 0;
	myobj.options[num] = new Option('-', val);
	num++;
	for (i in city_zip_json[val]) {
		myobj.options[num] = new Option(city_zip_json[val][i], i);
		num++;
	}
	myobj.length = num;
}

function change_city_zip(val, myobj1, myobj2, myobj3, myobj4) {
	var val_array = val.split('.');
	myobj2.value = val_array[1];
	myobj3.value = val_array[1] + ' ' + city_zip_0_json[myobj1.value];
	if (city_zip_0_json[myobj1.value] != city_zip_json[myobj1.value][val]) {
		//若縣市兩階名稱不相同, 才加上第二階的名稱, ex: 嘉義市嘉義市
		myobj3.value = myobj3.value + city_zip_json[myobj1.value][val];
	}
	//後端檢查用欄位值
	myobj4.value = myobj3.value;
}

//input---------------------------------------------------------------------
function mobile_zone_check() {
	if (document.forms['event_form'].mobile_zone.value.length == 4) {
		document.forms['event_form'].mobile.focus();
	}
}
function phone_zone_check() {
	if (document.forms['event_form'].phone_zone.value.length == 3) {
		document.forms['event_form'].phone.focus();
	}
}
function fax_zone_check() {
	if (document.forms['event_form'].fax_zone.value.length == 3) {
		document.forms['event_form'].fax.focus();
	}
}

//form post---------------------------------------------------------------------
$(document).ready(function() { 
	// bind form using ajaxForm 
	$('#event_form').ajaxForm({ 
		// target identifies the element(s) to update with the server response  
		// success identifies the function to invoke when the server response 
		// has been received; here we apply a fade-in effect to the new content 
		dataType: 'json',
		success: function(data, status) { 
			if (typeof(data.error) != 'undefined') {
				if (data.error != '') {
					//alert(data.error);
					//kcaptcha_change();
					$('#errorMsg').html(data.error.replace(/\n/g, "<br />"));
					$('#errorMsg').fadeIn('slow');
					$('html,body').animate({scrollTop: $("#errorMsg").offset().top},'slow'); //function goToByScroll(id){}
				} else {
					//alert('謝謝您的寶貴意見'); 
					$('#intro_content').hide();
					$('#errorMsg').hide();
					$('#event_form').hide();
					$('#successMsg').fadeIn('slow'); 
					$('html,body').animate({scrollTop: $("#successMsg").offset().top},'slow'); //function goToByScroll(id){}
				}
			}
		} 
	});
});
</script>
</head>

<body>
<!--header-->
<div class="header">
<!--logo-->
	<div class="logo">
		<a href="http://www.4c99.com/">
			<img src="img/4c99logo.png" alt="4C99珠寶網 好珠寶在這裡"/>
		</a>
		<div class="fb_share">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="https://www.facebook.com/love4c99" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
	</div>
<!--/logo-->
</div>
<!--/header-->
<!--hero-content-->
<div class="hero_content">
	<div class="block">
		<div class="titleImg">
			<img src="img/title.png" width="620" height="117" alt=""/>
		</div>
		<div class="designer">
			<img src="img/designer.png" width="1038" height="460" alt=""/>
		</div>
	</div>
</div>
<!--/hero-content-->
<!--content-->
<div id="intro_content" class="content">
	<p class="text4clogo">恭喜您，目前榮登台灣最佳的珠寶設計師名單！
	因此，<img src="img/4c99logo_2.png" width="64" height="22" alt=""/>珠寶網很榮幸為此特別製作專頁，打造一個無國界的網路舞台!
	</p>
	<p class="focus">- 台灣TOP珠寶設計師 -</p>
	<p>讓您更多被看見及肯定，請務必重視我們的邀請。如果您願意進一步了解，請填寫以下表格並送出或是聯絡我們<span class="textBlock">( 02 ) 2930-0502</span>分機 <span class="textBlock">111</span>由專人為您服務，謝謝您!</p>
</div>
<div class="member_form">
	<div class="formName">回覆表單填寫</div>
	<div id="errorMsg" style="display:none"></div>
	<form id="event_form" action="includes/signup_post.php" method="post">
		<input type="hidden" name="event_id" value="1">
		<ul>
			<li>
				<div class="brand_nameTitle">品牌名稱</div>
				<div class="brand_name">
					<input type="text" name="brand_name" value="" placeholder="您的品牌" onfocus="this.placeholder = ''" onblur="this.placeholder = '您的品牌'">
				</div>
			</li>
			<li>
				<div class="nameTitle">設計師</div>
				<div class="name">
					<input type="text" name="name" value="" placeholder="* 您的姓名" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 您的姓名'">
				</div>
			</li>
			<li>
				<div class="mobileTitle">手機</div>
				<div class="mobile">
					<input type="text" name="mobile_zone" value="" placeholder="* 前四碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 前四碼'" maxlength="4" onKeyUp="mobile_zone_check()">
					<span>-</span>
					<input type="text" name="mobile" value="" placeholder="* 後六碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 後六碼'" maxlength="6">
				</div>
			</li>
			<li>
				<div class="phoneTitle">電話</div>
				<div class="phone">
					<input type="text" name="phone_zone" value="" placeholder="* 區碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 區碼'" maxlength="3" onKeyUp="phone_zone_check()">
						<span>-</span>
						<input type="text" name="phone" value="" placeholder="* 電話號碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 電話號碼'" maxlength="8">
				</div>
			</li>
			<li>
				<div class="faxTitle">傳真</div>
				<div class="fax">
					<input type="text" name="fax_zone" value="" placeholder="區碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '區碼'" maxlength="3" onKeyUp="fax_zone_check()">
					<span>-</span>
					<input type="text" name="fax" value="" placeholder="傳真號碼" onfocus="this.placeholder = ''" onblur="this.placeholder = '傳真號碼'" maxlength="8">
				</div>
			</li>
			<li>
				<div class="contactTitle">可聯絡時間</div>
				<div class="contact_time">
					<input type="text" name="contact_time" value="" placeholder="可聯絡時間" onfocus="this.placeholder = ''" onblur="this.placeholder = '可聯絡時間'">
				</div>
			</li>
			<li>
				<div class="addressTitle">地址</div>
					<div class="addressBlock">
						<div class="country_info">
							<select id="city" name="city_zip_0" onChange="change_options(this.value, this.form.city_zip)">
								<option value="" >* 縣市</option>
								<?php
								foreach ($city_zip_0 as $k => $v) {
									?><option value="<?php echo $k; ?>"><?php echo htmlspecialchars($v); ?></option><?php
								}
								?>
							</select>
							<select id="region" name="city_zip" onChange="change_city_zip(this.value, this.form.city_zip_0, this.form.zip, this.form.address, this.form.address_check)">
								<option value="" >* 地區</option>
							</select>
						</div>
						<div class="city_zipBlock">
							<div class="city_zipTitle">郵遞區號</div>
							<div class="zip">
								<input type="text" name="zip" value="" placeholder="* 請選擇縣市及地區" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 請選擇縣市及地區'" readonly>
							</div>
						</div>
						<div class="address">
						<input type="hidden" name="address_check">
						<input type="text" name="address" value="" placeholder="* 您的詳細地址" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 您的詳細地址'">
					</div>
				</div>
			</li>
			<li>
				<div class="emailTitle">Email：</div>
				<div class="email">
					<input type="text" name="email" value="" placeholder="* 輸入Email" onfocus="this.placeholder = ''" onblur="this.placeholder = '* 輸入Email'">
				</div>
			</li>
			<li>
				<div class="qaTitle">
					Q & A
				</div>
				<div class="message">
					<textarea name="message" placeholder="訊息留言" onfocus="this.placeholder = ''" onblur="this.placeholder = '訊息留言'"></textarea>
				</div>
			</li>
		</ul>
		<input type="submit" value="上傳" class="b_btn_green">
	</form>
	<div id="successMsg" style="display:none;">
		<ul>
			<li><p>感謝您參加 『Top50珠寶設計名家』 ，您已經完成回覆表單，我們將有專人與您聯絡。</p></li>
			<li><a class="b_btn_pink" href="http://www.4c99.com/">去4C99網站逛逛</a></li>
		</ul>
	</div>
</div>
<!--/content-->
<!--footer-->
<div class="footer">4C99珠寶網 版權所有 © 4C99. All Rights Reserved</div>
<!--/footer-->
<?php include $views_path."block_google_analytics.view.htm"; ?>
</body>
</html>
