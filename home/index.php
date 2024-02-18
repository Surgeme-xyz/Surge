<?php
$myURL = '/home'; //URL of this script.
if(isset($_GET['token'])){
    header('location: ?');
    die();
}
if(isset($_COOKIE['surge-token'])){
$rawToken=$_COOKIE['surge-token'];
$username=explode(',,!!,,',$rawToken)[0];
$token=explode(',,!!,,',$rawToken)[1];
$dbFilePath = 'D:/Surge/Surge.accdb';
$host = $_SERVER['HTTP_HOST'];

// Split the host name by periods
$parts = explode('.', $host);

// Check if there are enough parts to have a subdomain
if (count($parts) > 2) {
    // Get the subdomain
    $subdomain = $parts[0];
}else{
    $subdomain='';
}
try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example query
    $query = "SELECT * FROM Users";
    $statement = $pdo->query($query);

    // Fetch data
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
       if($row['Username']==$username){
        $displayname=$row['DisplayName'];
        if($token!==$row['AccessToken']){
            header('location: /authv2/?forward='.$myURL);
            die();
        } 
        $thisrow=$row;
       }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
}else{
    header('location: /authv2/?forward='.$myURL);
    die();
}if(!isset($displayname)){
    header('location: /authv2/?forward='.$myURL);
    die();
}
?>



<?php

function redirect($url){
    header('location: '.$url);
    die();
}
?><?php
if(isset($_GET['forward'])){
    header('location: '.$_GET['forward'].'?token='.$_COOKIE['token']);
    die();
}
$colorScheme = isset($_COOKIE['colorScheme']) ? $_COOKIE['colorScheme'] : '';
if(empty($colorScheme)) {
    $colorScheme = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'dark') !== false ? 'dark' : 'light';
}
$verified=True;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Surge | Home" />
    <meta name="description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://surgeme.xyz/" />
    <meta property="og:title" content="Surge | Home" />
    <meta property="og:description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />
    <meta property="og:image" content="https://surgeme.xyz/img/?img=hero.png&width=600&height=600&type=webp&quality=100" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://surgeme.xyz/" />
    <meta property="twitter:title" content="Surge | Home" />
    <meta property="twitter:description" content="🚀 Explore the next level of social networking with Surge! Connect, share, and chat with a vibrant community. 🌈 Unleash your true self, make friends, and discover a world of possibilities. Join Surge now for an electrifying social experience! 💖" />
    <meta property="twitter:image" content="https://surgeme.xyz/img/?img=hero.png&width=600&height=600&type=webp&quality=100" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Surge | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <style>
        .nav-link{
            animation-name:fadein;
            animation-duration:1s;
            animation-fill-mode:forwards;
            animation-iteration-count:1;
        }
        #logo{
            animation-name:fadein;
            animation-duration:1s;
            animation-fill-mode:forwards;
            animation-iteration-count:1;
        }
        @keyframes fadeinblur {
            0%{
                opacity:0;
                filter:blur(20px);
            }
            100%{
                opacity:1;
                filter:blur(0px);
            }
        }
        @keyframes fadein {
            0%{
                opacity:0;
            }
            100%{
                opacity:1;
            }
        }
        notifications{
            animation-name:fadein;
            animation-duration:0.2s;
            animation-fill-mode:forwards;
            animation-iteration-count:1;
        }
        searchuser{
            animation-name:fadeinblur;
            animation-duration:1s;
            animation-fill-mode:forwards;
            animation-iteration-count:1;
        }
        #pfp-drop{
            animation-name:fadein;
            animation-duration:0.2s;
            animation-fill-mode:forwards;
            animation-iteration-count:1;
        }
        #pfp{
            animation-name:dropinside;animation-duration:0.5s;animation-iteration-count:1;animation-fill-mode:forwards; position: relative;
        }
        @keyframes dropin {
            0%{
                top:-100px;
            }
            100%{
                top:0px;
            }
        }        @keyframes dropinside {
            0%{
                right:-200px;
            }
            100%{
                right:0px;
            }
        }
        #page-Home { height: 100%; position: relative; }
        .navbar { background-color: #3498db; animation-name:dropin;animation-duration:0.5s;animation-iteration-count:1;animation-fill-mode:forwards; }
        .navbar-brand { color: #fff; font-weight: bold; }
        .navbar-nav .nav-link { color: #fff; cursor: pointer; position: relative; top: 5px; }
        #logo { max-width: 50px; max-height: 50px; }
        #pfp{
padding-left:15px;
cursor: pointer;
        }
        #username{
            position: relative;
    color: #ffffff80;
    right: 5px;
    top: 2px;
        }
        #pfp:hover #username{
            color: rgba(255,255,255,.75);
        }
        #pfp-drop .dropdown-menu{
            position: unset!important;
        }
        #pfp-drop{
            right: 8px;
    position: absolute;
    top: 74px;
    z-index: 9;
        }
        #pfp-drop button{
            cursor: pointer;
        }
        .edit{
            cursor: pointer;
        }
        tag{
            background-color:#ddd;
            position: relative;
            top:-5px;
            border-radius:5px;
            margin-left:10px;
            margin-right:10px;
            padding:5px;
            font-size:10px;
        }
       .verified {
            background-color:#39c9ed;
            color:white;
        }
        gray{
            color:gray;
        }
        #searchholder{
            position: relative;
    top: 30px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    padding-bottom:60px;
    justify-content: center;
    align-items: flex-start;
        }
        searchuser{
            margin: 5px;
    border-radius: 12px;
    padding: 5px;
    cursor: pointer;
    background: #e5e5e5;
    position: relative;
    width: 300px;
    height: 350px;

        }searchuser img {
    border-radius: 50%;
    position: absolute;
    top: 30px;
    left: calc(50% - (200px / 2));
}searchname {
    position: absolute;
    top: 250px;
    width: 100%;
    display: block;
    text-align: center;
    left: 0px;
    font-size: 17px;
}notifications{
    position: absolute;
    width: 300px;
    height: 400px;
    top: 83px;
    border-radius: 12px;
    background: #ddd;
    right: 68px;
}notify{
    width:90%!important;
    left:5%;
    position: relative;
    transition:0.2s;
    border-radius:12px;
}
notify:hover{
    background:rgba(255,255,255,0.3) ;
}
@keyframes dingdong {
    0%{
        transform: rotate(0deg);
    }
    5%{
        transform: rotate(45deg);
    }
    7.5%{
        transform: rotate(-45deg);
    }
    10%{
        transform: rotate(0deg);
    }
}
#filesPreview img, #filesPreview video{
max-width:35vw!important;
vertical-align: unset!important;
max-height:35vh!important;
}
@keyframes fadeout {
    0%{
        opacity:1;
        transform: scale(1);
    }
    10%{
        opacity:1;
        transform: scale(1.5);
    }
    20%{
        opacity:1;
        transform: scale(1);
    }
    99%{
        opacity:0;
        font-size:25px;
    }
    100%{
        display:none;
        opacity:0;
        visibility:hidden;
        color:transparent;
        font-size:0px;
    }
}
@font-face {
    font-family: RobotoSurge;
    src: url(/media/Roboto-Regular.ttf);
    font-display:swap;
}
*{
    font-family:Roboto,RobotoSurge,Arial,apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
}    ::-webkit-scrollbar {
    transition:0.2s;
      width: 5px; /* Width of vertical scrollbar */
    } ::-webkit-scrollbar:hover {
      width: 10px; /* Width of vertical scrollbar */
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: gray; /* Color of the track */
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #666; /* Color of the scrollbar handle */
      border-radius: 5px; /* Rounded corners */
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; /* Darker background on hover */
    }    /* Handle on hover */
    ::-webkit-scrollbar-thumb:active {
      background: #333; /* Darker background on hover */
    }

