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
<?php
session_start();

//define variables and set to empty values
$geekname = $gender = $age = $personality = $os = $min = $max =$seekgender = $imagefile = " ";
$geeknameErr = $genderErr = $ageErr = $personalityErr = $minErr = $maxErr = $seekgenderErr = $imageErr = "*";

//check name
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["geekname"])){
        $geeknameErr = "Name is required!";
    }else{
        $geekname = clean_data($_POST["geekname"]);
        $geeknameErr = " ";
        if(!preg_match("/^[a-zA-Z\s]{1,16}$/",$geekname)){
            $geeknameErr = "Letters and space only!";
        }
    }
    //check gender
    if(empty($_POST["gender"])){
        $genderErr = "Select a gender!";
    }else{
        $gender = clean_data($_POST["gender"]);
        $genderErr = " ";
    }

    //check age
    if(empty($_POST["age"])){
        $ageErr = "Enter your age!";
    }else{
        $age = clean_data($_POST["age"]);
        $ageErr = " ";
        if($age<18){
            $ageErr = "You are too young!";
        }
        if(!preg_match("/^\d{2}/",$age)){
            $ageErr = "Only numbers!";
        }
    }
    
    //check personality type
    if(empty($_POST["personality"])){
        $personalityErr = "Enter personality type!";
    }else{
        $personality = strtoupper(clean_data($_POST["personality"]));
        $personalityErr = " ";
        if(!preg_match("/^[a-zA-Z]{4}$/",$personality)){
            $personalityErr = "Only 4 letters!";
        }
    }
    
    //check operating system
    $os = clean_data($_POST["os"]);
    

    //check maximum age
    if(empty($_POST["max"])){
        $maxErr = "Enter max age!";
    }else{
        $max = clean_data($_POST["max"]);
        $maxErr = " ";
        if(!preg_match("/^\d{2}/",$max)){
            $maxErr = "Only numbers!";
        }
    }
    
    //check minimum age
    if(empty($_POST["min"])){
        $minErr = "Enter min age! ";
    }else{
        $min = clean_data($_POST["min"]);
        $minErr = " ";
        if($min<18){
            $minErr = "18 and up...";
        }
        if($min>$max){
            $minErr = "Max age must be greater!";
        }
        if(!preg_match("/^\d{2}/",$min)){
            $minErr = "Only numbers!";
        }
    }

    //check gender you are seeking
    if(empty($_POST["seekgender"])){
        $seekgenderErr = "Select a gender!";
    }else{
        $seekgender = clean_data($_POST["seekgender"]);
        $seekgenderErr = " ";
    }

//UPLOAD FILE
    $target_dir = "userphotos/";

    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $codeFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if($uploadOk == 0) {
        $imageErr = "Your file was not uploaded";
    } else {
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)){
            $imagefile = basename( $_FILES["photo"]["name"]);
        } else {
            $imageErr = "Sorry there was an error!";
        }
    }

    
    $file = file_get_contents("singles2.txt");
    if(strpos($file, $geekname)){
        $geeknameErr = "Invalid Name!";
    }
    
    $_SESSION["geekname"] = $geekname;
    $_SESSION["gender"] = $gender;
    $_SESSION["age"] = $age;
    $_SESSION["personality"] = $personality;
    $_SESSION["os"] = $os;
    $_SESSION["min"] = $min;
    $_SESSION["max"] = $max;
    $_SESSION["seekgender"] = $seekgender;
    $_SESSION["photo"] = $imagefile;
    
    
    if ($geeknameErr == " " && $genderErr == " " && $ageErr == " " && $personalityErr == " " && $minErr == " " && $maxErr == " " && $seekgenderErr == " "){
        header('Location: signup-submit.php');
        }
}
      
function clean_data($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

        
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        
            <fieldset>
                
                <div id="titles"><h1>Name:<br>Gender:<br>Age:<br>Personality type:<br>Favorite OS:<br>Seeking age:<br>Seeking gender(s):<br>Upload Photo:</h1></div>
                
                <legend><h1>New User Sign Up:</h1></legend>
                <div id="inputs">
                <div>
                    <input type="text" name="geekname" size="16"/>
                    <span class="error"><?php echo $geeknameErr;?></span>
                </div>
                <div>
                    <label><input type="radio" name="gender" value="M"/>Male </label>
                    <label><input type="radio" name="gender" value="F"/>Female </label>
                    <span class="error"><?php echo $genderErr;?></span>
                </div>
                <div>
                    <label><input type="text" name="age" size="6"/></label>
                    <span class="error"><?php echo $ageErr;?></span>
                </div>
                <div>
                    <label style = "font-size:9px"><input type="text" name="personality" maxlength="4" size="6"/> <a href = "http://www.humanmetrics.com/cgi-win/jtypes2.asp" style = "font-size: 11px"> Don't know your personality type? </a></label>
                    <span class="error"><?php echo $personalityErr;?></span>
                </div>
                <div>
                    <select name="os">
                        <option value="Windows">Windows</option>
                        <option value="Mac OS X">Mac OS X</option>
                        <option value="Linux">Linux</option>
                    </select>
                </div>
                <div>
                    <input type="text" name="min" placeholder="min" maxlength="2" size="6"/>to<input type="text" name="max" placeholder="max" maxlength="2" size="6"/><span class="error"><?php echo $minErr;?></span><span class="error"><?php echo $maxErr;?></span>
                </div>
                <div>
                    <label><input type="checkbox" name="seekgender" value="M"/>Male </label>
                    <label><input type="checkbox" name="seekgender" value="F"/>Female </label>
                    <span class="error"><?php echo $seekgenderErr;?></span>
                </div> 
                <div>
                    <input type="file" name="photo" /><a style = "font-size: 11px"> File must be firstname-lastname.jpg</a>
                    <span class="error"> <?php echo $imageErr;?></span>
                </div>
                <div id="submitclear">
                    <input type="submit" value = "Sign Up!" />
                </div>
            </fieldset>
        </form>

        <?php
                    include 'common.php';
                ?>
    </body>
</html>