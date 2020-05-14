<?php

if(isset($_POST['formWheelchair']) &&
   $_POST['formWheelchair'] == 'Yes')
{
    echo "Need wheelchair access.";
}
else
{
    echo "Do not Need wheelchair access.";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form action="index.php" method="post">
    Do you need wheelchair access?
    <input type="checkbox" name="formWheelchair" value="Yes" />
    <input type="submit" name="formSubmit" value="Submit" />
  </form>
  </body>
</html>
