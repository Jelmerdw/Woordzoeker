<html>
<body> 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<input type="file" name="file" size="60" />
<input type="submit" value="Lees" />
</form>
</body>
</html>




<?php

if($_FILES){

 //Checking if file is selected or not

 if($_FILES['file']['name'] != "") {

 
        //Checking if the file is plain text or not

 if(isset($_FILES) && $_FILES['file']['type'] != 'text/plain') {

 echo "<span>Woordzoeker ondersteunt alleen .txt files! Kies een text bestand.</span>";

 exit();
 } 
 echo "<center><span id='Content'>Inhoud van ".$_FILES['file']['name'].":</span></center>";
 
 //Getting and storing the temporary file name of the uploaded file
 $fileName = $_FILES['file']['tmp_name'];
 
 //Throw an error message if the file could not be open
 $file = fopen($fileName,"r") or exit("Unable to open file!");
  
 

// Reading a .txt file

 while(!feof($file)) 
     {
     $regel = fgets($file);
     $regel_trim1 = rtrim($regel, "\n") ;
     $regel_trim2 = rtrim($regel_trim1, "\r") ;
     $woordzoeker[] = str_split($regel_trim2) ;
           
     }
 
      
 fclose($file);
 print"<pre>";
 print_r($woordzoeker);
 
 
 }

 else {
 if(isset($_FILES) && $_FILES['file']['type'] == '')
 echo "<span>Please Choose a file by click on 'Browse' or 'Choose File' button.</span>";
 }
}
