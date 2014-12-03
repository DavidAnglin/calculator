<html>
<head></head>
<body>

<?php
$conn = mysql_connect('localhost','root');
	if(!$conn)
	{
		die('Could not connect: ' . mysql_error());
	}
mysql_select_db('joe');
$query2 =("SELECT problem FROM problems
	ORDER BY id DESC LIMIT 1");
$result2 = mysql_query($query2) or die ('Error in query: $query2, ' . mysql_error());
$num = mysql_fetch_row($result2);
$num1 = (int)$num[0];

if(isset($_POST['submit']))
{
	$num2 = $_POST['number']; 
	$function = $_POST['operation'];
	$total = $num1 . $function . $num2;
}
if(empty($_POST['number']))
{		
	if (isset($_POST['clear']))
	{
		$num1 = 0;
	}
	$num2 = 0;	
	echo $num1;
}	
else if (isset($_POST['number']))
{	
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
	echo $total;
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
<input type="submit" name="clear"  value="Clear">
</form> 

<?php
if (isset($_POST['clear']))
{
	$sql = "TRUNCATE TABLE problems";
	$clear = mysql_query($sql) or die ('Error in query: $query1, ' . mysql_error());
	if ($clear === TRUE) 
	{
		echo "Previous problems deleted successfully";		
	} 	
	else 
	{
		echo "Error deleting problems: ";
	}
}
if (!isset($_POST['submit']))	
{
	$query1 = ("SELECT * FROM problems ORDER BY id DESC");
	$result1 = mysql_query($query1,$conn) or die ('Error in query: $query1, ' . mysql_error());	
		
	if ($result1 || mysql_num_rows($result1) > 0)
	{
		while ($row = mysql_fetch_array($result1))
		{
			echo $row['num1'] . $row['operator'] . $row['num2'] . "=" . $row['problem'] . '<br />';
		}
	}	
}
else if (isset($_POST['submit']))
{
	if (empty($_POST['number']))
	{	
		$num2 = 0;
		$total = $num1 . $function . $num2;
		$query =("INSERT INTO problems(num1,operator,num2,problem) VALUES
		($num1,'$function',$num2,$total)");
		$result = mysql_query($query) or die ('Error in query: $query, ' . mysql_error());;		
		if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
		$query1 = ("SELECT * FROM problems ORDER BY id DESC");
		$result1 = mysql_query($query1,$conn) or die ('Error in query: $query1, ' . mysql_error());	
		
		if ($result1 || mysql_num_rows($result1) > 0)
		{
			while ($row = mysql_fetch_array($result1))
			{
				echo $row['num1'] . $row['operator'] . $row['num2'] . "=" . $row['problem'] . '<br />';
			}
		}
	}
	else if (!isset($_POST['number']))
	{	
		$query =("INSERT INTO problems(num1,operator,num2,problem) VALUES
		($num1,'$function',$num2,$total)");
		$result = mysql_query($query) or die ('Error in query: $query, ' . mysql_error());;		
		if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
	}	
	else
	{		
		$query =("INSERT INTO problems (num1,operator,num2,problem) VALUES 
		($num1,'$function',$num2,$total)");
		$result = mysql_query($query) or die ('Error in query: $query, ' . mysql_error());
			if(!$result)
			{
				die('Could not enter data: ' . mysql_error());
			}
			echo "Entered data successfully:" . '<br />' . '<br />';
			
		$query1 = ("SELECT * FROM problems ORDER BY id DESC");
		$result1 = mysql_query($query1,$conn) or die ('Error in query: $query1, ' . mysql_error());	
		
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