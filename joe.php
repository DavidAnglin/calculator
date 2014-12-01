<html>
<head></head>
<body>

<?php
$conn = mysql_connect('localhost','root');
	if(! $conn )
	{
		die('Could not connect: ' . mysql_error());
	}
mysql_select_db('joe');
if(isset($_POST['submit']))
{
	$num2 = (int)$_POST['number']; 
	$function = $_POST['operation'];
}
else
{
	echo "No inputs yet!" . '<br />';
}

if(empty($_POST['number']))
{
	$query =("SELECT problem FROM problems
	ORDER BY id DESC LIMIT 1");
	$num1 = mysql_query((int)$query);
	echo (int)$num1;
}
else if (isset($_POST['number']))
{	
	$query = mysql_query("SELECT problem FROM problems
	ORDER BY id DESC LIMIT 1");
	$num1 = mysql_query((int)$query);
	
	
	if ($function == "+")
	{
		$total = $num1 + $num2; 
	}
	else if ($function == "-")
	{
		$total = $num1 - $num2;
	}
	else if ($function == "*")
	{
		$total = $num1 * $num2;
	}
	else if($function == "/")
	{
		$total = $num1 / $num2;
	}	
	echo $total . '<br />';
	
}	
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
}
else if (isset($_POST['submit']))
{
	if (empty($_POST['number']))
	{			
		$query =("SELECT problem FROM problems
		ORDER BY id DESC LIMIT 1");
		$num1 = mysql_query((int)$query);	
		$num2 = 0;
		$problem = $total;	
		$query =("INSERT INTO problems(num1,operator,num2,problem) VALUES
		($num1,'$function',$num2,$problem)");
		$result = mysql_query($query);		
		if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
	}
	else 
	{		
		$problem = $total;
		$query =("SELECT problem FROM problems
		ORDER BY id DESC LIMIT 1");
		$num1 = mysql_query((int)$query);		
		$query =("INSERT INTO problems (num1,operator,num2,problem) VALUES 
		($num1,'$function',$num2,$problem)");
		$result = mysql_query($query,$conn) or die ('Error in query: $query, ' . mysql_error());
			if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
			echo "Entered data successfully" . '<br />';
		$sql = ("SELECT * FROM problems ORDER BY id DESC");
		$result1 = mysql_query($sql,$conn) or die ('Error in query: $query1, ' . mysql_error());	
		
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