loader{
    background-color:rgba(255,255,255,0.5);
    position: fixed;
    top:0px;
    left:0px;
    width:100%;
    height:100%;
}@keyframes spinner-border {
  to { transform: rotate(360deg); }
}   .post {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      position: relative;
    }
    .post .post-header {
      margin-bottom: 10px;
    }
    .post .post-footer {
      margin-top: 10px;
      color: #888;
      font-size: 14px;
    }
    .post-author{
        cursor:pointer;
        width:50%;
    }
    .postmedia{
        max-width:50%;
        max-height:50vh;
        vertical-align: unset!important;
        background-color:rgba(0,0,0,0.4);
    }
    .postvideo{
        width:50%;
        height:50vh;
    }
    tips{
        position:fixed;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.6);
    }
    tip{
        background:#eee;
        color:black!important;
        border-radius:12px;
        position: absolute;
        top:300px;
        width:500px;
        height:300px;
        overflow-y:scroll;
        left:calc(50% - (500px / 2));

    }
    tip button{
        border-radius:50%;
        display:block;
        width:30px;
        height:30px;
        border-style:solid;
        border-width:1px;
    }
    .postbutton{
        border-radius:4px;
        cursor:pointer;
        border-width:0px;
        background-color:gray;
        color:white;
        margin-left:5px;
        font-size:13px;
    }
    likebutton button img{
        transform:scale(1.2);
        filter: saturate(0);
        position: absolute;
        top:10px;
        right:10px;
    }
    @keyframes like {
        0%{
            transform:scale(1.2);
            translate:unset;
        }
        25%{transform:scale(1.35) rotate(-25deg);
      }
        50%{transform:scale(1.35) rotate(25deg);
}
        100%{  transform:scale(1.2);
            translate:unset;}
    }
    likebutton.liked button img{
        filter: unset!important;
        animation-name:like;
        animation-duration:1.4s;
        animation-iteration-count:1;
    }
    likebutton{
        position: absolute;
        top:0px;
        right:0px;
    }
    likebutton button{
        border-width:0px;
        outline:none!important;
        background:transparent;
    }
    likebutton span{

        position: absolute;
        right:00px;
        width:52px;
        top:45px;
        font-size:12px;
        display:block;
        text-align:center;
    }
    @keyframes postin {
        0%{
            opacity:0;
            top:20px;
            transform:scale(0.8);
        }
        100%{
            opacity:1;
            top:0px;
            transform:scale(1);
        }
    }
    .post{
        position: relative;
        animation-name:postin;
        animation-duration:0.3s;
        animation-iteration-count:1;
        animation-fill-mode:forwards;
    }.container{
        position: relative;
        animation-name:postin;
        animation-duration:0.3s;
        animation-iteration-count:1;
        animation-fill-mode:forwards;
    }
    likebutton button{
        cursor: pointer;
    }
    @keyframes placeholder {
        0%{
            left:-150%;
        }
        100%{
            left:150%;
        }

    }
    .placeholderpost{
      
        height:150px;
        overflow: hidden;
    }
    shine{
        position: absolute; animation-name:placeholder;
        animation-duration:3s;
        animation-iteration-count:infinite; 
        width:1000px;  filter:blur(5px);
        height:100px;
        -webkit-box-shadow: inset 10px 10px 300px -7px rgba(0,0,0,1);
-moz-box-shadow: inset 10px 10px 300px -7px rgba(0,0,0,1);
box-shadow: inset 10px 10px 300px -7px rgba(0,0,0,1);
opacity:0.5;
transform: rotate(45deg);
    }notifications{
        overflow-y:scroll;
    }
    searchFs{
        position: absolute;
    top: 300px;
    width: 100%;
    display: block;
    text-align: center;
    left: 0px;
    font-size: 15px;
    }tagged.taggeduser {
    border-radius: 4px;
    background: rgb(0 112 255 / 19%);
    padding: 3px;
    cursor: pointer;
}tagged.taggeduser:hover {
    border-radius: 4px;
    background: rgb(0 112 255 / 29%);
    padding: 3px;
    cursor: pointer;
}

