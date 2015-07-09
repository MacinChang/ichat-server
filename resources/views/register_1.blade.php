<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>注册</title>
	<link rel="stylesheet" type="text/css" href="css/resgister.css">
</head>
<body>
   <header>
		<p>iChat</p>
		<span></span>
	</header>
	<div class="container">
		 <div class="form">
		 	<form method="post" action="register">
		    <div>
		    <span class="star">*</span><label for="email">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称&nbsp;:</label><input name = "nick" type="text" id="email" autocomplete="off"><span id="wemail"></span>
		    </div>
		    <div>
		     <span class="star">*</span><label for="tel">手&nbsp;&nbsp;&nbsp;机&nbsp;&nbsp;&nbsp;号&nbsp;:</label><input name = "phone"  type="tel" id="tel"><span id="wtel"><i id="tel_bg"></i>手机号格式错误</span>
		    </div>
		    <div>
		    	<span class="star">*</span><label for="">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码&nbsp;:</label><input name = "password" type="password" id="pwd_1"><span id="wpwd_1"><i id="pwd_bg"></i>密码不能为空</span>
		    </div>
		    <div>
		    	<span class="star">*</span><label>确&nbsp;认&nbsp;密&nbsp;码&nbsp;:</label><input type="password" id="pwd_2"><span id="wpwd_2"><i id="checkpwd_bg"></i>两次输入的密码不一致</span>
		    </div>

		    <div class="btn">
		      <button type="submit">注&nbsp;&nbsp;册</button>
		    </div>
		    </form>
		 </div>
	 </div>
   <footer>
  	<span>软工1304</span>
  </footer>
  </body>
  <script src="js/regisiter.js"></script>
  </html>