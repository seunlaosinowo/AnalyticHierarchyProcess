<?php


/* This is a core Analytic Huierarchy process code, that can be resued once understood


AHP is a decision support system algorithim that performs pair wise comparison on user selected criteria and alternative attributes

users data are collected and run through a decision matrix.
*/
$conn=mysqli_connect('localhost','root','tytanium11','project2') or die("Database Error");
$results2 = "SELECT * FROM alternatives ";

$results2result  = mysqli_query($conn,$results2)or die(mysqli_error());
  $num_rowresults2result  = mysqli_num_rows($results2result);
  


    function CriteriaRanking($A){
        $CriteriaMatrix=array();
        
        for($i=0;$i<6;$i++){
            for($j=0;$j<6;$j++){
                if($i==$j){
                    $CriteriaMatrix[$i][$j]=1;
                }
                else if($i!=$j){
                    $CriteriaMatrix[$i][$j]=$A;
                    $CriteriaMatrix[$j][$i]=1/$A;
                    
                }
                
            }
        }
        
        for($i=0;$i<6;$i++){
            for($j=0;$j<6;$j++){
                 
            }
          
        }      
 
        $sum=array();
        for($i=0;$i<6;$i++){
            for($j=0;$j<6;$j++){
              $sum[$i] += $CriteriaMatrix[$j][$i];
            }
           
        }
       
       
        $ssum=array(); $weights=array(); $fsum=array();
         for($i=0;$i<6;$i++){
            for($j=0;$j<6;$j++){
           $CriteriaMatrix[$i][$j] = $CriteriaMatrix[$i][$j]/$sum[$j];
             
            }
         
        }
         
         for($i=0;$i<6;$i++){
            for($j=0;$j<6;$j++){
            $ssum[$i] +=  $CriteriaMatrix[$i][$j];

            }
             
             $fsum[$i] = $ssum[$i]/6;
             
             $weights[$i] = $fsum[$i]*100;
              
        }
        
         return $weights;
    
        
    }
     
    function getRanking($n, $b)
    {
         $a=($b-1);
        $matrix=array();
        
        for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
                if($i==$j){
                    $matrix[$i][$j]=1;
                }
                else if($i==$a){
                    $matrix[$i][$j]=9;
                }
                else if($j==$a){
                    $matrix[$i][$j]=0.111;
                }
                else
                    $matrix[$i][$j]=1;
            }
        }
        
        for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
                 
            }
         
        }      
        
        $sum=array();
        for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
              $sum[$i] +=  $matrix[$j][$i];
            }
            
        }
       
         
        $ssum=array(); $weights=array();$fsum=array();
         for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
           $matrix[$i][$j] = $matrix[$i][$j]/$sum[$j];
            

            }
        
        }
         
         for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
            $ssum[$i] +=  $matrix[$i][$j];

            }
             
             $fsum[$i] = $ssum[$i]/$n;
              
             $weights[$i] = $fsum[$i]*100;
             
        }
        
         return $weights;
    
    }
    
     
       function getSubCriteriaWeights($subCriteria, $valueCriteria){
           $sub_criteria_weights=array();
           for($i=0;$i<count($subCriteria);$i++){
               $sub_criteria_weights[$i]=($subCriteria[$i]/100)*$valueCriteria;
               
           }
           
           return $sub_criteria_weights;
       }


    


if(isset($_POST['SUB'])){
        $Criteria1 = $_POST['Criteria1'];
        $Criteria2 = $_POST['Criteria2'];
        $Criteria3 = $_POST['Criteria3'];
        
        $Criteria4 = $_POST['Criteria4'];
        $Criteria5 = $_POST['Criteria5'];
    
        $Criteria6 = $_POST['Criteria6'];
        

        }
    
    $A=1;
 
    //This will show the selected importance of each criteria comparison
    $criteria_weights=array();
    $location_sub_criteria=array();
        
    $criteria_weights=CriteriaRanking($A);
//echo "This is the weight of each Criteria comparison i.e f1 to f2, f1 to f3";echo "<br>";
     
$F1_sub_criteria = getRanking(3,$Criteria1);
 
        
$F2_sub_criteria = getRanking(3,$Criteria2);
  
        
$F3_sub_criteria = getRanking(3,$Criteria3);
 
        
$F4_sub_criteria = getRanking(2,$Criteria4);
 
        
$F5_sub_criteria = getRanking(3,$Criteria5);
 
        
$F6_sub_criteria = getRanking(3,$theuserF6);
 

        
//echo "this is the weight of each sub criteria i.e reenfforced to non reenforced ";        
   
$F1_sub_criteria_weights=getSubCriteriaWeights($F1_sub_criteria,$criteria_weights[0]);
//it contains the weight of each subcriteria with respect to criteria 1
  
$F2_sub_criteria_weights=getSubCriteriaWeights($F2_sub_criteria,$criteria_weights[1]);
//it contains the weight of each subcriteria with respect to criteria 2
        
$F3_sub_criteria_weights=getSubCriteriaWeights($F3_sub_criteria,$criteria_weights[2]);
//it contains the weight of each subcriteria with respect to criteria 3
        
$F4_sub_criteria_weights=getSubCriteriaWeights($F4_sub_criteria,$criteria_weights[3]);
//it contains the weight of each subcriteria with respect to criteria 4
        
$F5_sub_criteria_weights=getSubCriteriaWeights($F5_sub_criteria,$criteria_weights[4]);
//it contains the weight of each subcriteria with respect to criteria 5
        
$F6_sub_criteria_weights=getSubCriteriaWeights($F6_sub_criteria,$criteria_weights[5]);
//it contains the weight of each subcriteria with respect to criteria 6
 
        
// next generate the weight of each alternative based on sub criteria summation
  $arrayofsetids = array();
  $theweightofeachalternative = array();
  $arr1 = array();
  $array = array();
  while($rowqas = mysqli_fetch_array($results2result)){
             
            array_push($arrayofsetids,$rowqas['settid']);
            
            
            $f1 = $rowqas['F1'] - 1; 
            $f2 = $rowqas['F2'] -1; 
            $f3 = $rowqas['F3'] -1; 
            $f4 = $rowqas['F4'] -1; 
            $f5 = $rowqas['F5'] -1; 
            $f6 = $rowqas['F6'] -1; 
            
            

    $weightoftheparticularrow = $F1_sub_criteria_weights[$f1] + $F2_sub_criteria_weights[$f2] + $F3_sub_criteria_weights[$f3] + $F4_sub_criteria_weights[$f4] + $F5_sub_criteria_weights[$f5] + $F6_sub_criteria_weights[$f6];
    //echo "it contains the weight of alternative per time

    array_push($theweightofeachalternative,$weightoftheparticularrow);

    $arr1 = array($rowqas['settid'] => $weightoftheparticularrow);  
    $array = $array + $arr1;
        }
    //print_r($arrayofsetids);echo " THE SETS IN THE QUERY ID <br> <br>";   
    //print_r($theweightofeachalternative);echo " THE WEIGHT OF SETS IN THE QUERY ID <br>"; 

        $ddd=array();

        arsort($array); // this prints alternatives from the most weighted alternative to least weighted.
    
?>