<?php
require_once './php/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
<link rel="icon" href="img/loc.png"> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Baby-Name-Poll</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/scrolling-nav.css" rel="stylesheet">
	<link href="style/main.css" rel="stylesheet" type="text/css"/>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav  class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="img/loc.png" width="50" height="50"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Vote</a>
            </li>
           
          </ul>
        </div>
      </div>
    </nav>

    <header class="w bg-primary text-white">
      <div class="container text-center">
        <h1></h1>
        <p class="lead"></p>
      </div>
    </header>

	
	
	

	

	
	
    <section href="#about" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            
			<h1 style="bottom: 20px;" class="text1" >Baby Names Poll</h1>
			<div class="outer">
		
			
			
	
			
			<form class="form-horizontal" action="index.php" method="POST">
                

                <div class="form-group"> 
                    <div class="checkbox-inline"><img src="img/male.png" height="50" width="50">
                        <label for="fahrenheit">Male</label>
                        <input type="radio" name="conversion" id="fahrenheit" value="male">
						
						<label for="celsius">Female</label>
                        <input type="radio" name="conversion" id="celsius" value="female"><img src="img/female.png" height="50" width="50">
                     </div>

                     <div class="form-group">
                    <label for="Bname"></label>
                    <input  placeholder="Insert Name" type="text" id="Bname" name="Bname" class="form-control" required autofocus>
					</div>
                 </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
			
			
<?php
	




				

			
			
function sanitizeString($str) 					// Function strips string variable of tags and lashes in order to check for valid user input
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}


if(isset($_POST['Bname']))
{
	$Bname = sanitizeString($_POST['Bname']);				// Sanitizing user input for conversion 
	$Bname = strtolower($Bname);							// converting string to lower case for uniformity 
	
	
    $output = '<div class="alert alert-warning "><h3>Invalid Name</h3>';	// Save warning alert of invalid input									
	
   if(preg_match("/^[a-zA-Z ]*$/",$Bname)) // preg match is used to only allow letters as input
   {
	   if(isset($_POST['conversion']) && $_POST['conversion'] === 'male')
		{
			$output = '<div class="alert alert-success"><h3>New name inserted: ' .$Bname.'  </h3>  </div>';
			
			
			
			$selectStmt = 'SELECT * FROM `Bnames2`;';
			$result = $db->query($selectStmt);
			
			while($row = $result->fetch_assoc()) 
			{
				
				$id = $row["id"];
				
				$counts = $row["counts"];
				$counts = $counts + 1;
				$check = 0;
				if($row["name"] == $Bname)
				{

					$check = 1;

					$query  = "UPDATE Bnames2 SET counts='".$counts."' WHERE name='".$Bname."'";
					$result = $db->query($query);
					echo '<div class="alert alert-success "><h3>Vote casted for "' .$Bname.'", current votes: ' .$counts.'</h3></div>';
					
					break;
				}
				
			}
			
			if($check == 0)
			{
				echo $output;
				$insertStmt = 'INSERT INTO `Bnames2` (`id`, `name`, `sex`, `counts`)' . PHP_EOL . '   VALUES(NULL, "'.$Bname.'", \'m\' , 1);';
				
				$in = $db->query($insertStmt); 
				
			}
			
			
			
		}
		else if(isset($_POST['conversion']) && $_POST['conversion'] === 'female')
		{
			$output = '<div class="alert alert-success"><h3>New name inserted: ' .$Bname.'  </h3>  </div>';  
			
			
			$selectStmt = 'SELECT * FROM `Bnames2`;';
			$result = $db->query($selectStmt);
			
			while($row = $result->fetch_assoc()) 
			{
				
				$id = $row["id"];
				
				$counts = $row["counts"];
				$counts = $counts + 1;
				$check = 0;
				if($row["name"] == $Bname)
				{

					$check = 1;

					$query  = "UPDATE Bnames2 SET counts='".$counts."' WHERE name='".$Bname."'";
					$result = $db->query($query);
					echo '<div class="alert alert-success "><h3>Vote casted for "' .$Bname.'", current votes: ' .$counts.'</h3></div>';
					//kkkkkkk
					
					break;
				}
				
			}
			
			
			if($check == 0)
			{
				echo $output;
				$insertStmt = 'INSERT INTO `Bnames2` (`id`, `name`, `sex`, `counts`)' . PHP_EOL . '   VALUES(NULL, "'.$Bname.'", \'f\' , 1);';
				
				$in = $db->query($insertStmt); 
			}
			
			
		}
    
   
		//echo $output;
		
	$selectStmt = 'SELECT * FROM `Bnames2` ORDER BY counts DESC;';
	$result = $db->query($selectStmt);
	$topRecord = 0;
	
	if($result->num_rows > 0)
	{
		echo '        <div class="alert alert-primary "><h1>Top 5 voted male names</h1></div>';
		
		
			while($row = $result->fetch_assoc())
			{
				$sex = $row["sex"];
				
				if($topRecord > 4)
					break;
				
				if($sex == "m")
				{
					$topRecord++;
					
					echo '          <div style="text-align: justify"; class="alert alert-primary "><h3>#' . $topRecord . ' ' . $row["name"] . '  (' . $row["counts"] . ')</h3></div>';
				}
	
				
			}
			
		echo '        <div class="alert alert-danger "><h1>Top 5 voted female names</h1></div>';		
			$result = $db->query($selectStmt);
			$topRecord = 0;	
			
			while($row = $result->fetch_assoc())
			{
				$sex = $row["sex"];
				
				if($topRecord > 4)
					break;
				
				if($sex == "f")
				{
					$topRecord++;
					echo '          <div style="text-align: justify"; class="alert alert-danger "><h3>#' . $topRecord . ' ' . $row["name"] . '  (' . $row["counts"] . ')</h3></div>';
				}
	
				
			}
	} 
	else 
	{
		echo '        <div class="alert alert-success">No Results</div>' . PHP_EOL;
	} 
		
		
   }
   else
   {
	   echo $output;
   }
	
	
	
	
	
}










?>			
	

	  
      

    
	
	</div>
			
			
          </div>
        </div>
      </div>
    </section>
	

  
	
	
	
    <!-- Footer -->
    <footer style="height: 150px;" class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Roberto Ferraresi 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="js/scrolling-nav.js"></script>
	<script src="js/temperature.js"></script>

  </body>

</html>