.overlay {
    border-radius: 4px;
    background: rgb(0 112 255 / 19%);
    padding: 3px;
    cursor: pointer;
}.overlay:hover {
    border-radius: 4px;
    background: rgb(0 112 255 / 29%);
    padding: 3px;
    cursor: pointer;
}
replytag {
    position: relative;
    width: 0px;
    display: block;
    text-wrap: nowrap;
    padding: 5px;
    top: -5px;
    letter-spacing: 2px;
    font-weight: 600;
    left: -5px;
    /* border-width: 1px; */
    /* border-style: solid; */
}* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
.search-container {
  display: grid;
  grid-template-columns: 9fr 3fr;
  gap: 1em;
  width: 100%;
  max-width: 50em;
  margin: 1em auto;
  padding: 0.5em;
}
.search-container input {
  padding: 1em;
  border-radius: 0.5em;
  font-weight: 400;
}
.wrapper {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
}
.loader {

}
@keyframes spin {
  100% {
    transform: translate(-50%, -50%) rotate(360deg);
  }
}
@media screen and (max-width: 768px) {
  .wrapper {
    grid-template-columns: repeat(2, 1fr);
  }
  .container {
    margin: 0.7em;
  }
}
@media screen and (max-width: 576px) {
  .wrapper {
    grid-template-columns: 1fr;
  }
}
.box .container img {
    max-height:300px;
    max-width:300px;
}.box{
    width: 986px;
    word-wrap: break-word;
    overflow: auto;
    text-wrap: wrap;
}
.box input, .box button{    border-style: solid;border-radius:5px;border-color:gray;}
button.postbutton {
    padding: 2px;
}
</style><style id='surgeColorStyle'></style>
</head>
<body>
<div id='pfp-drop' style='display:none;'>
<ul class="dropdown-menu shadow show" aria-labelledby="bd-theme-text" >


        <li>
        <button type="button" onclick='window.location.replace("/authv2/logout/")' class="dropdown-item d-flex align-items-center">

Logout

</button>
        </li>        <li>
          <button style='color:red;' onclick='window.location.href ="/authv2/delete"' type="button" class="dropdown-item d-flex align-items-center">
            
            Delete my account

          </button>
        </li>
      </ul>
</div>


<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/home/"><img id="logo" src="/img/?img=logo.png&width=50&height=50&type=webp&quality=60" width='50px' height='50px' alt="Surge Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" onclick='navLinkClick(this)'>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick='navLinkClick(this)'>Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick='navLinkClick(this)'>Settings</a>
            </li> <li class="nav-item">            <li class="nav-item">
                <a class="nav-link" onclick='navLinkClick(this)'>Search</a>
            </li> <li class="nav-item">
                <a class="nav-link">|</a>
            </li> <li class="nav-item" onclick='notificationToggle()'>
                <a class="nav-link"><span id='nicon' class="material-symbols-rounded">
notifications
</span></a>
            </li><li class="nav-item" id='pfp' onclick='pfpDropToggle()'>
                <span id='username'><?=$displayname?></span><img style='border-radius:50%;' src='/pfp/?user=<?=$username?>&quality=40&width=50&height=50&type=webp' width='50px' height='50px' loading='lazy'/>
            </li>
            
        </ul>
    </div>
    
</nav>
<div class="container mt-4" id='Home'>
    <h1>Home</h1><hr>


    <div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create a New Post</h5>
            <form id="postForm" onsubmit="return checkPost();" action="/post/" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea class="form-control" name='postText' id="postText" placeholder="Type your post here..." rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="postFiles">Upload Image/Video</label>
                    <input name='postFiles[]' accept='.webp,.png,.jpg,.gif,.jpeg,.mp4,.webm' type="file" class="form-control-file" id="postFiles" multiple>
                    <div id="filesPreview" class="mt-2"></div>
                </div>
    <div class="box">
      <div class="search-container">
        <input type="text" id="search-box" value="" placeholder="Search for gifs! Simle, Fire, etc." />
        <button id="submit-btn" style='cursor:pointer;' type='button'>Search</button>
      </div>
      <div class="loader"></div>
      <div class="wrapper"></div>
    </div>
                <button type="submit" class="btn btn-primary">Post</button>
                <?php if(isset($_GET['posted'])){echo '<posted style="font-size:25px; padding-left:20px;position:relative;top:5px;animation-name:fadeout;animation-duration:3s;animation-iteration-count:1;animation-fill-mode:forwards;">Posted ✅</posted>';} ?>
            </form>
        </div>
    </div>
<br>
<h2><?php if(isset($_COOKIE['surge_order'])){if($_COOKIE['surge_order']=='trending'){echo '🔥 Trending posts';}else{echo '🕔 Latest posts';}}else{echo '🕔 Latest posts';} ?>:</h2>
<hr>
    <div class="container" id='lp-cont'>
    <div class='post placeholderpost'>
    <shine></shine>
</div><div class='post placeholderpost'>
<shine></shine>
</div><div class='post placeholderpost'>
<shine></shine>
</div><div class='post placeholderpost'>
<shine></shine>
</div><div class='post placeholderpost'>
<shine></shine>
</div>

</div>



<endofcontainer id='EndOfCont' style='display:block;width:50px;height:500px;'></endofcontainer>




  </div></div>
<div class="container mt-4" id='Profile' style='display:none;'>
<h1>Your profile</h1><hr>
<center>
<img style='border-radius:50%;' src='/pfp/?user=<?=$username?>&quality=40&width=250&height=250&type=webp' width='250px' height='250px' loading='lazy'/><span class="edit material-symbols-rounded" onclick='window.location.href = "/authv2/editpfp/?forward=/home/"'>
edit
</span>
<h1><?=$displayname?><replacewithtags></replacewithtags></h1><span style='position: relative;
    top: -70px;
    left: 71px;' class="edit material-symbols-rounded" onclick='window.location.href = "/authv2/editname/?forward=/home/"'>
edit
</span>
<p><b>About me: </b><replacewithbio>No about me yet...</replacewithbio></p><span style='    position: relative;
    top: -65px;
    left: 85px;' class="edit material-symbols-rounded" onclick='window.location.href = "/authv2/editbio/?forward=/home/"'>
edit
</span>
    </center>
    </div>
<div class="container mt-4" id='Settings' style='display:none;'>
<h1>Settings</h1>
<hr>
<div class="form-group">
  <label for="theme">Choose a Theme:</label>
  <select class="form-control" id="theme" oninput='changeTheme(this)'>
    <option value="light">☀️ Light Mode</option>
    <option value="dark">🌑 Dark Mode</option>
    <option value="custom">🧑‍💻 Custom theme (Advanced users only)</option>
  </select>
  <textarea id='ctheme' style='display:none;width:100%;height:400px;' oninput='updatectheme(this)'></textarea>
  
</div>
<div class="form-group">
  <label for="ccc">Change your password:</label>
<button id='ccc' onclick='window.location.href="/authv2/forgot"' class="btn btn-secondary">Change my password 🔐</button>
  
</div>
<div class="form-group">
  <label for="theme">Choose a post order:</label>
  <select class="form-control" id="porder" oninput='changeOrder(this)'>
    <option value="latest">🕔 Latest posts (default)</option>
    <option value="trending">🔥 Trending posts</option>
  </select>
  <textarea id='ctheme' style='display:none;width:100%;height:400px;' oninput='updatectheme(this)'></textarea>
  
