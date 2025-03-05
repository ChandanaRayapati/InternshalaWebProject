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
        <title>Create New Plan | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssaddplan.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       
        <?php
            //Including Navigation bar
            $page='Addplan';
            include 'Header_in.php';
        ?>
        
        <?php
            //Declaring variables
            $aperr1=$aperr2=$aperr3="";
            $ibudget=$noppl=0;
            $a=$b=0;
        
            //Validations are made(server side also)->
            //If the input is empty/negative an error message is displayed.
            //Further, I have kept limitations on the budget and number of people.
            if(isset($_POST['submit'])){
                 
                if(empty($_POST["ibudget"])){
                    $aperr1=" *Enter the Initial Budget" ;
                }
                elseif($_POST["ibudget"]<100){
                    $aperr1=" *Budget must be above 100" ;
                }
                elseif($_POST["ibudget"]>1000000){
                    $aperr1=" *Max. Initial Budget is 10Lakhs!" ;
                }
                else {
                    $a=1;
                    $ibudget= $_POST["ibudget"];
                }
            
            
                if(empty($_POST["noppl"])){
                    $aperr2=" *Enter the Number of People" ;
                }
                elseif ($_POST["noppl"]<1) {
                    $aperr2=" Atleast 1 person must be in the group!"  ;
                }
                elseif($_POST["noppl"]>20){
                    $aperr2=" Maximum of Twenty people are allowed!" ;
                }
                else {
                    $b=1;
                    $noppl= $_POST["noppl"];
                }
            }
            if($a==1 && $b==1){
                //If all the inputs are correct then he is directed to PlanDetails page where 
                //further details of plan are asked.
                //I used Session variables to further use those details in PlanDetails page.
                $_SESSION['ib']=$ibudget;
                $_SESSION['ppl']=$noppl;
                header("Location:PlanDetails.php") ;
            }
        ?>
        <!--Panel for creating a new plan-->
        <div class="panel panel-default panelclass"> 
            <div class="panel-heading"><strong >Create New Plan</strong></div>
            <div class="panel-body">  
                <form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   
                    <label for="ibudget">Initial Budget</label><span class="error"><?php echo $aperr1; ?></span>
                    <input type="number" class="form-control" min="100" max="1000000" required  name="ibudget" placeholder="Initial Budget (Ex. 5000)" value="<?php echo isset($_POST["ibudget"]) ? $_POST["ibudget"] :""?>" >
                        
                    <label for="noppl">How many people you want to add in the group?</label><span class="error"><?php echo $aperr2; ?></span>
                    <input type="number" class="form-control" min="1" max="20" required name="noppl" placeholder="Number of people" value="<?php echo isset($_POST["noppl"]) ? $_POST["noppl"] :""?>">
                        
                    <input type="submit" class="button" name="submit" value="Next">
                    <span class="error"><?php echo $aperr3; ?></span>
                </form> 
            </div>
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



