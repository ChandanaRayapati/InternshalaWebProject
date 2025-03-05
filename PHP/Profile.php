<?php

    session_start();
    //User will be directed to Login page if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    }   
    
    //Function that returns the src by taking gender input.
    function getimage($a){
        if($a=='M'){
            return 'images/profile_1.jpg';
        }
        elseif ($a=='F') {
            return 'images/profile_2.jpg';
        }
        elseif($a=='O'){
            return 'images/profile_3.png';    
        }
    }
    
    
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Profile | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssindex.css?<?php echo time(); ?>"> 
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    </head>
    <body>
       
        <?php
          
            $page='Profile';
            include 'Header_in.php'; //Including Navigation bar    
        ?>
        
        <!--Profile jumbotron-->
        <div class="jumbotron myclass_profile">
                
            <!--The profile picture is displayed based on gender.-->
            <img src='<?=getimage($_SESSION['gender']) ?>' class="img_profile" alt="Profile Image"><br><br>
            <!--User details are obtained from session variables.-->
            <h5>Username : <?php echo $_SESSION['name']; ?><br><br>
                E-mail :   <?php echo $_SESSION['email']; ?><br><br>
                Mobile :  +91- <?php echo $_SESSION['mobile']; ?></h5>      
        </div>
       
       
        <!--footer-->
        <div class="footer col-xs-12">
            <!-- Copyright -->
            <div ><tt>Copyright © Control Budget
                    All Rights Reserved|Contact Us: +91-8448444853.</tt>
            </div>      
        </div>  
    </body>
</html>