</div><div class="form-group">
  <label for="ccc">Redeem a code:</label>
<button id='ccc' onclick='window.location.href="/authv2/redeem"' class="btn btn-secondary">🎁 Redeem a code</button>
  
</div>
    </div>
<div class="container mt-4" id='Search' style='display:none;'>

<h1>Search</h1><hr>
    <div class="input-group search-bar">
      <input type="text" class="form-control" id='searchBar' placeholder="Search...">
      <button style='height:38px;width:101px;' class="btn btn-primary" onclick='searchFromBar()' type="button"><span  class="material-symbols-rounded">
search
</span></button>
    </div>
    <div id='searchholder'>
<gray>Enter a search query to begin.</gray>
    </div>
  
    </div>
    <div class="modal fade" id="notVerifiedModal" tabindex="-1" role="dialog" aria-labelledby="notVerifiedLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Email not verified</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        You haven't verified your email yet. This means you can't post or interact with other posts. Please verify to gain access.
<br><hr>
          <button type="button" class="btn btn-secondary" onclick="$('#notVerifiedModal').modal('hide');">Close</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href='/auth/finishaccount/';">Verify my email</button>
        </div>
      </div>
    </div>
  </div>
  <notifications style='<?php if(!isset($_GET['fopennotify'])){echo 'display:none;';}else{echo 'display:block;';}?>'>
<?php
if($thisrow['Notifications']==''){
    echo "<gray style='position: absolute;    width: 100%;    top: 134px;    text-align: center;'>Your notifications will be shown here.</gray>";
}else{
    $notificiations=array_reverse(explode(',,!!,,',$thisrow['Notifications']));
    $c=0;
    echo "<br>";
    foreach ($notificiations as $text) {
        echo '<notify style="display: block;        width: 100%;cursor:pointer;        text-align: center;        font-size: 15px;" onclick="clickNotify(this)" notifyid="'.$c.'">'.$text . "</notify><br>"; // Output each element followed by a line break
        $c=$c+1;
    }
}
?>
  </notifications><loader id='loader' style='display:none;'><sspacer style='display:block;width:1px;height:100px;'></sspacer><center>
<h1>Loading...</h1>
<b>This may take a while. Please wait...</b><br>
<div style='    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: text-bottom;margin-top:50px;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite;' class="spinner-border text-primary" role="status">
  <span class="sr-only">Loading...</span>
</div>
</center>
  </loader>
  <?php
