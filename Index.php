<!DOCTYPE html>
<head>
<title>Woordzoeker</title>
<meta charset="UTF-8">
</head>
<body>
<p>Hoi dit is ons mooie project.</p>

<?php
echo file_get_contents("text.txt");
?>

<br>

 <?php
  $data = fopen("text.txt", "r");
  echo $data ;
 ?>

</body>