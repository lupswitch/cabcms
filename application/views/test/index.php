<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
	<input type="text" id="name">
	<input type="text" id="pass">
	<input type="button" value="Login" id="login">

	<hr>

	<div id="log"></div>

<script>
$('#login').click(function(){
	$.post('/test/auth', {name:$('#name').val(), 'pass':$('#pass').val()}, function(r){
		$('#log').html(r)
	});
});
</script>
</body>
</html>