if(isset($_GET['firsttime'])){
    if(!$subdomain=='m'){
    echo "<tips><tip><button onclick='this.parentNode.parentNode.remove()'>X</button><center>
    <h1>Welcome to Surge!</h1><hr>
    <b>Here are some tips to help you get started.</b><br>
    <br>
    <span>Want the original image/video without a watermark? <i>Just click the images or quadruple (4x) click the videos.</i></span><br>    <span>Want to have a fantastic looking profile? <i>Just click on Profile at the top to change your profile picture or about me.</i></span><br>  <span>Want to find your freind's account? <i>Just click on Search at the top and enter their username.</i></span><br><span>Need help? <i>You can ask for help on Surge, ask for help on our <a href='https://discord.surgeme.xyz'>Discord server</a>, or email us at <a href='mailto:surge@surgeme.xyz'>surge@surgeme.xyz</a>.</i></span><br>
    <button style='width:100%;' class='btn btn-primary' onclick='this.parentNode.parentNode.parentNode.remove()'>Close</button>
    
    
    </center></tip></tips>";}
}
  ?>
    <script>
        setTimeout(() => {
            
        try{
if(wegood('ye')!=='goodye'){
window.location.reload()
}
        }catch(e){
            window.location.reload()   
        }
        }, 1000);
        </script>
<script src='/surgetools/'></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script defer async>
let apiKey = "9BrRgUIsrHMQmfrdVg3HArvMYTkoZLQU";
let submitBtn = document.getElementById("submit-btn");

let generateGif = () => {
  //display loader until gif load
  let loader = document.querySelector(".loader");
  loader.style.display = "block";
  document.querySelector(".wrapper").style.display = "none";

  //Get search value (default => laugh)
  let q = document.getElementById("search-box").value;
  //We need 10 gifs to be displayed in result
  let gifCount = 10;
  //API URL =
  let finalURL = `https://api.giphy.com/v1/gifs/search?api_key=${apiKey}&q=${q}&limit=${gifCount}&offset=0&rating=g&lang=en`;
  document.querySelector(".wrapper").innerHTML = "";
//Paste the generated API Key here

  //Make a call to API
  fetch(finalURL)
    .then((resp) => resp.json())
    .then((info) => {
    //  console.log(info.data);
      //All gifs
      let gifsData = info.data;
      gifsData.forEach((gif) => {
        //Generate cards for every gif
        let container = document.createElement("div");
        container.classList.add("container");
        let iframe = document.createElement("img");
      //  console.log(gif);
        iframe.setAttribute("src", gif.images.downsized_medium.url);
        iframe.onload = () => {
          //if iframes has loaded correctly reduce the count when each gif loads
          gifCount--;
          if (gifCount == 0) {
            //If all gifs have loaded then hide loader and display gifs UI
            loader.style.display = "none";
            document.querySelector(".wrapper").style.display = "grid";
          }
        };
        container.append(iframe);

        //Copy link button
        let copyBtn = document.createElement("button");
        copyBtn.innerText = "Copy Link";
        copyBtn.setAttribute('type','button')
        copyBtn.onclick = () => {
          //Append the obtained ID to default URL
          let copyLink = `https://media4.giphy.com/media/${gif.id}/giphy.mp4`;
          //Copy text inside the text field
          navigator.clipboard
            .writeText(copyLink)
            .then(() => {
              alert("GIF copied to clipboard");
            })
            .catch(() => {
              //if navigator is not supported
              alert("GIF copied to clipboard");
              //create temporary input
              let hiddenInput = document.createElement("input");
              hiddenInput.setAttribute("type", "text");
              document.body.appendChild(hiddenInput);
              hiddenInput.value = copyLink;
              //Select input
              hiddenInput.select();
              //Copy the value
              document.execCommand("copy");
              //remove the input
              document.body.removeChild(hiddenInput);
            });
        };
        container.append(copyBtn);
        document.querySelector(".wrapper").append(container);
      });
    });
};

//Generate Gifs on screen load or when user clicks on submit
submitBtn.addEventListener("click", generateGif);
window.addEventListener("load", generateGif);
    function sharePost(element) {
  if (navigator.share) {
    navigator.share({
      text: 'Check out this post by @'+element.parentNode.parentNode.getElementsByClassName('post-author')[0].getAttribute('onclick').replace("openUser('",'').replace("')",'')+' on Surge!',
      url: 'https://surgeme.xyz/p/?p='+element.parentNode.parentNode.getAttribute('spid')
    })
    .then(() => console.log('URL shared successfully'))
    .catch((error) => console.error('Error sharing URL:', error));
  } else {
    alert('Web Share API not supported.');
    // You can provide fallback behavior here, such as copying the URL to the clipboard
  }
}
    function openPost(element){
        var pid=element.innerHTML
        window.open('/p/?p='+pid,'_blank')
    }
function clickHash(element){
    alert(element.innerHTML + ' - This feature is coming soon.')
}
function doGifs(text) {
    // Regular expression to match Giphy links
    var regex = /https:\/\/media\d+\.giphy\.com\/media\/([a-zA-Z0-9]+)\/giphy\.mp4/g;

    // Replace Giphy links with video elements
    var replacedText = text.replace(regex, function(match, giphyId) {
        // Construct the video element with the Giphy URL
        var videoElement = '<video style="    max-width: 169px;    max-height: 169px;" autoplay muted loop playsinline loading="lazy">';
        videoElement += '<source src="https://media4.giphy.com/media/' + giphyId + '/giphy.mp4" type="video/mp4">';
        videoElement += 'Your browser does not support the video tag.';
        videoElement += '</video>';

        return videoElement;
    });

    return replacedText;
}
function wrapUrlsWithTags(str) {
    // Regular expression pattern to find all URLs, excluding specific pattern
    var pattern = /(https?:\/\/(?!media\d+\.giphy\.com\/media\/\w+\/giphy\.mp4)[^\s]+)/g;
    
    // Replace URLs with tagged elements
    var replacedStr = str.replace(pattern, '<url onclick="window.open(this.innerHTML, \'_blank\')" class="overlay">$1</url>');
    
    return replacedStr;
}function wrapHashtagsWithTags(str) {
    // Regular expression pattern to find all hashtags
    var pattern = /#(\w+)/g;
    
    // Replace hashtags with tagged elements
    var replacedStr = str.replace(pattern, '<hashtag onclick="clickHash(this)" class="overlay">#$1</hashtag>');
    
    return replacedStr;
}

function addReply(text){
    var texted=text
if(text.startsWith(':Reply-To-')){
    texted = texted.replace(':Reply-To-','')
    var pid= texted.split(':')[0]
    texted = texted.replace(/.*:/, '');
    texted='<replyTag>Replying to post <overlay class="overlay" onclick="openPost(this)">'+pid+'</overlay>.</replyTag>'+texted
}
    return texted;
}
    function polishText(text){
return doGifs(addReply(wrapHashtagsWithTags(wrapUrlsWithTags(text))))
    }
function openTagged(element){
    window.open('/u/?u='+element.innerHTML.replace('@',''),'_blank')
}
function getLikeData(id,pid){
    getData('/likes/?p='+pid)
    .then(data => {
     
        getById('changeme-l-'+id).innerHTML=formatLikes(data.split(',,!!,,')[0]);
        if(data.split(',,!!,,')[1]=='1'){
            getById('changeme-l-'+id).parentNode.setAttribute('class','liked')
        }
        // Do something with the data...
    })
    .catch(error => {
        //console.error('Error:', error);
        // Handle the error...
        console.warn(error)
            setTimeout(() => {
                getLikeData(id,pid)
            }, 1000);
    });
}
function formatLikes(num) {
    if(num==0){
        return '0 Likes';
    }  if(num==1){
        return '1 Like';
    }
    // Define an array of suffixes for different magnitudes
    const suffixes = ['', 'k', 'M', 'B', 'T'];

    // Determine the magnitude of the number
    const magnitude = Math.floor(Math.log10(Math.abs(num)) / 3);

    // Determine the suffix to use
    const suffix = suffixes[magnitude];

    // Calculate the shortened number
    const shortNum = num / Math.pow(10, magnitude * 3);

    // Format the number and suffix with "like" or "likes" based on the value
    const formattedLikes = `${shortNum}${suffix}${num === 1 ? ' Like' : ' Likes'}`;

    return formattedLikes;
}

async function getData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.text();
        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error; // Re-throw the error to handle it where the function is called.
    }
}
    function likePost(element){
        getData('/togglelike/?p='+element.parentNode.parentNode.parentNode.getAttribute('spid'))
    .then(data => {
        if(data.split(',,!!,,')[0]=='1'){
            element.parentNode.setAttribute('class', 'liked')
        }else{
            element.parentNode.setAttribute('class', '')
        }
        element.parentNode.getElementsByTagName('span')[0].innerHTML=formatLikes(data.split(',,!!,,')[1])
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle the error...
    });
    }
    function deletePost(element){
        pid=element.parentNode.parentNode.getAttribute('spid')
        if(confirm('Are you sure you want to delete this post?')){
            window.location.replace('/deletepost/?p='+pid)
        }
    }    function replyPost(element){
        pid=element.parentNode.parentNode.getAttribute('spid')
        window.scroll(0,0)
        getById('postText').value=':Reply-To-'+pid+': '
    }function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

    function makeButtons(pu,pid){
        var rs=generateRandomString(25)
        var buttons='<likebutton><button onclick="likePost(this)"><img loading="lazy" src="/img/?img=like.png&width=33&height=35&type=webp&quality=60"/></button><span id="changeme-l-'+rs+'">0 Likes</span></likebutton><?php if($username=='Peter' || $username=='Surge'){echo '<button class="postbutton" onclick="deletePost(this)" style="background:#a00;">(🔐 Admin) 🗑️ Delete post</button><button class="postbutton" onclick="replyPost(this)" style="background:#03b;">➡️ Reply</button><button class="postbutton" onclick="sharePost(this)" style="background:#09b;">🔗 Share</button>';} ?>';
        if(pu=='<?=$username?>'){
        buttons=buttons+'<button class="postbutton" onclick="deletePost(this)" style="background:#a00;">🗑️ Delete post</button>'
        }
        getLikeData(rs,pid)
        return buttons;
    }
    po=[]
    dp=[]
