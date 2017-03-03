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

  $content = file("/etc/apache2/sites-enabled/".$_GET['f'].'.conf');
  $virtualHostInfo = array();
  if ($content) {
    for ($i=1; $i < 6 ; $i++) {
      # explode to extract the data from virtual host file to an assoc array as pairs of keys and values.
      $arr = explode(' ',$content[$i]);
      # ltrim the key to remove the whitespace in virtual host file.
      $virtualHostInfo = array_merge($virtualHostInfo, array(ltrim($arr[0]) => $arr[1]));
    }
    $arr = explode(' ',$content[6]);
    $virtualHostInfo = array_merge($virtualHostInfo, array(ltrim($arr[0]) => $arr[2]));
  }
    else 
  {
    echo "not opend\n";
  }
//print_r($virtualHostInfo);
?>
<body>
  <form action="edit.php" method="post">
    <!-- saving the oldfile name in case it was changed so it gets deleted first -->
    <input type="hidden" name="oldfile" value="/etc/apache2/sites-enabled/<?=$_GET['f']?>.conf">
    <label for="ServerName">Server Name</label>
    <input type="text" name="ServerName" value="<?= $virtualHostInfo['ServerName'] ?>">
    <label for="ServerAdmin">Server Admin</label>
    <input type="text" name="ServerAdmin" value="<?= $virtualHostInfo['ServerAdmin'] ?>">
    <label for="DocumentRoot">Document Root</label>
    <input type="text" name="DocumentRoot" value="<?= $virtualHostInfo['DocumentRoot'] ?>">
    <label for="ErrorLog">ErrorLog</label>
    <input type="text" name="ErrorLog" value="<?= $virtualHostInfo['ErrorLog'] ?>">
    <label for="CustomLog">CustomLog</label>
    <input type="text" name="CustomLog" value="<?= $virtualHostInfo['CustomLog'] ?>">
    <label for="php">Enable PHP Script</label>
    <?php
      if (trim($virtualHostInfo['php_admin_flag']) == 'on') {
        echo "<input type='checkbox' name='php' checked>";
      } else {
        echo "<input type='checkbox' name='php'>";
      }
    ?>
    <input type="submit" value="Save">
    <input type="reset">
  </form>
</body>
<?php
}
    else 
{
  unlink($_POST['oldfile']);
  $php_flag = extract($_POST);
  $virtualHostFile = fopen("/etc/apache2/sites-enabled/".$ServerName.'.conf', 'w');
    if ( $virtualHostFile)
    {
      $part1 = "<VirtualHost *:80>\nServerName $ServerName\nServerAdmin $ServerAdmin\nDocumentRoot $DocumentRoot\nErrorLog $ErrorLog\nCustomLog $CustomLog combined\nphp_admin_flag engine ";
      $part2 = ($php_flag == 5) ? "off\n</VirtualHost>\n" : "on\n</VirtualHost>\n" ;
      fwrite($virtualHostFile, $part1.$part2);
      fclose($virtualHostFile);
         $message= "VirtualHost ".$ServerName." edited successfully";
        $infoType="Success";
        infolog($message,$infoType);
    }
    else
    {
         $message="VirtualHost ".$ServerName.'.conf'." couldn't be edited"; 
        errlog($message);
    }
  header('location: index.php');
}
}
?>
