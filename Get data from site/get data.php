<?php

//нормализуем дату для записи в БД

    function normal_date($date){

        $monthes = array(
            "января" => "1", "февраля" => "2", "марта" => "3", 'апреля' => "4",
            "мая" => "5", "июня" => "6", "июля" => "7", "августа" => "8",
            "сентября" => "9", "октября" => "10", "ноября" => "11", "декабря" => "12"
        );

        $dt_elements = explode(',',$date);

        $date_elements = explode(' ', $dt_elements[0]);

        $time_elements = explode(':', $dt_elements[1]);

        return mktime($time_elements[0], $time_elements[1], 0, $monthes[$date_elements[1]] , $date_elements[0], date("Y"));
    }

$mysqli = new mysqli('localhost','root','','test');

    if ($mysqli->connect_errno) {
        printf("0", mysqli_connect_error());
        exit();
    }

    $mysqli->set_charset("cp1251");

    $date_db;

    $queryCreateTable = "CREATE TABLE IF NOT EXISTS `bills_ru_events` (`id` INT  NOT NULL AUTO_INCREMENT,`date` DATETIME NOT NULL,`title` VARCHAR(230) NOT NULL,`url` VARCHAR(240) NOT NULL UNIQUE, PRIMARY KEY(`id`)) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1;";

    $mysqli->query($queryCreateTable);

   //подключение библиотеки simple_html_dom.php

    include 'simple_html_dom.php';

    $html = file_get_html('https://bills.ru/');

    if($html && is_object($html) && isset($html->nodes)){

        foreach ($html->find('table[id=bizon_api_news_list]',0)->find('td') as $el) {

               foreach ($el->find('a') as $href) {

                    $html_date = file_get_html($href->href);

                        foreach($html_date->find('span[class=bizon_api_news_original_date]') as $date)

                        {
                            $date_db = normal_date($date->innertext);
                        }

                    $mysqli->query("INSERT INTO `test`.`bills_ru_events` (`date`, `title`, `url`) VALUES ('".date('Y-m-d H:i:s', $date_db)."', '$href->innertext', '$href->href')");
               }

        }

    }

?>