<!DOCTYPE html>
<html>
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<script>
$(document).ready(function()
{
    $("button").click(function(){
        $("p").hide();
    });
    
$("p").mouseover(function(){
    $("p").css("background-color", "yellow");
}); 

});
</script>

</head>

<body>

<h2>This is a heading</h2>

<p>This is a paragraph.</p>
<p>This is another paragraph.</p>

<button>Click me</button>

</body>
</html>