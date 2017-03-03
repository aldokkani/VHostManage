<?php
include 'head.html';
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
  } else {
    echo "not opend\n";
  }
//print_r($virtualHostInfo);
?>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <form action="edit.php" method="post">
            <div class="form-group">
                <label for="ServerName">Server Name</label>
                <input class="form-control" type="text" name="ServerName" value="<?= $virtualHostInfo['ServerName'] ?>" required>
            </div>
            <div class="form-group">
                <label for="ServerAdmin">Server Admin</label>
                <input class="form-control" type="text" name="ServerAdmin" value="<?= $virtualHostInfo['ServerAdmin'] ?>" required>
            </div>
            <div class="form-group">
                <label for="DocumentRoot">Document Root</label>
                <input class="form-control" type="text" name="DocumentRoot" value="<?= $virtualHostInfo['DocumentRoot'] ?>" required>
            </div>
            <div class="form-group">
                <label for="ErrorLog">ErrorLog</label>
                <input class="form-control" type="text" name="ErrorLog" value="<?= $virtualHostInfo['ErrorLog'] ?>" required>
            </div>
            <?php if (isset($_GET['err'])) {echo "<div class='alert alert-danger' role='alert'>ErrorLog path is not a directory!</div>";} ?>
            <div class="form-group">
                <label for="CustomLog">CustomLog</label>
                <input class="form-control" type="text" name="CustomLog" value="<?= $virtualHostInfo['CustomLog'] ?>" required>
            </div>
            <?php if (isset($_GET['cust'])) {echo "<div class='alert alert-danger' role='alert'>CustomLog path is not a directory!</div>";} ?>
            <!-- <div class="form-group">
                <label for="php">Enable PHP Script</label>
                <input type="checkbox" name="php">
            </div> -->
            <div class="checkbox">
                <label for="php">
                    <?php
                      if (trim($virtualHostInfo['php_admin_flag']) == 'on') {
                        echo "<input type='checkbox' checked> Check to enable PHP scripting.";
                      } else {
                        echo "<input type='checkbox'> Check to enable PHP scripting.";
                      }
                    ?>
                </label>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Save">
                <input class="btn btn-primary" type="reset">
            </div>
            <!-- to preserve old file name -->
             <input type="hidden" name="oldfile" value="<?=$_GET['f']?>">
        </form>
    </div>
</body>
<?php
} else {
    $php_flag = extract($_POST);
    if (! is_dir($ErrorLog) && ! is_dir($CustomLog)) {
        header("location: edit.php?err&cust&f=$oldfile");
    } elseif (! is_dir($ErrorLog)) {
        header("location: edit.php?err&f=$oldfile");
    } elseif (! is_dir($CustomLog)) {
        header("location: edit.php?cust&f=$oldfile");
    } else {
        unlink("/etc/apache2/sites-enabled/$oldfile.conf");
        $virtualHostFile = fopen("/etc/apache2/sites-enabled/".$ServerName.'.conf', 'w');
        $part1 = "<VirtualHost *:80>\nServerName $ServerName\nServerAdmin $ServerAdmin\nDocumentRoot $DocumentRoot\nErrorLog $ErrorLog\nCustomLog $CustomLog combined\nphp_admin_flag engine ";
        $part2 = ($php_flag == 5) ? "off\n</VirtualHost>\n" : "on\n</VirtualHost>\n" ;
        fwrite($virtualHostFile, $part1.$part2);
        fclose($virtualHostFile);
        header('location: index.php');
    }

}
?>
