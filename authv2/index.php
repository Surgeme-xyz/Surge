<?php
if(!isset($_GET['forward'])){
   

if(isset($_GET['basic'])){ //Basic version of the login page for compatibility reasons.
die("
<html>
<head>
<title>Surge - Login - Basic</title>
<style>
*{
font-family:Arial, sans-serif;
}
h1{
padding:5px;
}
form{
border-width:1px;
border-style:solid;
border-color:black;
width:fit-content;
}
</style>
</head>
<body>
<h1>Surge - Login</h1>
<hr>
<form action='login/?basic' method='POST'>
<h2>Login</h2>
<hr>
<span style='color:red;'>".@$_GET['error']."</span><br>
<label for='user'>Username:</label>
<input autocomplete='username' name='user' id='user' type='text'/>

<br>

<label for='pass'>Password:</label>
<input autocomplete='current-password' name='pass' id='pass' type='password'/>
<br>
<button type='submit'>Login</button>
<hr>
<a href='register'>Register</a>
<br>
<a href='reset'>Reset my password</a>
<hr>
<a href='?'>Back to full version</a>
</form>
</body>
</html>
"); //Basic version of the login page for compatibility reasons.
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Surge | Sign in</title>
<meta name="title" content="Surge | Sign in" />
<meta name="description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://surgeme.xyz/auth" />
<meta property="og:title" content="Surge | Sign in" />
<meta property="og:description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />
<meta property="og:image" content="https://surgeme.xyz/img/?img=hero.png&width=600&height=600&type=webp&quality=100" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="https://surgeme.xyz/auth" />
<meta property="twitter:title" content="Surge | Sign in" />
<meta property="twitter:description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />
<meta property="twitter:image" content="https://surgeme.xyz/img/?img=hero.png&width=600&height=600&type=webp&quality=100" />

<!-- Meta Tags Generated with https://metatags.io -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
* {
    font-family: -apple-system, BlinkMacSystemFont, "San Francisco", Helvetica, Arial, sans-serif;
    font-weight: 300;
    margin: 0;
}

html, body {
    height: 100vh;
    width: 100vw;
    margin: 0 0;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    background: #f3f2f2;
}

h4 {
    font-size: 24px;
    font-weight: 600;
    color: #000;
    opacity: 0.85;
}

label {
    font-size: 12.5px;
    color: #000;
    opacity: 0.8;
    font-weight: 400;
}

form {
    padding: 40px 30px;
    background: #fefefe;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding-bottom: 20px;
    width: 300px;
}

form h4 {
    margin-bottom: 20px;
    color: rgba(0, 0, 0, 0.5);
}

form h4 span {
    color: rgba(0, 0, 0, 1);
    font-weight: 700;
}

form p {
    line-height: 155%;
    margin-bottom: 5px;
    font-size: 14px;
    color: #000;
    opacity: 0.65;
    font-weight: 400;
    max-width: 200px;
    margin-bottom: 40px;
}

a.discrete {
    color: rgba(0, 0, 0, 0.4);
    font-size: 14px;
    border-bottom: solid 1px rgba(0, 0, 0, 0);
    padding-bottom: 4px;
    margin-left: auto;
    font-weight: 300;
    transition: all 0.3s ease;
    margin-top: 40px;
}

a.discrete:hover {
    border-bottom: solid 1px rgba(0, 0, 0, 0.2);
}

button {
    -webkit-appearance: none;
    width: auto;
    min-width: 100px;
    border-radius: 24px;
    text-align: center;
    padding: 15px 40px;
    margin-top: 5px;
    background-color: #a272ff;
    color: #fff;
    font-size: 14px;
    margin-left: auto;
    font-weight: 500;
    cursor:pointer;
    box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.13);
    border: none;
    transition: all 0.3s ease;
    outline: 0;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 2px 6px -1px rgba(182, 157, 230, 0.65);
}

button:active {
    transform: scale(0.99);
}

.session input {
    font-size: 16px;
    padding: 20px 0px;
    height: 56px;
    border: none;
    border-bottom: solid 1px rgba(0, 0, 0, 0.1);
    background: #fff;
    width: 280px;
    box-sizing: border-box;
    transition: all 0.3s linear;
    color: #000;
    font-weight: 400;
    -webkit-appearance: none;
}

.session input:focus {
    border-bottom: solid 1px rgb(182, 157, 230);
    box-shadow: 0 2px 6px -8px rgba(182, 157, 230, 0.45);
}

.floating-label {
    position: relative;
    margin-bottom: 10px;
    width: 100%;
}

.floating-label label {
    position: absolute;
    top: calc(50% - 7px);
    left: 0;
    opacity: 0;
    transition: all 0.3s ease;
    padding-left: 44px;
}

.floating-label input {
    width: calc(100% - 44px);
    margin-left: auto;
    display: flex;
}

.floating-label .icon {
    position: absolute;
    top: 0;
    left: 0;
    height: 56px;
    width: 44px;
    display: flex;
}

.floating-label .icon svg {
    height: 30px;
    width: 30px;
    margin: auto;
    opacity: 0.15;
    transition: all 0.3s ease;
}

.floating-label .icon svg path {
    transition: all 0.3s ease;
}

.session input:not(:placeholder-shown) {
    padding: 28px 0px 12px 0px;
}

.session input:not(:placeholder-shown) + label {
    transform: translateY(-10px);
    opacity: 0.7;
}

.session input:valid:not(:placeholder-shown) + label + .icon svg {
    opacity: 1;
}

.session input:valid:not(:placeholder-shown) + label + .icon svg path {
    fill: rgb(182, 157, 230);
}

.session input:not(:valid):not(:focus) + label + .icon {
    animation-name: shake-shake;
    animation-duration: 0.3s;
}

@keyframes shake-shake {
    0% { transform: translateX(-3px); }
    20% { transform: translateX(3px); }
    40% { transform: translateX(-3px); }
    60% { transform: translateX(3px); }
    80% { transform: translateX(-3px); }
    100% { transform: translateX(0px); }
}

.session {
    display: flex;
    flex-direction: row;
    width: auto;
    height: auto;
    margin: auto auto;
    background: #ffffff;
    border-radius: 4px;
    box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.12);
}

.left {
    width: 220px;
    height: auto;
    min-height: 100%;
    position: relative;
    background-image: url("/img/?img=authside.png&width=220&height=436&type=webp&quality=80");
    background-size: cover;
    background-color:#e09be8;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
#pagesize{
    position: absolute;
    border-radius:12px;
    background:#fff;
    padding:15px;
    bottom:20px;
    right:20px;
    box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.12);
}
#pagesize-value{
    position: relative;
    bottom: 16px;
}
#register-link,#forgot-link{
    position: absolute;
    bottom: 20px;
}
#forgot-link{
    left:90px;
}
  </style>
