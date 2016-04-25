
<?php
		session_start();
		$newuser = $_SESSION["geekname"];


		$file = 'singles2.txt';

		// the following line prevents the browser from parsing this as HTML.
		//header('Content-Type: text/plain');

		// get the file contents, assuming the file to be readable (and exist)
		$contents = file_get_contents($file);
		// escape special characters in the query
		$pattern = preg_quote($newuser, '/');
		// finalise the regular expression, matching the whole line
		$pattern = "/^.*$pattern.*\$/m";
		// search, and store all matching occurences in $matches
		if(preg_match_all($pattern, $contents, $matches)){
		   //echo "Found matches:\n";
		   $new = implode("\n", $matches[0]);
		}
		else{
		   echo "No matches found";
		}
		$list = explode(",", $new);
		$geekname = $list[0];
		$gender = $list[1];
		$age = $list[2];
		$type = $list[3];
		$os = $list[4];
		$minage = $list[5];
		$maxage = $list[6];
		$seekgender = $list[7];

		//make sure gender seeking and gender of person are the same
		if($seekgender == "M"){
			$pattern = preg_quote(",M,", '/');
			$pattern = "/^.*$pattern.*\$/m";
			$result = preg_match_all($pattern, $contents, $matches);
			$fornow = implode("\n", $matches[0]);
			//echo $fornow;
		}
		elseif ($seekgender == "F") {
			$pattern = preg_quote(",F,", '/');
			// finalise the regular expression, matching the whole line
			$pattern = "/^.*$pattern.*\$/m";
			$result = preg_match_all($pattern, $contents, $matches);
			$fornow = implode("\n", $matches[0]);
			//echo $fornow;
		}

		else {
			$pattern = preg_quote(",F,", '/');
			// finalise the regular expression, matching the whole line
			$pattern = "/^.*$pattern.*\$/m";
			$result = preg_match_all($pattern, $contents, $matches);
			$fornow = implode("\n", $matches[0]);
			//echo $fornow;

			$pattern = preg_quote(",M,", '/');
			// finalise the regular expression, matching the whole line
			$pattern = "/^.*$pattern.*\$/m";
			$result = preg_match_all($pattern, $contents, $matches);
			$maleoptions = implode("\n", $matches[0]);
			//echo $fornow;
		}

			$temp = explode("\n", $fornow);
			$temp1 = explode("\n", $maleoptions);
			array_merge($temp, $temp1);

			//filter matches
			$yourmatches = array();
		   	for($i=0;$i<sizeof($temp); ++$i){
		   		$toexplode = $temp[$i];
		   		$elements= explode(",", $toexplode);
		  		//check that within age range, gender
		   		if((int)$elements[2] >= (int)$minage && (int)$elements[2] <= (int)$maxage && (int)$age >= (int)$elements[5] && (int)$age<= (int)$elements[6] && $elements[0]!=$geekname && $elements[7] == $gender ) {
		   			//check OS
		   			if($os == "Mac OS X" && $elements[4] != "Windows"){

						if(similar_text($elements[3], $type)>=1){
							//echo $temp[$i];
							$yourmatches[] = $temp[$i];}}		   				
		   			}
		   			elseif($os == "Linux" && $elements[4] != "Windows"){
						if(similar_text($elements[3], $type)>=1){
							//echo $temp[$i];
							$yourmatches[] = $temp[$i];}}		   				
		   			

		   			elseif($os== "Windows" && $elements[4] == "Windows"){
						if(similar_text($elements[3], $type)>=1){
							//echo $temp[$i];
							$yourmatches[] = $temp[$i];}}		   				
		   			
		   				

		   		}
		   	
		  //size of array
		$count = sizeof($yourmatches);




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
            <b> Welcome to NerdLuv, <?php echo $_SESSION["geekname"] ?>.</b><br><br>
            Now here are your matches! <br>
        </div>

        <div class = "match">
        	<?php 
        		for ($i=0; $i < $count; $i++) {
        			//for each person in array split 
		        	$toprint = explode(",", $yourmatches[$i]);
		        	$matchname = $toprint[0];
		       		$matchgender = $toprint[1];
		  			$matchage = $toprint[2];
	       			$matchtype = $toprint[3];
        			$matchos = $toprint[4]; 

        			//possible image file
        			$imagefilename = strtolower(str_replace(" ", "-", $matchname)).".jpg";
        			
        			?>

        	<p class = "match" id="imgdiv">
        		<p class = "match"> <?= $matchname ?> </p>
        	</p>
        	<div>
	        	<?php 
	        		//if a file exists use it
	        		if(file_exists("userphotos/".$imagefilename)){
	        			echo '<img class = "march" src = "userphotos/'.$imagefilename.'" alt = "prof" />';
	        		}
	        		//otherwise use generic one
					elseif($matchgender == "M"){
						?>
						<img class = "match" src = "userm.png" alt = "fprof"/>
				<?php }elseif ($matchgender == "F"){?>
						<img class = "match" src = "user.png" alt = "fprof" />
						<?php } ?>
        		<ul class = "match">
        			<li><strong> gender: </strong> <?= $matchgender ?> </li>
        			<li><strong> age: </strong> <?= $matchage ?> </li>
        			<li><strong> type: </strong> <?= $matchtype ?> </li>
        			<li><strong> os: </strong> <?= $matchos ?> </li>
 				</ul>
 			</div>
 			<?php } ?>
 		</p>
        </div>
                <?php
                    include 'common.php';
                ?>
    </body>
</html>
