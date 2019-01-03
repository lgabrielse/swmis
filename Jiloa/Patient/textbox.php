<?php $text = "today is the day for all good men to come to the aid of their parties.  today is the day for all good men to come to the aid of their parties.<br/>today is the day for all good men to come to the aid of their parties.<br/>today is the day for all good men to come to the aid of their parties."
?>
<?php $rows = strlen($text)/40; //strlen($text)?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="500px" border="1">
  <tr>
    <td>&nbsp;</td>
    <td><?php echo strtoupper($text) ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
<form action="" method="get">
    <td>&nbsp;</td>
    <td><input name="textinput" type="text" value=<?php echo $text; ?> /></td>
    <td>&nbsp;</td>
</form> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><textarea name="txtarea" cols="50" rows="<?php echo $rows ?>"><?php echo $text; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<textarea name="" cols="" rows=""></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</body>
</html>
