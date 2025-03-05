<?php
    session_start();
    //User will be directed to Loginpage if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    }
    require 'ConnectiontoDB.php';//Connection to Database.
    
    $id2=$_SESSION['planid'];  
    
    //Getting all the expenses from db which are made under a plan.
    $query8 = "SELECT paidby,amount FROM expenses WHERE planid='$id2'";
    $query8_result=mysqli_query($con,$query8) or die(mysqli_error($con));
    $array=$_SESSION['peoplename'];
    
    $arr=array();
    $share=array();
    
    for($i=0;$i<count($array);$i++){
        
        $arr["$array[$i]"]=0;
        $share["$array[$i]"]=0;    
    }
    
    if($query8_result){
        $rows= mysqli_num_rows($query8_result);
        $total=0;
        $money_left=$_SESSION['budget'];
        while ($row8= mysqli_fetch_array($query8_result)){

            $n=$row8['paidby'];
            $a=$row8['amount'];
            $arr["$n"] += $a;//Storing total amount spent by each person in an assosciate array.
            $total+=$a;      //Calculating the total amount spent.
        }
        $money_left-=$total;//Calculating the remaining amount.
        $ishares=$total/count($array);//Calculating the Individual shares.
    
        for($i=0;$i<count($array);$i++){//Calculating (amount spent- individual shares) for each person in the group.
            $share["$array[$i]"]=$arr["$array[$i]"]-$ishares;
        }
    }
    
    //Function that returns color of the text based on sign of amount.
    function getcolor($a){
        if ($a>0){
            return '#4caf50';   
        }
        elseif ($a<0){
            return  '#d50000';      
        }
        else if ($a==0){
            return  'black';
        }
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
            //Including Navigation bar
            $page='Expensedist';
            include 'Header_in.php';
        ?>
        
        <div class="bged">
            
            <!-- Expense distribution Panel-->
            <div id="expensedist" class="panel panel-default panelclassed">
                <div class="panel-heading ">                
                    <div class="row" >
                        <div class="col-xs-12 divclass" style="text-align: center;"><strong><?php echo $_SESSION['title']; ?></strong> <strong class="ppl"><?php echo $_SESSION['peopleno']; ?></strong><span class="glyphicon glyphicon-user" style="float: right;margin-right: 5px;"></span></div>
                    </div>   
                </div> 
                
                <div class="panel-body">                     
                    <div class="row"  >
                        <div class="col-xs-7 divclass" style="text-align: left;"><strong>Initial Budget</strong></div>
                        <div class="col-xs-5 divclass" style="text-align : right;"> ₹ <?php echo $_SESSION['budget']; ?></div>     
                    </div> <br> 
                
                    <?php 
                        foreach($arr as $n => $n_value){ //Displaying total amount spent by each person in the group.
                    ?>
                    <div class="row">
                        <div class="col-xs-7 divclass" style="text-align: left;"><strong><?php echo  $n; ?></strong></div>
                        <div class="col-xs-5 divclass" style="text-align : right;"> ₹ <?php echo $n_value; ?></div>     
                    </div><br> 
                
                    <?php } ?>
                    
                    <div class="row" >
                        <div class="col-xs-5 divclass" style="text-align: left;"><strong>Total amount spent</strong></div>
                        <div class="col-xs-7 divclass" style="text-align: right;"><strong> ₹ <?php echo $total; ?></strong></div> 
                    </div><br> 
                
                    <div class="row">
                        <div class="col-xs-5 divclass" style="text-align: left;"><strong>Remaining amount</strong></div>
                        <div class="col-xs-7 divclass" style="text-align: right;color: <?=getcolor($money_left)?>;"><strong> ₹ <?php 
                    
                         if($money_left>0 || $money_left==0){
                          echo $money_left;}
                         elseif($money_left<0){
                          $money_left*= -1;
                          echo "Overspent by ₹ ".$money_left;}?>
                        </strong></div>
                    </div><br>           
                    <div class="row" >
                        <div class="col-xs-5 divclass" style="text-align: left;"><strong>Individual shares</strong></div>
                        <div class="col-xs-7 divclass" style="text-align: right;"> ₹ <?php echo round($ishares,2); ?></div> 
                    </div><br> 
                
                    <?php 
                        foreach ($share as $s => $s_value){//Displaying (amount spent- individual shares) for each person.
                    ?>
                
                    <div class="row">
                        <div class="col-xs-6 divclass" style="text-align: left;"><strong><?php echo  $s; ?></strong></div>
                        <div class="col-xs-6 divclass" style="text-align : right;color: <?=getcolor($s_value)?>;"> 
                        <?php
                            if($s_value>0) {
                                echo 'Gets back ₹ '.round($s_value,2);//Rounding off upto 2 decimal digits.
                            }
                            elseif ($s_value<0) {
                                $s_value*= -1;           //Making sure that if amount is negative minus(-) sign
                                echo 'Owes ₹ '.round($s_value,2);//is not displayed.
                            }
                            elseif ($s_value==0) {
                                echo 'All Settled up';                           
                            }     
                        ?>
                        </div>     
                    </div><br> 
                
                    <?php } ?>
              
                    <!-- When this button is clicked, user is directed back to Viewplan page-->
                    <form method="get" action="ViewplanPHP.php">    
                        <button  type="submit" class="gobackbutton"><span class="glyphicon glyphicon-arrow-left" ></span> Go back</button>  
                    </form>   
                </div>
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





