<?php

//$array = array(
//    array(0, 1, 2),
//    array(3, 4, 5),
//);

$arr = array_fill(0, 8, array_fill(0,8,0));

//echo $arr[7][7];

function drawTable($rows,$cols,$arr){
    $stringTa ="<table border='1'>";
//echo "<table border='1'>"; 
for($tr=0;$tr<$rows;$tr++){
    if ($cols >= 0) {
    //echo "<tr>"; 
        $stringTa .="<tr>";
        for($td=0;$td<$cols;$td++){
			$col = "";
			if($tr%2 == 0 && $td%2 == 1){
				$col = "B7ADAD";
				if($tr < 3){
					$arr[$tr][$td] = 1;
				}
				else if($tr > 4){
					$arr[$tr][$td] = 2;
				}
			}
			else if($tr%2 == 1 && $td%2 == 0){
				$col = "B7ADAD";
				if($tr < 3){
					$arr[$tr][$td] = 1;
				}
				else if($tr > 4){
					$arr[$tr][$td] = 2;
				}
			}
			else{
				$col = "F55252";
			}
			
			$im = "";
			if($arr[$tr][$td] == 1){
				$im = "<img src='BlackPiece.png' alt='Black' />";
			}
			else if($arr[$tr][$td] == 2){
				$im = "<img src='RedPiece.png' alt='Red' />";
			}
			
            //echo "<td width= '50' height= '50' bgcolor='".$col."' align='center' name = '".$tr."' id= '".$td."'>".$im."</td>"; 
            $stringTa .="<td width= '50' height= '50' bgcolor='".$col."' align='center' name = '".$tr."' id= '".$td."'>".$im."</td>";;
        } 
//    echo "</tr>"; 
         $stringTa .="</tr>";
    } 
}

//echo "</table>";
     $stringTa .="</table>";
    echo $stringTa;
}
drawTable(8,8,$arr);
?>