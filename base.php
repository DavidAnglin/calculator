<html>
<head></head>
<body>

<?php
if (!isset($total))
{
	$total = 0;
}
if(isset($_POST['submit']))
{
$num2 = (int) $_POST['number']; 
$function = $_POST['operation'];
}
else
{
	echo "No inputs yet!" . '<br />';
}

if(empty($_POST['number']))
{
	$total = 0;
	echo $total;
}
else if (isset($_POST['number']))
{	
	$total = $_COOKIE['total'];
	
	if ($function == "+")
	{
		$total += $num2; 
	}
	else if ($function == "-")
	{
		$total -= $num2;
	}
	else if ($function == "*")
	{
		$total *= $num2;
	}
	else if($function == "/")
	{
		$total /= $num2;
	}	
	echo $total . '<br />';
	
}	
setcookie('total', $total);
?>
<!-- form inputs -->
<form action="<?=$_SERVER['PHP_SELF'] ?>" method="post">
	<select name="operation" id="operation">
		<option value="+">+</option>
		<option value="-">-</option>
		<option value="*">*</option>
		<option value="/">/</option>
	</select>

<input type="number" name="number" placeholder="number" size="3">
<input type="submit" name="submit" value="Equals">
</form> 

<?php
if (!isset($_POST['submit']))	
{
	echo "No problems yet";
	$total = 0;
}
else if (isset($_POST['submit']))
{
	if (empty($_POST['number']))
	{	
		$conn = mysql_connect('localhost','root');
		if(! $conn )
		{
			die('Could not connect: ' . mysql_error());
		}
		$tot = 0;
		$num2 = 0;
		$problem = $total;
		$answer = $total . $function . $num2 . "=" . $total;		
		$query =("INSERT INTO problems(num1,operator,num2,problem) VALUES
		($tot,'$function',$num2,'$problem')");
		$joe = mysql_select_db('joe');
		$result = mysql_query($query);		
		if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
	}
	else 
	{		
		$answer = $_COOKIE['total'] . $function . $num2 . "=" . $total;
		$problem = $total;
		$tot = $_COOKIE['total'];
		$conn = mysql_connect('localhost','root');
		if(! $conn )
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('joe');
		$query =("INSERT INTO problems (num1,operator,num2,problem) VALUES 
		($tot,'$function',$num2,'$problem')");
		$result = mysql_query($query,$conn) or die ('Error in query: $query, ' . mysql_error());
			if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
			echo "Entered data successfully" . '<br />';
		$sql = ("SELECT * FROM problems ORDER BY id DESC");
		$result1 = mysql_query($sql,$conn) or die ('Error in query: $query1, ' . mysql_error());	
		if($result1 === FALSE) 
		{
			die (mysql_error()); 
		}
			if ($result1 || mysql_num_rows($result1) > 0)
			{
				while ($row = mysql_fetch_array($result1))
				{
				echo $row['num1'] . $row['operator'] . $row['num2'] . "=" . $row['problem'] . '<br />';
				}
			}
	}
	mysql_close($conn);	
}
?>
</body>
</html>