<?php

class Game { 
    public $board;
    public $turn;
    public $names;
} 

$arr = array_fill(0, 8, array_fill(0,8,0));
$player = 1;
$arrPl = array();

function getTurn(&$p,&$s,&$board){
	$filename = "games.txt";
	$bar;
	if (file_exists($filename) && ($bar = file_get_contents($filename)) !== '') {
		$g = json_decode($bar);
		$p = $g->turn;
        $s = $g->names;
        $board = $g->board;
	}	
}

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
			}
			else if($tr%2 == 1 && $td%2 == 0){
				$col = "B7ADAD";
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
function initTable($rows,$cols,&$arr){
	for($tr=0;$tr<$rows;$tr++){
        for($td=0;$td<$cols;$td++){
			if($tr%2 == 0 && $td%2 == 1){
				if($tr < 3){
					$arr[$tr][$td] = 1;
				}
				else if($tr > 4){
					$arr[$tr][$td] = 2;
				}
			}
			else if($tr%2 == 1 && $td%2 == 0){
				if($tr < 3){
					$arr[$tr][$td] = 1;
				}
				else if($tr > 4){
					$arr[$tr][$td] = 2;
				}
			}
		}
	}
}

function changeTurn(&$p){
	if ($p === 1){
		$p = 2;
	}
	else if ($p === 2){
		$p = 1;
	}
	//echo $p;	
}
function addPlayers($name,&$arr){
    if(sizeof($arr) < 2){
        array_push($arr,$name);
        //echo sizeof($arr);
    }
}
function numPlayer($arr){
    echo "".sizeof($arr);
}
if($_POST["addPlayer"] == '0'){
getTurn($player,$arrPl,$arr);
initTable(8,8,$arr);
drawTable(8,8,$arr);
changeTurn($player);
}
if($_POST["addPlayer"] == '1'){
    getTurn($player,$arrPl,$arr);
    addPlayers($_POST["user"],$arrPl);
}
if($_POST["addPlayer"] == '3'){
    getTurn($player,$arrPl,$arr);
    numPlayer($arrPl);
}

$filename = 'games.txt';
$g = new Game();
if (!file_exists($filename) || ($bar = file_get_contents($filename))=== '') {
	$g->board = $arr;
	$g->turn = $player;
    $g->names = $arrPl;
}
else{
    $g = json_decode($bar);
	$g->board = $arr;
	$g->turn = $player;
    $g->names = $arrPl;
}

$str = json_encode($g);
file_put_contents($filename, $str);

?>