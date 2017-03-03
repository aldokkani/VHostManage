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
$files = `ls /etc/apache2/sites-enabled/`;
$files = explode(".conf\n",$files);
# Line 11 removes empty element in at the end of the $files array.
unset($files[count($files)-1]);
//print_r ($files);
#print_r($_POST);
if (isset($_POST['apache'])) 
{
echo `sudo /etc/init.d/apache2 graceful`;
    
$message="Apache Server restarted successfully";
$infoType="Success";
infolog($message,$infoType);
    
unset($_POST['apache']);
}
if (isset($_POST['del']) )
{
  foreach ($files as $file) 
  {
    if (trim($_POST[$file]) == 'on') 
    {
    
        if (unlink("/etc/apache2/sites-enabled/".$file.'.conf'))
        {
        $message= $file.'.conf'." deleted successfully";
        $infoType="Success";
        infolog($message,$infoType);
        }
        else
        {
        $message= $file.'.conf'." couldn't be deleted";
        errlog($message);
        }
        
    }
     
  }
  unset($_POST['del']);
  header('location: index.php');
}
?>
<form class="" action="index.php" method="post">
  <table>
    <th>Virtual Hosts</th>
<?php
foreach ($files as $file) {
?>
    <tr>
      <td><a href="edit.php?f=<?=$file?>"><?=$file?></a></td>
      <td><input type="checkbox" name="<?=$file?>"></td>
    </tr>

<?php
}
?>
  </table>
  <input type="submit" name="del" value="Delete">
  <input type="submit" name="apache" value="Restart Apache">
</form>
<a href="new.php">Create New</a>
<a href="mylogs.php">Show Logs</a>
<?php
}
else
{
    session_destroy();
}
?>