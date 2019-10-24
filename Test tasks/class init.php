<?php
/** Тест для web-разработчика

 Написать класс init, от которого нельзя сделать наследника, состоящий из 3 методов:
- create()

доступен только для методов класса

создает таблицу test, содержащую 5 полей:

id - целое, автоинкрементарное

script_name - строковое, длиной 25 символов

start_time - целое

end_time - целое

result - один вариант из 'normal', 'illegal', 'failed', 'success'

- fill() - доступен только для методов класса - заполняет таблицу случайными данными

- get() - доступен извне класса - выбирает из таблицы test, данные по критерию: result среди значений 'normal' и 'success'

В конструкторе выполняются методы create и fill

 Задание должно быть выполнено с использованием классов ZendFramework с поддержкой исключений.

Весь код должен быть прокомментирован в стиле PHPDocumentor'а.

 * @copyright  Татьяна Митева (2019)
 * @version 1.0
 */
namespace Application\Controller;

use \Zend\Db\Adapter\Adapter;

use \Zend\Db\ResultSet\ResultSet;

/**
 * Класс init
 */

final class init {

    // Подключение к БД
     
    private $adapter;

    // Конструктор класса
     
    function __construct()
    {
        try 
        {
            $this->adapter = new \Zend\Db\Adapter\Adapter(array(
                'driver' => 'Mysqli',
                'database' => 'test',
                'username' => 'root',
                'password' => ''
                ));
        } 
        catch (Exception $ex) { }
        
        $this->create();
        $this->fill();
    }
	
    //Функция create
	
	private function create(){

		$queryCreateTable = "CREATE TABLE IF NOT EXISTS `test` (`id` INT  NOT NULL AUTO_INCREMENT,`script_name` VARCHAR(25) NOT NULL,`script_time` INT NOT NULL,`end_time` INT NOT NULL,`result` SET('normal','illegal','failed','success') NOT NULL, PRIMARY KEY(`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
		try 
        {
            $this->adapter->query($queryCreateTable, Adapter::QUERY_MODE_EXECUTE);
        } 
        catch (Exception $ex) { }
	}
	
	// Функция fill
	 
	private function fill(){

	    for ($i =0; $i < 1000; ++$i){
	    	$result = array_rand(array("normal"=>"1", "illegal"=>"2", "failed"=>"3", "success"=>"4"),1);
			$script_name = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(25/strlen($x)) )),1,25);
			$queryFill = "INSERT INTO `test` (`script_name`,`script_time`,`end_time`,`result`) VALUES ('".$script_name."',".rand(1,1000).",".rand(1,1000).",'".$result."');";
			try 
            {
                $this->adapter->query($queryFill, Adapter::QUERY_MODE_EXECUTE);
            } 
            catch (Exception $ex) { }
	    }		
	}

	//Функция get
	 
	public function get($result){

        if ($result === "normal" || $result === "success")
        {
			$queryGet = "SELECT * FROM `test` WHERE `result`='".$result."'";
            try 
            {
                $preResult = $this->adapter->query($queryGet, Adapter::QUERY_MODE_EXECUTE);
                $resultSet = new \Zend\Db\ResultSet\ResultSet();
                $resultSet->initialize($preResult);
                return $resultSet->toArray();
                
            } catch (Exception $ex) 
            { 
                return Array();
            }
        }
        else 
        {
            throw new \Exception("Parameter only can be 'normal' or 'success'!");
        }
	}
}
?>