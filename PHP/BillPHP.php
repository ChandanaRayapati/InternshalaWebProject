<?php 

    session_start();
    //User will be directed to Loginpage if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){  
        header("Location:LoginPHP.php");
    }
?>
<!DOCTYPE html>
<html>
    
    <head>
        <title>Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssviewplan.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    </head>
    <body style="background-color: whitesmoke;">
        
        <?php
            //Including Navigation bar
            $page='Bill';
            include 'Header_in.php';
        ?>
        
        <br><br><br>
        <div class="heading" ><b>Your Bill</b></div>
        
        <div style="text-align: center;">
            <!-- I'm getting the file path from get method and giving that to src of image-->
            <img alt="Cannot display your Bill !" src="<?php echo $_GET['index']; ?>" class="image"> 
        </div>
        
        <!-- This button takes back the user to Viewplan page.-->
        <form method="get" action="ViewplanPHP.php">    
            <button  type="submit" class="gobackbutton"><span class="glyphicon glyphicon-arrow-left" ></span> Go back</button>  
        </form>
    </body>   
</html>