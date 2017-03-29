<?php



function drawTable($rows,$cols){
echo "<table border='1'>"; 
for($tr=0;$tr<$rows;$tr++){
    if ($cols >= 0) {
    echo "<tr>"; 
        echo "<td align='center'></td>";
        for($td=0;$td<$cols;$td++){ 
             $arr = $result->fetch_assoc();
               echo "<td align='center' name = 'book' id='".$arr["BookId"]."'>".$arr["BookTitle"]."</td>"; 
        } 
    echo "</tr>"; 
    } 
}

echo "</table>";
}

?>