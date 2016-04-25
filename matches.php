<!DOCTYPE html>
<html>
    <head>
    <title>Matches</title>
    <link href="Geekluv1.css" type="text/css" rel="stylesheet" />
    </head>
    
	<body>
		<div id="bannerarea">
			<img src="nerdxing.jpg" alt="banner logo" /> <br />
			where meek geeks meet
		</div>
<?php
session_start();
$geekname =  " ";
$geeknameErr = "*";

//get name
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(empty($_GET["geekname"])){
        $geeknameErr = "Name is required!";
    }else{
        $geekname = clean_data($_GET["geekname"]);
        $geeknameErr = " ";
        if(!preg_match("/^[a-zA-Z\s]{1,16}$/",$geekname)){
            $geeknameErr = "Letters and space only!";
        }
    }

//check file for the name
    $file = file_get_contents("singles2.txt");
    if(strpos($file, $geekname)==False){
        $geeknameErr = "Sorry we don't have that name!";
    }
    
    $_SESSION["geekname"] = $geekname;
    
//link to page matches-submit
    if ($geeknameErr == " "){
        header('Location: matches-submit.php');
        }
}
      
function clean_data($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

        
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" enctype="multipart/form-data">
        
            <fieldset>
                
                <div id="titles"><h1>Name:</h1></div>
                
                <legend><h1>Returning User:</h1></legend>
                <div id="inputs">
                <div>
                    <input type="text" name="geekname" size="16"/>
                    <span class="error"><?php echo $geeknameErr;?></span>
                </div>
         
                </div>
                <div id="submitclear">
                    <input type="submit"/>
                </div>
            </fieldset>
        </form>

        <?php
                    include 'common.php';
                ?>
    </body>
</html>