<?php
	include ('../lib/configure.php');
	session_start();
	if(isset($_SESSION['login_user']))
	{
		if ($_SESSION['login_user']=="doctor") 
		{
			header("location: ../doctor_home.php");
		}
	}
	else 
	{
		header("location: ../index.php");
	}
	
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		//echo $q;
		$sql="SELECT * from patient where Patient_Id = '{$id}'";
		$query=mysqli_query($conn,$sql);
		$text="";
		if(mysqli_num_rows($query)==1) 
		{
			$row = mysqli_fetch_array($query);
			$text="1!+!" . $row['Name'] . "!+!" . $row['Dependent'] . "!+!" . $row['Sex'] . "!+!" . $row['Age'] . "!+!" . $row['Ph.No'] . "!+!" . $row['Alt.Ph.No'] . "!+!" . $row['DOB'] . "!+!" . $row['PermanentAddress'] . "!+!" . $row['LocalAddress'];
		}
		else if(mysqli_num_rows($query)>1)
		{
			$row = mysqli_fetch_array($query);
			$Name = $row['Name'];
			$staff="";
			if($row['Dependent']=="") {$staff="2!+!" . $Name . "!+!" .  $row['Sex'] . "!+!" . $row['Age'] . "!+!" . $row['Ph.No'] . "!+!" . $row['Alt.Ph.No'] . "!+!" . $row['DOB'] . "!+!" . $row['PermanentAddress'] . "!+!" . $row['LocalAddress'];}
			else {$text="!+!" . $row['Dependent'];}
			while($row = mysqli_fetch_array($query)) 
			{
				if($row['Dependent']=="") {$staff="2!+!" . $Name . "!+!" .  $row['Sex'] . "!+!" . $row['Age'] . "!+!" . $row['Ph.No'] . "!+!" . $row['Alt.Ph.No'] . "!+!" . $row['DOB'] . "!+!" . $row['PermanentAddress'] . "!+!" . $row['LocalAddress'];}
				else {$text = $text . "!+!" . $row['Dependent'];}
				if($row['Name']!=$Name) 
				{
					$Name="";
					break;
				}
			}
			if($Name=="") 
			{
				$text="";
			}
			else { $text = $staff . $text;}
		}
		else $text="";
		echo $text;
	}
	else if(isset($_GET['name']))
	 {
		$name=$_GET['name'];
		$sql="SELECT * from patient where Name LIKE '%{$name}%' ";
		$query=mysqli_query($conn,$sql);
		$text="";
		$count=mysqli_num_rows($query);
		if($count==1) {
			$row = mysqli_fetch_array($query);
			$text="1!+!" . $row['Patient_Id'] . "!+!" . $row['Dependent'] . "!+!" . $row['Sex'] . "!+!" . $row['Age'] . "!+!" . $row['Ph.No'] . "!+!" . $row['Alt.Ph.No'] . "!+!" . $row['DOB'] . "!+!" . $row['PermanentAddress'] . "!+!" . $row['LocalAddress'];
		}
		else {									
			$text="2!+!";
			while($row = mysqli_fetch_array($query)) {
				$text = $text . "!+!" . $row['Name'];
			}
		}
		echo $text;
	}
?>

