<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssindex.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php
        
            //Including Navigation bar
            $page="index";
            include 'header.php';
        ?>
     
       
       <!--get started jumbotron-->
        <div class="jumbotron myclass">
                
            <p class="p">Tired of maintaining budget?</p>
            <p class="p">We can help you!</p><br>            
            <a href="LoginPHP.php" ><div class="gsbutton">Get Started</div></a>
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



