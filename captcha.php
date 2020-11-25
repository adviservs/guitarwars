<?php
  session_start();

  // Определение нескольких важных констант CAPTCHA
  define('CAPTCHA_NUMCHARS', 6); // Количество символов в идентификационно фразе
  define('CAPTCHA_WIDTH', 100); // Ширина изображения
  define('CAPTCHA_HEIGHT', 25); // Высота изображения

  // Создание идентификационной фразы случайным образом
  $pass_phrase = "";
	for ($i = 0; $i < CAPTCHA_NUMCHARS; $i++) {
		$pass_phrase .= chr(rand(97, 122));
  }
  
  // Сохранение идентификационно фразы в переменной сессии в защифровоном виде
  $_SESSION['pass_phrase'] = sha1($pass_phrase);

  /*
    // Показать всю информацию, по умолчанию INFO_ALL
    phpinfo();

    $testGD = get_extension_funcs("gd"); // Grab function list 
    if (!$testGD){ echo "GD not even installed."; exit; }
    echo"<pre>".print_r($testGD,true)."</pre>";
  */

  // Создание изображения
  $img = imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGHT);
  
 
  // Установка цветов: белого для фона, четного для текста и серого для графики
	$bg_color = imagecolorallocate($img, 255, 255, 255); // белый цвет
	$text_color = imagecolorallocate($img, 0, 0, 0); // черный цвет
  $graphic_color = imagecolorallocate($img, 64, 64, 64); // серый цвет
  
  // Заполнение фона
  imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGHT, $bg_color);
  
  // Рисование нескольких линий расположенных случайным образом
	for ($i = 0; $i < 5; $i++) {
		imageline($img, 0, rand() % CAPTCHA_HEIGHT, CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGHT, $graphic_color);
  }
  
  // Рисование нескольких точек расположенных случайным образом
	for ($i = 0; $i < 50; $i++) {
		imagesetpixel($img, rand() % CAPTCHA_WIDTH, rand() % CAPTCHA_HEIGHT, $graphic_color);
  }

  // Написания текста идентификационной фразы
  // $dir= dirname(realpath(__FILE__));
  // $sep=DIRECTORY_SEPARATOR;
  // $font =$dir . $sep . 'Courier New Bold.ttf';
  // putenv('GDFONTPATH=' . realpath('.'));
  // $font = "Courier New Bold";
  // $font = mb_convert_encoding($font, 'big5', 'utf-8');
  // $font = 'D:\web\www\host4.localhost\Courier New Bold.ttf';
  $font = dirname(realpath(__FILE__)) . '/Courier New Bold.ttf';
  imagettftext($img, 18, 0, 5, CAPTCHA_HEIGHT - 5, $text_color, $font, $pass_phrase);

  // Вывод изображения в PNG-формате с использованием заголовка
	header("Content-type: image/png");
  imagepng($img);
  
  // Удаление заголовка
  imagedestroy($img);
?>