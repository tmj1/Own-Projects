<!--
author: TMiteva
-->

<!DOCTYPE html>
<html lang="en">
<head>
<title>Questionare</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="questions" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

	<script src="js/jquery-2.2.3.min.js"></script>


</head>
<body>

	<div class="art_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				
			</nav>	
		</div>
	</div>

	<div class="jarallax banner">
		<div class="banner-pos banner1">
			<div class="container">
				<div class="banner-info">
					<h2>Международное<span>artlinedesign.eu</span></h2> <h3>Сертифицирование</h3>
					<p>Мы верим в что вы способны на большее</p>
				</div>
			</div>
			<div class="login-form banner-posit">
				<h3>Наш опрос</h3>

				<form class="pools" method="post" action="#">
					<input type="text"  class="nameField" name="name" placeholder="Введите имя" required="" />
					<input type="email"  class="emailField" name="email" placeholder="Введите email" required="" />
					<input type="text"  class="ageField" name="age" placeholder="Введите возраст" required="" />
					<h3 class="artls-h3">Вопросы</h3>
					<div>
						<label for="question1"> 1.Что добавляет возраст? </label>
						<select id="question1" class="ship-sel">
							<option value="1" selected>Чистый классический стиль</option>
            				<option value="2">Чистый спортивный стиль</option>    
           				 	<option value="3">Смесь классики и спорта</option> 
						</select>
					</div>
					<div>
						<label for="question2"> 2.Стоит ли взрослой женщине одеться полностью в романтичном стиле? </label>
						<select id="question2" class="ship-sel">
							<option value="1" selected>Да, особенно когда идешь на свидание</option>
            				<option value="2">Нет, это будет выглядеть глупо. Надо добавлять долю романтики к другим стилям</option>    
            				<option value="3">Можно, если такой образ был на манекене</option> 
						</select>
					</div>
					<div>
						<label for="question3"> 3.Что добавляет возраст? </label>
						<select id="question3" class="ship-sel">
							<option value="1">Разобраться с долгими и короткими трендами. Долгих трендов брать чуть побольше. Коротких - на один сезон, чтобы сделать образы острыми и интересными</option>
            				<option value="2">Не трогать тренды - в них тяжело разобраться, подходит только молодежи, зачем позориться</option>    
            				<option value="3">Смотреть модные показы и полностью копировать понравившиеся образы с подиумов</option> 
						</select>
					</div>
					<div class="clearfix"></div>
					<input type="submit" value="ГОТОВО" class="button">
					<div class="response"> </div>
				</form>	

			</div>
		</div>	
	</div>
	     <table class="rows" cellspacing='0'">

    </table>
	<div class="art_agile-copyright text-center">
		<p>© 2019 Questionare. All rights reserved | Design by <a href="#">ArtLineDesign Ltd.</a></p>
	</div>

<script>
jQuery(document).ready(function() {
    jQuery(".button").bind("click", function() {

        var name = jQuery('.nameField').val();
		var email = jQuery('.emailField').val();
		var age = jQuery('.ageField').val();

        var question1 = jQuery('#question1').val();
        var question2 = jQuery('#question2').val();
        var question3 = jQuery('#question3').val();
        

		jQuery('.nameField').val('');
		jQuery('.emailField').val('');
		jQuery('.ageField').val('');
        jQuery('#question 1').val('');
        jQuery('#question 2').val('');
        jQuery('#question 3').val('');      
		
        jQuery.ajax({
            url: "for_db.php",
            type: "POST",
            data: {name:name, email:email, age: age, question1: question1, question2: question2, question3: question3}, // Передаем данные для записи
            dataType: "json",
            success: function(result) {
                if (result){ 
                    //jQuery('.rows tr').remove();
                    jQuery('.response').append(function(){
                        var res = 'Ваш результат: ';
                        res+=result.users.points[0]+ ' балла';

                            return res;
                    });
                    console.log(result);
                }else{
                    alert(result.message);
                }
                return false;
            }
        });
	return false;
    });
});
</script>
</body>
</html>	
