<?php
    session_start();
    //If the session 'isLogged' is not set, user will be redirected to Login page.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    } 

?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>About Us | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssabout.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    </head>
    
    <body>
        
        <!-- Had to make two separate about pages because the headers(navigation bars) are different
        for both pages(One before login and one after login).-->
        <?php
            //Including the navigation bar
            $page='About';
            include 'Header_in.php';
        ?>
 
      <!--About container-->
      <div class="container">
        <div class="row">
            <div class="container-fluid">
                <div class="col-xs-12 col-md-6"><h2>Who are we?</h2>
                    <p>We are a group of young technocrats who came up with an idea of solving budget and time issues which we usually face in our daily lives.
                       We are here to provide a budget controller according to your aspects. Budget Control is the biggest financial issue in the present world. One should look after their budget control to get rid off
                       from their financial crisis.</p>    
                </div>
                <div class="col-xs-12 col-md-6"><h2>Why choose us?</h2> 
                    <p>We provide with a predominant way to control and manage your budget estimations 
                    with ease of accessing for multiple users.</p> 
                </div>
            </div>    
        </div>
           
        <div class="col-xs-12"><h2>Our Leads</h2></div>
        
        <div class="row">
            <div class="team">
                
                <div class=" team-mem col-xs-12 col-md-6" style="float:left;">
                    <img src="images/tom.png" alt="TOM"><br>
                    <strong>Tom</strong>
                    <p class="mem-role">Founder</p>
                    <p> Responsible for setting the company's vision and making sure that it is unique and attractive to consumers.
                        Concentrates on creating value for our customers and makes sure that the company is constantly evolving and changing with time.
                    </p>       
                </div>
                
                <div class=" team-mem col-xs-12 col-md-6" style="float:right;">
                    <img src="images/robert.png" alt="ROBERT"><br>
                    <strong>Robert</strong>
                    <p class="mem-role">Manager and Developer</p>
                    <p>Accomplishes department objectives by managing staff, planning and evaluating department activities. Maintains staff by recruiting, selecting, orienting, and training employees. 
                        Ensures a safe, secure, and legal work environment.
                    </p>       
                </div>     
            </div>     
        </div>
        
        <div class="row">
            <div class="container-fluid">
                <div class="col-xs-12 col-md-6"><h3>For Queries</h3>
                    <p>For any query, please email question and feature request 
                        directly to developer at supportctrlbudget@gmail.com. We actively support users.
                    </p>    
                </div>
                <div class="col-xs-12 col-md-6"><h3>Contact Us</h3>
                    <p><strong>E-mail:</strong> ctrlbudget@gmail.com</p>
                    <p><strong>Mobile:</strong> +91-8448444853.</p>        
                </div>
            </div>    
        </div>
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