</head>
<body>
  <div class="session">
    <div class="left">
    </div>
    <form action="login/<?php if(isset($_GET['forward'])){echo'?forward='.$_GET['forward'];}?>" method='POST' class="log-in" autocomplete="off"> 
      <h4>Welcome to <span>Surge</span></h4><?php
function extractDomain($inputStr) {
    // Regular expression pattern to match domain names
    $pattern = '/(?:https?:\/\/)?(?:www\.)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(?:\/\S*)?/';
    preg_match($pattern, $inputStr, $matches);
    if (!empty($matches[1])) {
        return $matches[1];
    } else {
        return null;
    }
}
      if(isset($_GET['forward'])){
        $domain=extractDomain($_GET['forward']);
        if($domain==''){
            $domain='a Surge service';
        }
        echo '<h4>Login to '.$domain.' with Surge.</h4>';
      }
      ?>
      <p>Welcome back! Log in to your account to access Surge:</p>
      <error style='color:red;' id='error'><?= @$_GET['error']?></error>
      <div class="floating-label">
        <input placeholder="Username" type="text" name="user" id="user" autocomplete="username">
        <label for="user">Username:</label>
        <div class="icon">
<?xml version="1.0" encoding="UTF-8"?>
<svg enable-background="new 0 0 100 100" version="1.1" viewBox="0 0 100 100" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
<style type="text/css">
	.st0{fill:none;}
</style>
<g transform="translate(0 -952.36)">
	<path d="m17.5 977c-1.3 0-2.4 1.1-2.4 2.4v45.9c0 1.3 1.1 2.4 2.4 2.4h64.9c1.3 0 2.4-1.1 2.4-2.4v-45.9c0-1.3-1.1-2.4-2.4-2.4h-64.9zm2.4 4.8h60.2v1.2l-30.1 22-30.1-22v-1.2zm0 7l28.7 21c0.8 0.6 2 0.6 2.8 0l28.7-21v34.1h-60.2v-34.1z"/>
</g>
<rect class="st0" width="100" height="100"/>
</svg>

        </div>
      </div>
      <div class="floating-label">
        <input placeholder="Password" type="password" name="pass" id="password" autocomplete="current-password">
        <label for="password">Password:</label>
        <div class="icon">
          
          <?xml version="1.0" encoding="UTF-8"?>
          <svg enable-background="new 0 0 24 24" version="1.1" viewBox="0 0 24 24" xml:space="preserve"              xmlns="http://www.w3.org/2000/svg">
