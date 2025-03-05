<?php
    ob_start();
    session_start();
    //User will be directed to Login page if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    }
    //Connection to Database.
    require 'ConnectiontoDB.php';
    $email=$_SESSION['email'];
    $query4="SELECT planid,title,fromdate,todate,budget,peopleno FROM plans WHERE email='$email' ORDER BY planid DESC";       
    $query4_result=mysqli_query($con,$query4)or die(mysqli_error($con));     
?>

<!DOCTYPE html>
<html> 
    
    <head>
        <title>Dashboard | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssdashboard.css?<?php echo time(); ?>"> 
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    </head>
    <body>
       
        <?php
          
            $page='Dashboard';
            include 'Header_in.php'; //Including Navigation bar
            require 'DatePHP.php';//Including this function to display date in dd mmm yyyy format.
            if($query4_result){
                     
                $plans_count = mysqli_num_rows($query4_result);
                $temparray=array();
        ?>
     
        <!--side navigation-->  
        <div class="sidebar"> 
            <a class="addplan" href="AddplanPHP.php" ><i class="glyphicon glyphicon-plus-sign"></i> Add new Plan</a>
            <div class="totalplans"><h3>Total Plans</h3><h1><?php echo $plans_count; ?></h1></div>
        </div>   
    
        <div class="main_content">
        
            <?php
                if($plans_count==0){
                    //If there are no plans, this Add new plan panel is displayed which redirects to Addplan page
                    //when clicked.
                    $str="You don't have any active plans. Create one now!";
                    echo "<div class='divhead'>$str</div>";                
                    echo '<form method="get" action="AddplanPHP.php">';    
                    echo '<button  type="submit" class="divclass_body"><span class="glyphicon glyphicon-plus-sign" ></span><b> Create a New Plan</b> </button>';  
                    echo '</form>'; 
                    } 
                else{
            ?>
                <!-- If there are plans, then this glyphicon-plus-sign is displayed at bottom of the page.-->
                <!--This redirects to Addplan page when clicked.-->
                    <div  class="plussign"><a href="AddplanPHP.php" data-toggle="tooltip" data-placement="left" title="Create new plan" >
                        <span class="glyphicon glyphicon-plus-sign" style="color: #009688;font-size: 60px;"></span></a>
                    </div>
            <?php 
                  
                echo '<div class="divclass_head"> <b> Your Plans</b></div>';
                $a=0;
                //Fetching all the plans from database table and storing them in an array.
                while($row1= mysqli_fetch_array($query4_result)){    
                       
                    $temparray[$a]['index'] = $row1['title'];
                    $temparray[$a]['from'] = $row1['fromdate'];
                    $temparray[$a]['to'] = $row1['todate'];
                    $temparray[$a]['budget']=$row1['budget'];
                    $temparray[$a]['title'] = $row1['title'];
                    $temparray[$a]['people'] = $row1['peopleno'];
                    $temparray[$a]['planid']=$row1['planid'];

                    $a=$a+1;
                }
                $count=0;
                while ($count<$plans_count){
                    //Each row contains two plans.
                    //These rows and panels get adjusted based on the screen width.
                    echo '<div class="row row1">';
                    for($i=0;$i<2;$i=$i+1){
                        if($count==$plans_count){break;}
            ?>
            <!--Panel for a plan-->
            <div class="panel panel-default col-xs-12 col-lg-6 panelclass ">
                <div class="panel-heading">
                                    
                    <div class="row" >
                        <div class="col-xs-12 divclass" style="text-align: center;"><strong><?php echo $temparray[$count]['title']; ?></strong> <strong class="ppl"><?php echo " ".$temparray[$count]['people']; ?></strong><span class="glyphicon glyphicon-user" style="float: right;margin-right: 5px;"> </span></div> 
                    </div>    
                </div>
                <div class="panel-body"> <br>
                                
                    <div class="row">
                        <div class="col-xs-6 divclass" style="text-align: left;"><strong class="strong">Initial Budget:</strong></div>
                        <div class="col-xs-6 divclass" style="text-align : right;"> ₹ <?php echo $temparray[$count]['budget']; ?></div>     
                    </div> <br>
                                    
                    <div class="row"  >
                        <div class="col-xs-3 divclass" style="text-align: left;"><strong class="strong">Date:</strong></div>
                        <div class="col-xs-9 divclass" style="text-align: right;"><?php  $d=getactualdate($temparray[$count]['from'],0)  ;echo $d; ?> - <?php $dd=getactualdate($temparray[$count]['to'],1)  ;echo $dd; ?></div> 
                    </div>
                    <form  method="post">
                        <input type="hidden" name="index" value="<?= $temparray[$count]['planid']; ?>" >
                        <input  type="submit" name="viewplan" class="button"  value="Viewplan">
                    </form>
                </div>
            </div> 
        
            <?php 
                $count=$count+1;  
                }
                echo '</div>';
                }
                if(isset($_POST['viewplan'])) { 
                    
                    //We store the id of the plan in a session variable when viewplan button is clicked.
                    //The user is taken to Viewplan page.
                    $_SESSION['planid']=$_POST['index'];
                    header("Location:ViewplanPHP.php");
                }                 
                }}
            ?>
        </div>   
       
        <!--footer-->
        <div class="footer">
        <!-- Copyright -->
            <div ><tt>Copyright © Control Budget
                All Rights Reserved|Contact Us: +91-8448444853.</tt>
            </div>     
        </div>  
    </body>
</html>



