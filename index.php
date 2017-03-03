<?php
$files = `ls /etc/apache2/sites-enabled/`;
$files = explode(".conf\n",$files);
# Line 11 removes empty element in at the end of the $files array.
unset($files[count($files)-1]);

#print_r($_POST);
if (isset($_POST['apache'])) {
  echo `sudo /etc/init.d/apache2 graceful`;
  unset($_POST['apache']);
}
if (isset($_POST['del']) ) {
  foreach ($files as $file) {
    if (trim($_POST[$file]) == 'on') {
      unlink("/etc/apache2/sites-enabled/".$file.'.conf');
    }
  }
  unset($_POST['del']);
  header('location: index.php');
}
?>
<body>
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
</body>
<a href="new.php">Create New</a>