setTimeout(() => {
    try{
document.getElementsByTagName('posted')[0].remove()
    }catch(e){}
}, 1500);
lastadd='none'



firstadd=true;
function actadd(parentId,element){

if(firstadd){
    document.getElementById(parentId).innerHTML=''
    firstadd=false;
}
    lastadd=element.getAttribute('spid')
    newElement=element;

// Get the parent container element
var parentElement = document.getElementById(parentId);

  parentElement.appendChild(newElement);

}






function waitup(pid,e){
    setTimeout(() => {
        addElementToStart(pid,e)
    }, 100);
}
function addElementToStart(parentId, element) {


if(dp.length==0){
    if(po[0]==element.getAttribute('spid')){
    dp.push(element.getAttribute('spid'))
    actadd(parentId,element)
    }else{
        waitup(parentId,element)
    }
}else{
    po.shift()
    dp=[]
    waitup(parentId,element)
}
    }
    function addposttext(id,user,time,text,display,media){
    var newElement = document.createElement('div');
    newElement.setAttribute('class','post')
    newElement.setAttribute('spid',id)
    
      // <div class="post"></div>
        var innerhtml='      <div class="post-header">        <p class="post-author" onclick="openUser('+"'"+user+"'"+')"><img width=35px height=35px style="border-radius:50%;margin-right:5px;position:relative;top:-2px;" src="/pfp/?user='+user+'&quality=40&width=35&height=35&type=webp"/>'+display+'</p>      </div>      <div class="post-content">        <p>'+text+'</p>      </div>      <div class="post-footer">        <span class="post-date">Posted at '+time+'</span>        <!--buttons-->  '+makeButtons(user,id)+'    </div>    </div>   '
        newElement.innerHTML=innerhtml
        addElementToStart('lp-cont',newElement)
}function addposttextmedia(id,user,time,text,display,media){
    var newElement = document.createElement('div');
    newElement.setAttribute('class','post')
    newElement.setAttribute('spid',id)
    var htmltoadd=''
    for (const element of media.split(',,!!,,')) {
        if(element!==''){
        if(element.substring(element.length - 4).toLowerCase()=='.mp4'){
            var og='/smed/?url='+element.replace('D:/Surge/uploads/aft_','')
           
            htmltoadd=htmltoadd+'<video ondblclick="window.open('+"'"+og+"'"+','+"'_blank'"+'); event.preventDefault();" src="/smed/?url='+element.replace('D:/Surge/uploads/','')+'" class="postvideo postmedia" controls loop loading="lazy"></video>'
        }else{
            var og='/smed/?url='+element.replace('D:/Surge/uploads/aft_','').slice(0, -4);
            htmltoadd=htmltoadd+'<a href="'+og+'" title="View original file"><img src="/smed/?url='+element.replace('D:/Surge/uploads/','')+'" class="postimg postmedia" loading="lazy" /></a>'
        }

    }
}
      // <div class="post"></div>
        var innerhtml='      <div class="post-header">        <p class="post-author" onclick="openUser('+"'"+user+"'"+')"><img width=35px height=35px style="border-radius:50%;margin-right:5px;position:relative;top:-2px;" src="/pfp/?user='+user+'&quality=40&width=35&height=35&type=webp"/>'+display+'</p>      </div>      <div class="post-content">        <p>'+text+'</p>   <hr>'+htmltoadd+'   </div>      <div class="post-footer">        <span class="post-date">Posted at '+time+'</span>        <!--buttons-->   '+makeButtons(user,id)+'   </div>    </div>   '
        newElement.innerHTML=innerhtml
        addElementToStart('lp-cont',newElement)
}function addpostmedia(id,user,time,text,display,media){
    var newElement = document.createElement('div');
    newElement.setAttribute('class','post')
    newElement.setAttribute('spid',id)
    var htmltoadd=''
    for (const element of media.split(',,!!,,')) {
        if(element!==''){
        if(element.substring(element.length - 4)=='.mp4'){
            var og='/smed/?url='+element.replace('D:/Surge/uploads/aft_','')
           
            htmltoadd=htmltoadd+'<video ondblclick="window.open('+"'"+og+"'"+','+"'_blank'"+'); event.preventDefault();" src="/smed/?url='+element.replace('D:/Surge/uploads/','')+'" class="postvideo postmedia" controls loop loading="lazy"></video>'   }else{
            var og='/smed/?url='+element.replace('D:/Surge/uploads/_aft','').replace('.png.png','.png')
            htmltoadd=htmltoadd+'<a href="'+og+'" title="View original file"><img src="/smed/?url='+element.replace('D:/Surge/uploads/','')+'" class="postimg postmedia" loading="lazy" /></a>'
        }

    }
}
      // <div class="post"></div>
        var innerhtml='      <div class="post-header">        <p class="post-author" onclick="openUser('+"'"+user+"'"+')"><img width=35px height=35px style="border-radius:50%;margin-right:5px;position:relative;top:-2px;" src="/pfp/?user='+user+'&quality=40&width=35&height=35&type=webp"/>'+display+'</p>      </div>      <div class="post-content">       '+htmltoadd+'   </div>      <div class="post-footer">        <span class="post-date">Posted at '+time+'</span>        <!--buttons-->    '+makeButtons(user,id)+'  </div>    </div>   '
        newElement.innerHTML=innerhtml
        addElementToStart('lp-cont',newElement)
}function wrapUsernamesWithTags(str) {
    // Regular expression pattern to find all usernames starting with '@'
    var pattern = /@(\w+)/g;
    
    // Replace usernames with tagged elements
    var replacedStr = str.replace(pattern, '<tagged onclick="openTagged(this)" class="taggeduser">@$1</tagged>');
    
    return replacedStr;
}

