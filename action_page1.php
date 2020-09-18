<?php
$uname = $_POST['uname'];
//echo $uname;
$passwordwithout=$_POST['psw'];
$userhash = sha1($uname);
//echo $userhash;
$passhash=sha1( $passwordwithout );
$passhash=substr($passhash,0,30);
//echo sha1("admin' or '1'='1'#");
//echo sha1("or 1=1");
//echo $passhash;
include 'connect.php';
$i=0;
$j=0;
//sql attack checking
$file2=fopen("hashes2.txt", "r");
while(!feof($file2))
	{
		$word1=fgets($file2). "<br />";
    $word1=substr($word1,0,40);
    // echo $word1;"<br />";
		if ($userhash == $word1)
		{

      $j = $j+1;
            break;
		}
  }
    if ($j == 1)
    {
      echo '<script language="javascript">';
      echo 'alert("Possible sql attack")';
      echo '</script>';
			header("Location: sqldetect.html");

    }
		else
		{
			
		
fclose($file2);

//db checking
$sql  = "SELECT username FROM users WHERE username ='$uname' and passhash='$passhash'";
// echo "$sql";
$found=mysqli_query($connect,$sql) or die("Possible SQL injection attack.");
//username verification
if (mysqli_num_rows($found) != null )
{
     echo '<script language="javascript">';
      echo 'alert("Username Exists")';
      echo '</script>';
    $i=1;
} else {
  echo '<script language="javascript">';
   echo 'alert("Username Does not exist")';
   echo '</script>';
  //  header("Location: loginpage.php");
}

//password verification
$file=fopen('hashes1.txt', 'r');
while(!feof($file))
	{
		$word=fgets($file). "<br />";
    $word=substr($word,0,20);
    $passhash=substr($passhash,0,20); 
		if ($passhash == $word)
		{

      $i = $i+1;
            break;
		}
  }
    if ($i == 2)
    {
      echo '<script language="javascript">';
      echo 'alert("User successfully logged in")';
      echo '</script>';
			header("Location: success.html");


    }
		else
		{
			echo '<script language="javascript">';
			echo 'alert("Invalid password")';
      echo '</script>';
      // header("Location: loginpage.php");
		}
fclose($file);
}
?>
