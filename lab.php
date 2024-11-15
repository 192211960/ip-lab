<?php
$username=$_POST["username"];
$password=$_POST["password"];
$confirmpassword=$_POST["confirmpassword"];
$email=$_POST["email"];
if(!empty($username)&&!empty($password)&&!empty($confirmpassword)&&!empty($email))
{
  if($password===$confirmpassword)
  {
   $host="localhost";
   $dbusername="root";
   $dbpassword="";
   $dbname="shasi";
   
   $conn=new mysqli($host,$dbusername,$dbpassword,$dbname);
  
   if($conn->connect_error)
   {
    die("connection failed" . $conn->connect_error);
   }
   else
   {
   $hashed_password=password_hash($password,PASSWORD_DEFAULT);
   
   $stmt=$conn->prepare("INSERT INTO vote(username,password,email) VALUES(?,?,?)");
   $stmt->bind_param("sss",$username,$hashed_password,$email);
   
   if($stmt->execute())
    {
     echo "inserted successfully";
     header("refresh:3; url=home.html");
    }
    else
    {
     echo "error" . $stmt->error;
    }
     $stmt->close();
     $conn->close();
   }
  }
  else
  {
   echo "password not match";
  }
}
else
{
echo "all must fields";
}
?>
