<?php

// Hiding notices:
//error_reporting(E_ALL^E_NOTICE);

// Including file for the DB connection:
define("INCLUDE_CHECK",1);
require 'connect.php';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Titel</title>

<link rel="stylesheet" type="text/css" href="demo.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="script.js"></script>

</head>

<body>

<div id="main">
	<p id="orig"><a href="#" target="_blank">Main page&raquo;</a></p>
	<h1>Title</h1>
    <h2>Introtext</h2>
<em>Explanation</em>

	<hr />

	
<?php
// If we are not on the data.php?results page:
if(!array_key_exists('results',$_GET))
{
	echo '<ul class="sort">';

	// Showing the submissions by random
	$res = mysql_query("SELECT * FROM sort_objects ORDER BY RAND()");

	while($row=mysql_fetch_assoc($res))
	{?>
    	<li id="li<?php echo $row['id']?>">
		<div class="tut">
            <div class="tut-img">
                <img src="<?php echo $row['img']?>" width="100" height="100" alt="<?php echo $row['title']?>" />
                <div class="drag-label"></div>
            </div>
            
            <div class="tut-title">
            	<a class="single_image" href="<?php echo $row['url']?>"><?php echo $row['title']?></a>
            </div>
            
            <div class="tut-description"><?php echo $row['description']?></div>
            <div class="clear"></div>
        </div>
        </li>
	<?php }	?>
    
   </ul>
  
<em>Emaildescription</em>
	<div class="button-holder">
		<!-- The form below is not directly available to the user -->
<form action="?results" id="sform" method="post">
<input name="sortdata" id="sortdata" type="hidden" value="" />
<input name="emailadress" id="emailadress" type="text" value="" />@emaildomain.example
</form>
    	<?php if(!$voted):?><a href="" id="submitPoll" class="button">Submittext<span></span></a><?php endif;?>
        <a href="?results" class="button">Viewtext<span></span></a>
    </div>
  
<?php
}
else require "results.php";
// The above require saves us from having to style another separate page

?>
    
	<div class="clear"></div>
    
  	<div class="container tutorial-info">
    Infotext</div>
</div>
</body>
</html>
