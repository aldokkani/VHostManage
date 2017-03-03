<?php
include 'head.html';
#session_start();
#if (isset($_SESSION['groupname'] == 'serverAdmin'))
#{
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
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <form class="" action="index.php" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <!-- <tr>
                        <th colspan="3" class="text-center">Virtual Hosts</th>
                    </tr> -->
                    <tr>
                        <th>#</th><th>ServerName</th><th>Delete</th>
                    </tr>

                <?php
                $count = 0;
                foreach ($files as $file) {
                ?>
                <tr>
                    <td><?= ++$count?></td>
                    <td><a href="edit.php?f=<?=$file?>"><?=$file?></a></td>
                    <td><input type="checkbox" name="<?=$file?>"></td>
                </tr>
                <?php
                }
                ?>
                </table>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="new.php"><span class="glyphicon glyphicon-plus"></span> Create New VHost</a>
                <input class="btn btn-danger pull-right" type="submit" name="del" value="Delete">
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" name="apache" value="Restart Apache">
                <a class="btn btn-success" href="mylogs.php">Show Logs</a>
            </div>
        </form>
    </div>
</body>
<?php
// } else {
//
// }
?>
