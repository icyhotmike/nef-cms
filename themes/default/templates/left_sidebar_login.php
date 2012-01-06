<?php
global $nefcms_userName, $nefcms_userLoginTime;
?>
<div id="login-form">
<form action="javascript:doLogin()" method="POST">
<input type="hidden" name="doLogin" value="1">
<div class="ribbon-wrapper">

 <div class="ribbon-front">
		<h2>Login</h2>
	</div>
	<div class="ribbon-edge-bottomleft"></div>
	<div class="ribbon-back-left"></div>
 </div>
 <div class="ribbon-box">
	<div id="login-error"></div>
	<p>Username: <input type="text" maxlength="32" name="login_user_name" id="login_user_name"></p>
	<p>Password: <input type="password" maxlength="32" name="login_user_password" id="login_user_password">
	<p><input type="submit" name="login_send" value="Login"> &nbsp; <a href="#">Forgot pass?</a></p>
	<p>New users, <a href="#">Click here to register</a>.</p>
 </div>
 </form>
</div>
 

