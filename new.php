<?php
session_start();
$_SESSION['username']='nahla';
$_SESSION['groupname']='serveradmin';
$_SESSION['projectNum']=2;
if (isset($_SESSION['username']) && isset($_SESSION['groupname']) && isset($_SESSION['projectNum']))
{
//----------------------------------------
include_once "LogsFunctions.php";
$message="";
$infoType="";
//-----------------------------------------
if (! isset($_POST['ServerName'])) {
?>
<body>
  <form action="new.php" method="post">
    <label for="ServerName">Server Name</label>
    <input type="text" name="ServerName" value="" required>
    <label for="ServerAdmin">Server Admin</label>
    <input type="text" name="ServerAdmin" value="" required>
    <label for="DocumentRoot">Document Root</label>
    <input type="text" name="DocumentRoot" value="" required>
    <label for="ErrorLog">ErrorLog</label>
    <input type="text" name="ErrorLog" value="" required>
    <label for="CustomLog">CustomLog</label>
    <input type="text" name="CustomLog" value="" required>
    <label for="php">Enable PHP Script</label>
    <input type="checkbox" name="php">
    <input type="submit" value="Save">
    <input type="reset">
  </form>
</body>
<?php
} 
else 
{
  $php_flag = extract($_POST);
    

      $virtualHostFile = fopen("/etc/apache2/sites-enabled/".$ServerName.'.conf', 'w');
    if ( $virtualHostFile)
    {
      $part1 = "<VirtualHost *:80\>\nServerName $ServerName\nServerAdmin $ServerAdmin\nDocumentRoot $DocumentRoot\nErrorLog $ErrorLog\nCustomLog $CustomLog combined\nphp_admin_flag engine ";
      $part2 = ($php_flag == 5) ? "off\n</VirtualHost>\n" : "on\n</VirtualHost>\n" ;  
       fwrite($virtualHostFile, $part1.$part2);
        fclose($virtualHostFile);
        $message= "VirtualHost ".$ServerName." created successfully";
        $infoType="Success";
        infolog($message,$infoType);
   
    }
    else
    {
       $message="VirtualHost ".$ServerName.'.conf'." couldn't be created"; 
        errlog($message);
    }
        header('location: index.php');   
    }
  
}


?>
