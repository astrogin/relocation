<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src = "/library/jquery-3.1.1.js"></script>
	<title>Document</title>
</head>
<body>
		<?php 
			require_once 'Route.php';
			$rr = new Route(array("controller_name" => "main"),'Controller_','controller/');
			$rr->run();
		?>
</body>
	<script>
		$(document).ready( function(){
			//focus mouse on input
			$("#mainInput").focus();
			//valid mainInput
			var objValidator = {
				clickValid: function (regExp,mass) {
				var objForAjax = {};
				for (var i = 0; i < mass.length; i++) {
					if(mass[i].search(regExp) != -1) {
						objForAjax[i] = mass[i];
					}else {
						if (i==0) {
							alert("Неверный формат ссылки");
							return false;
						}
						alert("Неверный формат ссылки №" + (i+1));
						return false;
					}
				}
				this.ajaxFunc(objForAjax);
			},
				ajaxFunc: function (obj) {
					$.ajax({
					url:"controller/Controller_handler.php",
					type:"POST",
					data: obj,
					success: function (data) {
						$('#test').html(data);
						}
					})
				}
		}
					$("form").submit(function (){
						var regExp = /[\s\S]{1,}\.+[\s\S]{2,}/gi;
						var inputValue = $("#mainInput")[0].value.split(' ');
						objValidator.clickValid(regExp,inputValue)
					return false;
				})
});
	</script>
</html>
