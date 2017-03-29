<?php

//$array = array(
//    array(0, 1, 2),
//    array(3, 4, 5),
//);
$arr = array_fill(0, 8, array_fill(0,8,0));
//echo $arr[7][7];



function drawTable($rows,$cols,$arr){
echo "<table border='1'>"; 
for($tr=0;$tr<$rows;$tr++){
    if ($cols > 0) {
    echo "<tr>"; 
        for($td=0;$td<$cols;$td++){ 
               echo "<td align='center' name = '".$tr."' id=".$td.">".$arr[$tr][$td]."</td>"; 
        } 
    echo "</tr>"; 
    } 
}

echo "</table>";
}
drawTable(8,8,$arr);
?>