function loadPostData(id){
    getAsync('/postdata/?pid='+id)
    .then(data => {
        var postdata=data.split(',,!!!!,,')
var PostUser=postdata[0]
var PostTime=postdata[1]
var MediaPost=postdata[2]
var TextPost=postdata[3]
var PostMedia=postdata[4]
var PostText=polishText(wrapUsernamesWithTags(postdata[5]))
getAsync('/displayname/?user='+PostUser)
    .then(dataa => {
if(dataa==''){
    dataa='Removed user - @'+PostUser
    PostUser='removeduser'
}
        getAsync('/verified/?user='+PostUser)
    .then(dataaa => {
        // Handle the retrieved data here
        if(dataaa=='1'){
       dataaaa=dataa+'<tag style="top:0px;" class="verified">Verified</tag>'
        }else{
            dataaaa=dataa
        }

     
        if(TextPost=='1' && MediaPost=='0'){
addposttext(id,PostUser,PostTime,PostText,dataaaa)
}
if(TextPost=='1' && MediaPost=='1'){
addposttextmedia(id,PostUser,PostTime,PostText,dataaaa,PostMedia)
}if(TextPost=='0' && MediaPost=='1'){
addpostmedia(id,PostUser,PostTime,'',dataaaa,PostMedia)
}
})
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
})
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
}
allowob=false
loadedposts=0
function loadMorePosts(ob){
    if(ob){
        if(!allowob){
            return;
        }
    }else{
        setTimeout(() => {
            allowob=true
        }, 500);
    }
loadedposts=loadedposts+5
    getAsync('/posts/?<?php if(@$_COOKIE['surge_order']=='trending'){echo "trend&";} ?>p='+(loadedposts-5))
    .then(data => {
var ptl=data.split(',,!!,,')

var ptl = ptl.filter(item => item !== "");
for (const element of ptl) {
    po.push(element)
  loadPostData(element)
}
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
}
// Create an intersection observer
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
     loadMorePosts(true)
    }
  });
});

// Target the element you want to observe
const endOfCont = document.getElementById('EndOfCont');

// Start observing the element
observer.observe(endOfCont);