<style type="text/css">
	.st0{fill:none;}
	.st1{fill:#010101;}
</style>
		<rect class="st0" width="24" height="24"/>
		<path class="st1" d="M19,21H5V9h14V21z M6,20h12V10H6V20z"/>
		<path class="st1" d="M16.5,10h-1V7c0-1.9-1.6-3.5-3.5-3.5S8.5,5.1,8.5,7v3h-1V7c0-2.5,2-4.5,4.5-4.5s4.5,2,4.5,4.5V10z"/>
		<path class="st1" d="m12 16.5c-0.8 0-1.5-0.7-1.5-1.5s0.7-1.5 1.5-1.5 1.5 0.7 1.5 1.5-0.7 1.5-1.5 1.5zm0-2c-0.3 0-0.5 0.2-0.5 0.5s0.2 0.5 0.5 0.5 0.5-0.2 0.5-0.5-0.2-0.5-0.5-0.5z"/>
</svg>
        </div>
        
      </div>
      <button type="submit" onClick="return TrySubmit(this)">Log in</button>
      <?php if(!isset($_GET['forward'])){echo '<a href="?basic"  class="discrete" >Basic page</a>';}else{
        echo '<a class="discrete" ></a>';
      } ?>
      <a href="register/<?php if(isset($_GET['forward'])){echo'?forward='.$_GET['forward'];}?>" class="discrete" id='register-link'>Register</a><a href="forgot/<?php if(isset($_GET['forward'])){echo'?forward='.$_GET['forward'];}?>" class="discrete" id='forgot-link'>Reset my password</a>
    </form>
  </div>
  <div id='pagesize'><?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="44px" height="44px" viewBox="0 0 1224 792" >
<g>
	<path d="M833.556,367.574c-7.753-7.955-18.586-12.155-29.656-11.549l-133.981,7.458l73.733-83.975
		c10.504-11.962,13.505-27.908,9.444-42.157c-2.143-9.764-8.056-18.648-17.14-24.324c-0.279-0.199-176.247-102.423-176.247-102.423
		c-14.369-8.347-32.475-6.508-44.875,4.552l-85.958,76.676c-15.837,14.126-17.224,38.416-3.097,54.254
		c14.128,15.836,38.419,17.227,54.255,3.096l65.168-58.131l53.874,31.285l-95.096,108.305
		c-39.433,6.431-74.913,24.602-102.765,50.801l49.66,49.66c22.449-20.412,52.256-32.871,84.918-32.871
		c69.667,0,126.346,56.68,126.346,126.348c0,32.662-12.459,62.467-32.869,84.916l49.657,49.66
		c33.08-35.166,53.382-82.484,53.382-134.576c0-31.035-7.205-60.384-20.016-86.482l51.861-2.889l-12.616,154.75
		c-1.725,21.152,14.027,39.695,35.18,41.422c1.059,0.086,2.116,0.127,3.163,0.127c19.806,0,36.621-15.219,38.257-35.306
		l16.193-198.685C845.235,386.445,841.305,375.527,833.556,367.574z"/>
	<path d="M762.384,202.965c35.523,0,64.317-28.797,64.317-64.322c0-35.523-28.794-64.323-64.317-64.323
		c-35.527,0-64.323,28.8-64.323,64.323C698.061,174.168,726.856,202.965,762.384,202.965z"/>
	<path d="M535.794,650.926c-69.668,0-126.348-56.68-126.348-126.348c0-26.256,8.056-50.66,21.817-70.887l-50.196-50.195
		c-26.155,33.377-41.791,75.393-41.791,121.082c0,108.535,87.983,196.517,196.518,196.517c45.691,0,87.703-15.636,121.079-41.792
		l-50.195-50.193C586.452,642.867,562.048,650.926,535.794,650.926z"/>
</g>
</svg>

<span id='pagesize-value'>Size: 100%</span><hr><input id='pagesize-slider' min=80 max=200 value=100 type='range' oninput='updateAuthSize(this)'/>
</div>
</body>
<script async defer>
    function TrySubmit(element){
        var correct=true
        if(document.getElementById('user').value.length<1){
correct=false
document.getElementById('error').innerHTML='Username too short.'
}
if(7>document.getElementById('password').value.length){
correct=false
document.getElementById('error').innerHTML='Password too short.'
}
if(correct){
    setTimeout(() => {
        element.setAttribute('disabled','disabled')
    }, 500);
element.innerHTML='Please wait...'
}
        return correct;
    }
    // Set the cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

// Get the cookie value by name
function getCookie(name) {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(';');
    for(var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

function updateAuthSize(element) {
document.getElementById('pagesize-value').innerHTML='Size: '+element.value+'%'
document.getElementsByClassName('session')[0].style='transform:scale('+element.value+'%);'
setCookie('auth-page-size', element.value, 30);
}
if(getCookie('auth-page-size')!==null){
    if(getCookie('auth-page-size')!==100){
document.getElementById('pagesize-slider').value=getCookie('auth-page-size')
updateAuthSize(document.getElementById('pagesize-slider'))
    }
}
    </script>
</html>
