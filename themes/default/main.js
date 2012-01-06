/* request object */
function createObject() {
	var request_type;
	var browser = navigator.appName;
	
	if(browser == "Microsoft Internet Explorer"){
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		request_type = new XMLHttpRequest();
	}
	
	return request_type;
}




/* doLogin request */
var nocache = 0;
function doLogin() {
  var msg = '';
  var http = createObject();

  if(http) {
	if(document.getElementById('login_user_name').value=='') {
		document.getElementById('login-error').innerHTML = 'Enter your user name';
		document.getElementById('login_user_name').style.border='2px solid red';
	}

	if(document.getElementById('login_user_password').value=='') {
		document.getElementById('login-error').innerHTML = 'Enter your password';
		document.getElementById('login_user_password').style.border='2px solid red';
	}

	if(msg) {
		document.getElementById('login-error').style.display = 'block';
		document.getElementById('login-error').innerHTML = msg;
	} else {
	
		var name = encodeURI(document.getElementById('login_user_name').value);
		var psw = encodeURI(document.getElementById('login_user_password').value);
		var nocache = Math.random();
		var ltime = new Date().getTime();
		var url = "./index.php?doLogin=1";
		var params = "login_user_name="+name+"&login_user_password="+psw+"&login_time="+ltime+"nocache="+nocache;
		http.open("POST", url, true);

		
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//http.setRequestHeader("Content-length", params.length);
		//http.setRequestHeader("Connection", "close");

		http.onreadystatechange = function() {
		
			if(http.readyState == 4 && http.status == 200) {
				// calculate result
				result = http.responseText.substring(0, 4);
				resultLen = http.responseText.length;
				resultText = http.responseText.substring(5, resultLen);
				if(result=='true') {
					document.getElementById('login-form').innerHTML = resultText;
				} else {
					document.getElementById('login-error').innerHTML = resultText;
				}
			}
		}
		
		http.send(params);
	}
  }
}