function checkPost(){
var returnval=false;
if(getById('postText').value.length>0){
   returnval=true;
}if(getById('postFiles').value.length>0){
     returnval=true;
}if(getById('postText').value.length>450){
    alert('Your post is too long. Please shorten it.')
   returnval=false;
}
if(getById('postFiles').files.length>6){
    returnval=false;
    alert('You have too many files. The limit is 6.');
    return false;
}
if(returnval){
    getById('loader').style=''
}
    return returnval;
}
$(document).ready(function() {
    // File Preview
    $("#postFiles").change(function() {
      var input = this;
      if (input.files && input.files.length > 0) {
        $('#filesPreview').empty(); // Clear previous previews
        if(input.files.length>6){
            return alert('You have too many files. The limit is 6 files per post.');
        }
        for (var i = 0; i < input.files.length; i++) {
          var file = input.files[i];
          var reader = new FileReader();
          reader.onload = (function(file) {
            return function(e) {
              var preview;
              if (file.type.match('image.*')) {
                preview = $('<img>').attr('src', e.target.result).css('max-width', '100%');
              } else if (file.type.match('video.*')) {
                preview = $('<video loop repeat muted autoplay>').attr('src', e.target.result).css('max-width', '100%');
              }
              $('#filesPreview').append(preview);
            };
          })(file);
          reader.readAsDataURL(file);
        }
      }
    });
    // Form Submission

  });
    if(document.getElementsByTagName('notifications')[0].getElementsByTagName('gray').length!==1){
       document.getElementById('nicon').innerHTML='notifications_active'
       document.getElementById('nicon').style='animation-name:dingdong;animation-duration:12s;animation-iteration-count:infinite;'
    }
    function clickNotify(element){
        var id=(element.getAttribute('notifyid'))
        if( element.innerHTML=='Click again to delete.'){
            setTimeout(() => {
                element.remove()
            }, 100);
            getAsync('/deletenotify/?id='+id) .then(data => {
window.location.href='?fopennotify'
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
            return;
        }
     
       element.innerHTML='Click again to delete.'
    }
    function closenotif(){
        var pfpDrop = document.getElementsByTagName('notifications')[0];

// Check if the click is outside the 'pfp-drop' element
if (!pfpDrop.contains(event.target)) {
    pfpDrop.style.display = 'none';
    document.body.removeEventListener('click', closenotif);
}
    }
function notificationToggle(){
if(document.getElementsByTagName('notifications')[0].style.display=='none'){
document.getElementsByTagName('notifications')[0].style.display='block'
setTimeout(() => {
            document.body.addEventListener('click', closenotif);
        }, 100);
}else{
document.getElementsByTagName('notifications')[0].style.display='none'
}
}
    function openUser(name){
       window.location.href='/u/?u='+name
    }
    function finishSearch(username,element){
        
 var username=element.innerHTML
 getAsync('/verified/?user='+username)
    .then(dataa => {
        // Handle the retrieved data here
        if(dataa=='1'){
        var tags ='<tag class="verified">Verified</tag>'
        }else{
            var tags=''
        }
        getAsync('/displayname/?user='+username)
    .then(dataaa => {
        getAsync('/followers/?u='+username)
    .then(dataaaa => {
    
element.setAttribute('onclick','openUser("'+username+'")')

        element.innerHTML='<img width="200px" height="200px" src="/pfp/?user='+username+'&quality=40&width=200&height=200&type=webp" /><searchName>'+dataaa+tags+'</searchName><searchFs>'+dataaaa+'</searchFs>'


    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });

    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });


    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });

    }
function searchFromBar(){
var query=getById('searchBar').value
if(query==''){
    getById('searchholder').innerHTML='<gray>Enter a search query to begin.</gray>'
    return;
}
    getAsync('/searchsurge/?q='+query)
    .then(data => {
        // Handle the retrieved data here 
        getById('searchholder').innerHTML=data
        var items=getById('searchholder').getElementsByTagName('searchUser')
        for (const element of items) {
            finishSearch(username,element)

}
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
}
 //backup for when SurgeTools is not ready.
 function getCookie(name) {
    const cookies = document.cookie.split('; ');
    const cookie = cookies.find(cookie => cookie.startsWith(name));
    return cookie ? cookie.split('=')[1] : null;
}
function setCookie(name, value, days = 7) {
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + days);
    const cookieString = `${name}=${value};expires=${expirationDate.toUTCString()};path=/`;
    document.cookie = cookieString;
}
//end
function updatectheme(element){
    document.getElementById('surgeColorStyle').innerHTML=element.value
    try{
        setCookie('surge.ctheme',element.value.replaceAll(';','END').replaceAll('\n','NEWLINE').replaceAll('/','FS').replaceAll('*','STAR'),365)
        }catch(e){
            console.error('Failed to set custom theme cookie! This may be because SurgeTools wasnt loaded yet. ('+e+')')
        }
}
function wegood(str){
    return 'good'+str;
}
function changeOrder(element){
    setCookie('surge.order',element.value,365)
    window.location.reload()
}
if(getCookie('surge.order')=='trending'){
    document.getElementById('porder').value='trending'
}
    function setTheme(theme){
        document.getElementById('ctheme').style.display='none'
        try{
        setCookie('surge.color-mode',theme,365)
        }catch(e){
            console.error('Failed to set color mode cookie! This may be because SurgeTools wasnt loaded yet. ('+e+')')
        }
        var customColorStyle=document.getElementById('surgeColorStyle')
        if(theme=='dark'){
            customColorStyle.innerHTML='html,body{background:black;}.container{background:#222;border-radius:12px;color:#eee!important;padding-bottom:20px;padding-top:10px;}.form-control {  background-color: #555!important;  color: #fff!important;border-width:0px!important;}.form-control option {  background-color: #333;  color: #fff;}.navbar{background:#123851!important;}.dropdown-menu,.dropdown-menu li button{    background: #313131!important;color:#eee;}hr{background:#aaa;}textarea{    color: #eee;    background: #444;}searchuser{background:#414141!important;}notifications{ background: #333;}notify{color:white!important;}.card-body{background:#2d2d2d; border:unset!important;}.card{background:#2d2d2d; border:unset!important;} loader{ color:white!important;background:rgba(0,0,0,0.5)!important;}.container,.post{background:#2d2d2d!important;}'
        }else{
            if(theme=='custom'){
document.getElementById('ctheme').style.display='block'

if(document.getElementById('ctheme').value==''){
    document.getElementById('ctheme').value='/*This is the default dark mode theme. Use it as a base.*/\nhtml,body{background:black;}.container{background:#222;border-radius:12px;color:#eee!important;padding-bottom:20px;padding-top:10px;}.form-control {  background-color: #555!important;  color: #fff!important;border-width:0px!important;}.form-control option {  background-color: #333;  color: #fff;}.navbar{background:#123851!important;}.dropdown-menu,.dropdown-menu li button{    background: #313131!important;color:#eee;}hr{background:#aaa;}textarea{    color: #eee;    background: #444;}searchuser{background:#414141!important;}notifications{ background: #333;}notify{color:white!important;}.card-body{background:#2d2d2d; border:unset!important;}.card{background:#2d2d2d; border:unset!important;} loader{ color:white!important;background:rgba(0,0,0,0.5)!important;}.container,.post{background:#2d2d2d!important;}'
}
updatectheme( document.getElementById('ctheme'))

            }else{
            customColorStyle.innerHTML=''
        }}
    }
    function changeTheme(element){
         setTheme(element.value)
    }
    if(getCookie('surge.color-mode')=='dark'){
        document.getElementById('theme').value='dark'
        changeTheme(document.getElementById('theme'))
    }else{
        if(getCookie('surge.color-mode')=='custom'){
            document.getElementById('theme').value='custom'
            document.getElementById('ctheme').value=getCookie('surge.ctheme')  .replaceAll('END', ';')  .replaceAll('NEWLINE', '\n')  .replaceAll('FS', '/')  .replaceAll('STAR', '*');
            
        changeTheme(document.getElementById('theme'))

        }
    }
function pfpDropToggle() {
    var pfpDrop = getById('pfp-drop');

    if (pfpDrop.style.display == 'none') {
        pfpDrop.style.display = 'block';

        // Add event listener to the body
        setTimeout(() => {
            document.body.addEventListener('click', closePfpDrop);
        }, 100);
       
    } else {
        pfpDrop.style.display = 'none';

        // Remove event listener when hiding the pfp-drop
        document.body.removeEventListener('click', closePfpDrop);
    }
}

// Event listener function to close 'pfp-drop' if clicked outside
function closePfpDrop(event) {
    var pfpDrop = getById('pfp-drop');

    // Check if the click is outside the 'pfp-drop' element
    if (!pfpDrop.contains(event.target)) {
        pfpDrop.style.display = 'none';
        document.body.removeEventListener('click', closePfpDrop);
    }
}

    activePage='Home'
function switchPage(page){
    getById(activePage).style='display:none;'
     getById(page).style=''
    
    activePage=page
}
function navLinkClick(element){
 var togoto=element.innerHTML
 switchPage(togoto)
 document.querySelectorAll('.navbar-nav .nav-link').forEach(element => {
    removeClass(element,'active')
 });
 addClass(element,'active')
}

        <?php
if(!$verified){echo "$('#notVerifiedModal').modal('show');";}
        ?>
    


if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
if(getCookie('surge.color-mode')==null){
    setCookie('surge.color-mode','dark',365)
    window.location.reload()
}
}
getAsync('/bio/?user=<?=$username?>')
    .then(data => {
        // Handle the retrieved data here
        document.getElementsByTagName('replacewithbio')[0].innerHTML=data
        document.getElementsByTagName('replacewithbio')[0].innerHTML=document.getElementsByTagName('replacewithbio')[0].innerHTML.replaceAll('&amp;','&')
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });
    getAsync('/verified/?user=<?=$username?>')
    .then(data => {
        // Handle the retrieved data here
        if(data=='1'){
        document.getElementsByTagName('replacewithtags')[0].innerHTML='<tag class="verified">Verified</tag>'
        }
    })
    .catch(error => {
        // Handle any errors that occurred during the fetch operation
        console.error('Error:', error);
    });


    const warningStyles = 'font-size: 18px; font-weight: bold; color: red; background-color: #ffcccb; padding: 10px; border-radius: 5px;';

console.log('%cWARNING: Do not paste anything here!', warningStyles);
console.log('%cPasting anything into this console can be dangerous and result in security vulnerabilities.', 'font-size: 14px;');
console.log('%cIf someone told you to paste something here, it could compromise your account or personal data.', 'font-size: 14px;');
console.log('%cIf you don\'t understand what you are doing, close this window immediately.', 'font-size: 14px;');
loadMorePosts(false)
// New URL and title
var newUrl = window.location.href.split('?')[0].split('#')[0];
var newTitle = window.title;

// Change the URL without reloading the page
history.pushState({}, newTitle, newUrl);
    </script>
    <script>
        try{
if(wegood('ye')!=='goodye'){
window.location.reload()
}
        }catch(e){
            window.location.reload()   
        }
        </script>
</body>
</html>
