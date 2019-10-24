<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
<?php
                    /**
                *isset() - проверяет на наличие переменной/значения (равно NULL или нет)
                *empty() - проверяет переменную на пустоту. Обращаю внимание, 0 - для нее тоже пустота!
                    **/
if( isset($_POST['name'],$_POST['email'],$_POST['message']) ) {
 $name = trim($_POST['name']); #убираем пробелы по краям, если они есть
 $email = trim($_POST['email']); #убираем пробелы по краям, если они есть
 $tel = trim($_POST['tel']); #убираем пробелы по краям, если они есть
 $message1 = trim($_POST['message']); #убираем пробелы по краям, если они есть
  if(empty($name) || empty($email) || empty($message1)) { //если что то не ввели
   echo 'You did not fill out all the fields!';
  }
  else { //все поля заполнены, отправляем
   $mailto = 'contact@reservationsdeal.site';
   $subject = 'Message from reservationdeal';
//формируем текст сообщения
   $message  = 'User Name <b>'.$name.'</b><br />Phone <b>'.$tel.'</b><br />';
   $message .= 'User E-mail: <a href="mailto:' . $email . '">' . $email . '</a><br /> Message <b>'.$message1.'</b><br />';
 
//формируем заголовки (кодировку только, остальное сами добавите по желанию)
   $headers = 'Content-type: text/html; charset=windows-1251';
//отправляем письмо
   $mail = mail($mailto, $subject, $message, $headers);
//проверяем отправку
    if(TRUE === $mail) echo '<h2>Your message has been successfully sent!</h2>';
    else echo '<h2>Your message has not been sent.</h2>';
//проверку можно записать короче при помощи тернарного оператора, вот так:
//  echo (TRUE === $mail) ? 'Ваше сообщение успешно отправлено!' : 'Произошла ошибка при отправке сообщения.' ;
//тогда нужно будет раскомментировать строчку выше и закомментировать строчки выше с проверкой
  }
}
?>