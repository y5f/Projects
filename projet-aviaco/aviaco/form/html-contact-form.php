<?php 
session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';

if(isset($_POST['submit']))
{
	
	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$user_message = $_POST['message'];
 
 if(empty($name)||empty($visitor_email) || empty($user_message))
	{
		$errors .= "\n nom et mail et message requis. ";	
	}
	
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	
		$errors .= "\n Le code de confirmation que vous avez entré ne correspond pas à celui de l'image !";
	}
	
	if(empty($errors))
	{
	header('Location: html-contact-form.php');
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Contact</title>

<style>
label,a, body 
{
	font-family : Arial, Helvetica, sans-serif;
	color:white;
	font-size : 12px; 
}
.err
{
	font-family : Verdana, Helvetica, sans-serif;
	font-size : 12px;
	color: red;
}
form {
 float: left;
 background-image:url(background_form.png);
 background-repeat:no-repeat;
 height:400px;
 width:280px;
 padding-left:10px;
 padding-top:10px; 
      }
	  
input[type=text] {border:1px solid #000000; 
-webkit-border-radius: 2px;
border-radius: 2px;
                 }
				 
input[type=text]:focus {border-color:#FFFFFF; }
input[type=textarea]:focus {border-color:#FFFFFF; }


input[type=submit] {padding:5px 15px; background:#FFFFFF; border:none;
cursor:pointer;
border-radius: 2px 0px 0px 12px;


 
 }

textarea {
   resize: none;
}

a:link {
color: #FFFFFF;
}
a:visited {
color: #FFFFFF;
}
a:hover {
color: #000000;
}
 
 #page-wrap  {
    width: 300px;
    background-image:url(background_info.png);
	background-repeat:no-repeat;
    height: 400px;
    margin-left: 285px;
}
</style>	

<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>	
</head>

<body>
<?php
if(!empty($errors)){
echo "<p class='err'>".nl2br($errors)."</p>";
}
?>
<div id='contact_form_errorloc' class='err'></div>
<form method="POST" name="contact_form" 
action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 
<p>
<label for='name'>Nom: </label><br>
<input type="text" name="name" value='<?php echo htmlentities($name) ?>'>
</p>
<p>
<label for='email'>Email: </label><br>
<input type="text" name="email" value='<?php echo htmlentities($visitor_email) ?>'>
</p>
<p>
<label for='message'>Message:</label> <br>
<textarea name="message" rows=8 cols=30 maxlength=200><?php echo htmlentities($user_message) ?></textarea>
</p>
<p>
<img src="captcha_code_file.php?rand" id='captchaimg' ><br>
<label for='message'>Entrez le code ci-dessous :</label><br>
<input id="6_letters_code" name="6_letters_code" type="text"><br>
<small>Vous pouvez pas lire l'image? <a href='javascript: refreshCaptcha();'>cliquez ici</a> pour rafraîchir</small>
</p>
<div class="wrapper"><input type="submit" value="Envoyer" name='submit' ></div>
</form>
<div id="page-wrap"></div>
 



<script language="JavaScript">
var frmvalidator  = new Validator("contact_form");
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();
frmvalidator.addValidation("name","req","Veuillez saisir votre nom"); 
frmvalidator.addValidation("email","req","Veuillez saisir votre email"); 
frmvalidator.addValidation("email","email","Veuillez entrer une adresse électronique valide"); 
frmvalidator.addValidation("message","req","Veuillez saisir votre message "); 
</script>

<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>