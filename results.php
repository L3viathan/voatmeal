<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');


// If the poll has been submitted:
if($_POST['sortdata'])
{
	//Send verification mail
	$recipient=$_POST['emailadress'] . '@emaildomain.com';
	$code=md5(rand());
	mysql_query("INSERT INTO `sort_votemail`(`adress`, `verified`, `vote`, `code`)  VALUES ('" . mysql_real_escape_string($_POST['emailadress']) . "',0,'" . mysql_real_escape_string($_POST['sortdata']) . "','" . $code . "')");
	mail($recipient,"Emailsubject","Emailtext domain/index.php?results&c=" . $code,"From: sender");
	print("<span class='notice'>Emailsenttext</span>");
}
elseif($_GET['c'] !=""){
	$code = mysql_real_escape_string($_GET['c']);
	$res = mysql_query("SELECT * FROM `sort_votemail` WHERE code = '" . $code . "' AND `verified` = 0");
	
	if($row = mysql_fetch_assoc($res)){ //should only be executed once, previously: while
		// The data arrives as a comma-separated string,
		// so we extract each post ids:
		$data=explode(',',str_replace('li','',$row['vote']));
	
		// Getting the number of objects
		list($tot_objects) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM sort_objects"));
		
		if(count($data)!=$tot_objects) die("Wrong data!");
	
		foreach($data as $k=>$v)
		{
			// Building the sql query:
			$str[]='('.(int)$v.','.($tot_objects-$k).')';
		}
	
		$str = 'VALUES'.join(',',$str);
		//enter votes
		mysql_query('INSERT INTO `sort_objects` (id,votes) '.$str.' ON DUPLICATE KEY UPDATE votes = votes+VALUES(votes)');
		//and make it final:
		mysql_query("UPDATE `sort_votemail` SET `verified`=1 WHERE `code`='" . $code . "'");
		print("<span class='notice'>Votecounted</span>");
	}
	else {
		print("<span class='error'>Alreadyvotederror</span>");
	}
}

//	Selecting the sample tutorials and ordering 
//	them by the votes each of them received:
$res = mysql_query("SELECT * FROM sort_objects ORDER BY votes DESC");

$maxVote=0;
$bars=array();

while($row=mysql_fetch_assoc($res))
{
	$bars[]=$row;
	
	// Storing the max vote, so we can scale the bars of the chart:
	if($row['votes']>$maxVote) $maxVote = $row['votes'];
}

$barstr='';

// The colors of the bars:
$colors=array('#ff9900','#66cc00','#3399cc','#dd0000','#800080','#00AA88','#8888AA','#ff9900','#66cc00','#3399cc','#dd0000','#800080','#00AA88','#ff9900');

foreach($bars as $k=>$v)
{
	// Buildling the bar string:
	$barstr.='
		<div class="bar" style="width:'.max((int)(($v['votes']/$maxVote)*450),100).'px;background:'.$colors[$k].'">
			<a href="'.$v['url'].'" title="'.$v['title'].'">'.$v['short'].'</a>	
		</div>';
}

// The total number of votes cast in the poll:
list($totVotes) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM sort_votemail WHERE `verified`=1"));

?>


<div class="chart">

<?php echo $barstr?>

</div>

<a href="index.php" class="button">Goback<span></span></a>

<div class="tot-votes"><?php echo $totVotes?> votes</div>
