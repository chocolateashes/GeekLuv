<?php
session_start();
$newuser = $_SESSION["geekname"].",".$_SESSION["gender"].",".$_SESSION["age"].",".$_SESSION["personality"].",".$_SESSION["os"].",".$_SESSION["min"].",".$_SESSION["max"].",".$_SESSION["photo"]."\n";
echo $newuser;

//file with the list of singles in it
$File = "singles2.txt";
$singlesfile = fopen($File,'a');
fwrite($singlesfile,$newuser);
fclose($singlesfile);
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Signup</title>
    <link href="Geekluv1.css" type="text/css" rel="stylesheet" />
    </head>
    
	<body>
		<div id="bannerarea">
			<img src="nerdxing.jpg" alt="banner logo" /> <br />
			where meek geeks meet
		</div>
        <div>
            <b>Thank you!</b><br><br>
            Welcome to NerdLuv, <?php echo $_SESSION["geekname"] ?><br><br>
            Now<a href="matches.php"> log in to see your matches!</a>
        </div>
                <?php
                    include 'common.php';
                ?>
    </body>
</html>