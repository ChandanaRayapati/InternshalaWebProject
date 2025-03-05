<?php
    session_start(); 
    
    //User will be directed to Loginpage if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    }  
    
    //Connection to Database.
    require 'ConnectiontoDB.php'; 
    
    //Getting all the details of a plan by it's id from plans table in db.
    $planid=$_SESSION['planid'];  
    $query5="SELECT title,fromdate,todate,budget,peopleno,peoplename FROM plans WHERE planid='$planid'";       
    $query5_result=mysqli_query($con,$query5);
    if($query5_result)
        {
          //Storing these values in session variables to use them in Expense Distribution and New Expense pages.
          $row2= mysqli_fetch_array($query5_result);
          
          //I have used serialize() on array having names of people in a plan.
          //Now Unserializing the persons' names array to get individual names.
          $temparr = unserialize($row2['peoplename']);
          $_SESSION['peoplename']=$temparr;
          $_SESSION['title']=$row2['title'];
          $_SESSION['fromdate']=$row2['fromdate'];
          $_SESSION['todate']=$row2['todate'];
          $_SESSION['budget']=$row2['budget'];
          $_SESSION['peopleno']=$row2['peopleno'];
        }
    else{ die(mysqli_error($con));}
    
    $money_spent=0;
    
    $con7= mysqli_connect("localhost","root","","project")  or die(mysqli_error($con7));
    
    //Getting all the expenses in the plan from expenses table.
    $query7="SELECT * FROM expenses WHERE planid='$planid' ORDER BY expid DESC";
    $query7_result= mysqli_query($con7, $query7) or die(mysqli_errno($con7));
    
    if($query7_result){
        $count1= mysqli_num_rows($query7_result);
        $i=0;
        //Storing all the expenses' details in an array.
        while ($row7= mysqli_fetch_array($query7_result)){
            
            $arraylist[$i]['titleexpense']=$row7['titleexpense'];
            $arraylist[$i]['expdate']=$row7['expdate'];
            $arraylist[$i]['paidby']=$row7['paidby'];
            $arraylist[$i]['amount']=$row7['amount']; 
            $arraylist[$i]['expfile']=$row7['expfile'];
            $money_spent+=$row7['amount'];//Calculating the total amount spent.
         $i++;   
        }
        
        //Calculating the Remaining amount in the plan.
        $money_left= $_SESSION['budget'] - $money_spent; 
        $_SESSION['moneyleft']= $money_left;
    }
    else {die(mysqli_error($con7));}
        
        
    
    function getcolor($a){//This function returns a color based on the sign of the amount.
        if ($a>0){
         return '#4caf50';}//Green for positive amount, red for negative amount and black for zero.
        elseif ($a<0){
         return  '#d50000';}
        else if ($a==0){
         return  'black';}
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
    <body>
       
        <?php
            $page='Viewplan';
            require 'Header_in.php';//Including Navigation bar
            require 'DatePHP.php';//Including this function to display date in dd mmm yyyy format.
            
            require 'SidenavPHP.php';
        ?>
    
        <div class="main_content">
            <!-- This panel displays the details of the plan like title,initial budget, remaining amount etc. -->
            <div  class="panel panel-default panelclass">
                <div class="panel-heading">                
                    <div class="row" >
                        <div class="col-xs-12 divclass" style="text-align: center;"><strong><?php echo $_SESSION['title']; ?></strong> <strong class="ppl"><?php echo $_SESSION['peopleno']; ?></strong><span class="glyphicon glyphicon-user" style="float: right;margin-right: 5px;"> </span></div> 
                    </div>    
                </div>             
                <div class="panel-body">                  
                    <div class="row"  >
                        <div class="col-xs-6 divclass" style="text-align: left;"><strong>Initial Budget</strong></div>
                        <div class="col-xs-6 divclass" style="text-align : right;"> ₹ <?php echo  $_SESSION['budget']; ?></div>     
                    </div> <br>                      
                    <div class="row"  >
                        <div class="col-xs-6 divclass" style="text-align: left;"><strong>Remaining Amount</strong></div>
                        <div class="col-xs-6 divclass" style="text-align : right;color:<?=getcolor($money_left)?>;"><strong><?php 
                        if($money_left>0 || $money_left==0){
                          echo "₹ ".$money_left;}
                         elseif($money_left<0){
                          $money_left*= -1;
                          echo "Overspent by ₹ ".$money_left;} ?></strong>
                        </div>     
                    </div> <br>                     
                    <div class="row"  >
                        <div class="col-xs-3 divclass" style="text-align: left;"><strong>Date</strong></div>
                        <div class="col-xs-9 divclass" style="text-align: right;"><?php echo getactualdate($row2['fromdate'], 0); ?> - <?php echo getactualdate($row2['todate'], 1); ?></div> 
                    </div>
                </div>            
            </div>
            
            <form method="get" action="ExpenseDistPHP.php">    
                <button  type="submit" class="expdistbtn"> Expense Distribution </button>  
            </form>
            
            <?php 
                 if($count1>0){ 
                    //All expenses in a plan are displayed below the details of the plan.
                    echo '<div class="heading" ><b>Expenses under the Plan</b></div>';
                    //If there are expenses, a list of panels each containing an expense's details is displayed.
                    for($i=0;$i< count($arraylist);$i++){             
            ?>    
         
            <div class="panel panel-default panelclass1">
                <div class="panel-heading">                
                    <div class="row" >
                        <div class="col-xs-12 divclass" style="text-align:center;"><?php echo $arraylist[$i]['titleexpense']; ?></div> 
                    </div>    
                </div>             
                <div class="panel-body">                  
                    <div class="row"  >
                        <div class="col-xs-4 divclass" style="text-align: left;"><strong>Amount</strong></div>
                        <div class="col-xs-8 divclass" style="text-align : right;"> ₹ <?php echo  $arraylist[$i]['amount']; ?></div>     
                    </div><br>                      
                    <div class="row"  >
                        <div class="col-xs-5 divclass" style="text-align: left;"><strong>Paid by</strong></div>
                        <div class="col-xs-7 divclass" style="text-align : right;"><?php echo  $arraylist[$i]['paidby']; ?></div>     
                    </div><br>                     
                    <div class="row"  >
                        <div class="col-xs-5 divclass" style="text-align: left;"><strong>Paid on</strong></div>
                        <div class="col-xs-7 divclass" style="text-align: right;"><?php echo getactualdate($arraylist[$i]['expdate'],1); ?></div> 
                    </div>
                </div>
                <div class="panel-footer">
                    
                    <!-- Here I made use of form to get exact file path  when showbill link is clicked.  -->
                    <form  method="get" action="BillPHP.php">
                        <input type="hidden" name="index" value="<?= $arraylist[$i]['expfile']; ?>" >
                
                        <?php 
                            if($arraylist[$i]['expfile']==NULL){
                               //If no file was uploaded, then this div is displayed.
                               $str="You don't have a bill";
                               echo "<div><a class='disabled' href='#'>$str</a></div>";
                            }
                            else {
                        ?>
                        <!-- If a file was uploaded, then this button is shown. -->
                        <input  type="submit" name="bill" class="bill_link"  value="Show bill">
                        <?php  }  ?>
                    </form>    
                </div>  
            </div> 
            <?php   }
                //When showbill button is clicked, we get its file path from hidden input index.
                //User will be redirected to Bill page where bill is displayed.
                if(isset($_POST['bill'])){
                    $_SESSION['img']=$_POST['index'];
                    header("Location:BillPHP.php");
                }  }
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






