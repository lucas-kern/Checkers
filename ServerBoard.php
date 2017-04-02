<?php
session_start();
class Game { 
    public $board;
    public $turn;
    public $names;
} 

if(!isset($_SESSION["check"])){
    $_SESSION["check"] = 0;
}
$arr = array_fill(0, 8, array_fill(0,8,0));
$player = 1;
$arrPl = array();

function endGame(){
	$pa;
	$sa;
	$boarda;
	getGame($pa,$sa,$boarda);
	
	$bCount = 0;
	$rCount = 0;
	for($x = 0; $x < 8; ++$x){
		for($y = 0; $y < 8; ++$y){
			if($boarda[$x][$y] == 1 || $boarda[$x][$y] == 3 ){
				$bCount += 1;
			}
			else if($boarda[$x][$y] == 2 || $boarda[$x][$y] == 4){
				$rCount += 1;
			}
		}
	}
	
	if($bCount == 0){
		return 2;
		
	}
	else if($rCount == 0){
		return 1;
	}
    return 0;
	
}

function getGame(&$p,&$s,&$board){
	$filename = "games.txt";
	$bar;
	if (file_exists($filename) && ($bar = file_get_contents($filename)) !== '') {
		$g = json_decode($bar);
		$p = $g->turn;
        $s = $g->names;
        $board = $g->board;
	}	
}

function getPlayers(&$a,&$b, &$c, &$text){
	$filename = "games.txt";
	$bar;
	if (file_exists($filename) && ($bar = file_get_contents($filename)) !== '') {
		$g = json_decode($bar);
		if(sizeof($g->names) == 2){
			$a = $g->names[0];
        	$b = $g->names[1];	
			$c = $g->turn;
			$text = ' vs. ';
		}
		else{
			$text = ' Waiting for Other Player ';
		}
	}	
}

function drawTable($rows,$cols,$arr){
	$pRed = '';
	$pBlack = '';
	$xTurn = '';
	$t = '';
	
	getPlayers($pBlack, $pRed, $xTurn, $t);
	
	
    $stringTa ="<div><p><strong style='color:black;'>".$pBlack."</strong>".$t."<strong style='color:red;'>".$pRed."</strong></p></div>";
	if(endGame() == 0){
		if($xTurn == 1){
			$stringTa .= "<div><p><strong style='color:black;'>It's Black's Turn</strong></p></div>";
		}
		else if($xTurn == 2){
			$stringTa .= "<div><p><strong style='color:red;'>It's Red's Turn</strong></p></div>";
		}
	}
	else if(endGame() == 1){
		$stringTa .= "<div><p><strong style='color:red;'>BLACK WINS!!</strong></p></div>";
	}
	else if(endGame() == 2){
		$stringTa .= "<div><p><strong style='color:red;'>RED WINS!!</strong></p></div>";
	}
	
	$stringTa .= "<table border='1'>";
	$c = 0;
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
            $king = 0;
            $piece = $arr[$tr][$td];
			if($arr[$tr][$td] == 1){
				$im = "<img src='BlackPiece.png' alt='Black' />";
			}
			else if($arr[$tr][$td] == 2){
				$im = "<img src='RedPiece.png' alt='Red' />";
			}
            else if($arr[$tr][$td] == 3){
				$im = "<img src='BlackKing.png' alt='Black' />";
                $king = 1;
                $piece = 1;
			}
            else if($arr[$tr][$td] == 4){
				$im = "<img src='RedKing.png' alt='Red' />";
                $king = 1;
                $piece = 2;
			}
			
            //echo "<td width= '50' height= '50' bgcolor='".$col."' align='center' name = '".$tr."' id= '".$td."'>".$im."</td>"; 
            $stringTa .="<td width= '50' height= '50' bgcolor='".$col."' align='center' data-king = '".$king."' data-piece ='".$piece."' data-x = '".$tr."' name ='".$c."' id= '".$td."'>".$im."</td>";
			
			++$c;
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
	if ($p == 1){
		$p = 2;
	}
	else if ($p == 2){
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
    if(!isset($_SESSION["number"])){
        $_SESSION["number"] = "".sizeof($arr);
    }
    echo $_SESSION["number"];
}
function movePiece(&$arr,$nextx,$nexty,$startx,$starty,$flag){
    if($flag ==0 && $arr[$startx][$starty] != 0){
        $arr[$nextx][$nexty] = $arr[$startx][$starty];
        $arr[$startx][$starty] = 0;
    }
    else if($arr[$startx][$starty] != 0){
        $arr[$nextx][$nexty] = $arr[$startx][$starty];
        $arr[$startx][$starty] = 0;
        $arr[intval($_POST["delX"])][intval($_POST["delY"])] = 0;
    }
    if($arr[$nextx][$nexty] == 1 && $nextx == 7){
            $arr[$nextx][$nexty] = 3;
    }
    else if($arr[$nextx][$nexty] == 2 && $nextx == 0){
            $arr[$nextx][$nexty] = 4;
    }
}
    getGame($player,$arrPl,$arr);
if($_POST["addPlayer"] == '0' && $_SESSION["check"] === 0){
    $_SESSION["check"] = 1;
    $arr = array_fill(0, 8, array_fill(0,8,0));
    initTable(8,8,$arr);
    changeTurn($player);
}
if($_POST["addPlayer"] == '1'){
    addPlayers($_POST["user"],$arrPl);
}
if($_POST["addPlayer"] == '3'){
    numPlayer($arrPl);
}
if($_POST["addPlayer"] == '5'){
	$_SESSION["check"] = 0;
	unlink('games.txt');
	session_destroy();
	return;
}
if($_POST["addPlayer"] == '66'){
    echo $player;
}

if($_POST["addPlayer"]=='100'){
    if(intval($_POST["nextX"]) != intval($_POST["startX"]) && intval($_POST["nextY"]) != intval($_POST["startY"])){
 movePiece($arr,intval($_POST["nextX"]),intval($_POST["nextY"]),intval($_POST["startX"]),intval($_POST["startY"]),intval($_POST["flag"]));
    drawTable(8,8,$arr);
    changeTurn($player);
    }
}
if($_POST["addPlayer"] == '0' && $_SESSION["check"] == 1){
    drawTable(8,8,$arr);
    //changeTurn($player);
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
//session_destroy();
?>