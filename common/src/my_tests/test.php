<?php
require_once 'vendor/autoload.php';

use taskforce\classes\converter\CsvToSqlConverter;
use taskforce\classes\Task;
use taskforce\classes\actions\ActionRespond;
use taskforce\classes\actions\ActionRefuse;
use taskforce\classes\actions\ActionFinish;
use taskforce\classes\actions\ActionDecline;
use taskforce\classes\exceptions\statusException;



//$task = new Task(3);
//print $task->currentStatus;
//print "\n";
//
//try {
//    $task->setStatus('ddd');
//} catch (statusException $e) {
//    print $e->getMessage();
//}
//
//print $task->currentStatus;

//iterator test
//foreach (new DirectoryIterator(__DIR__ . '/src/db') as $file) {
//    if($file->isDot()) continue;
//    echo "Вот путь" . $file->getFileInfo() . "\n";
//    var_dump($file);
//    $file = new SplFileInfo($file);
//    var_dump($file);
//}

//$str = "Is your name O'Reilly?";
//$str1 =  addslashes($str) . "\n";
//echo $str1 . "\n";
//$str1 = "'{$str1}'" . "\n";
//echo $str1;

//$converter = new CsvToSqlConverter('data/csv');
//$result = $converter->convertFiles('data/sql');

$converter = new CsvToSqlConverter(__DIR__ . '/data/csv');
$converter->convertFiles(__DIR__ . '/data/sql');

//function db_get_prepare_stmt($link, $sql, $data = []) {
//    $stmt = mysqli_prepare($link, $sql);
//
//    if ($stmt === false) {
//        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
//        die($errorMsg);
//    }
//
//    if ($data) {
//        $types = '';
//        $stmt_data = [];
//
//        foreach ($data as $value) {
//            $type = 's';
//
//            if (is_int($value)) {
//                $type = 'i';
//            }
//            else if (is_string($value)) {
//                $type = 's';
//            }
//            else if (is_double($value)) {
//                $type = 'd';
//            }
//
//            if ($type) {
//                $types .= $type;
//                $stmt_data[] = $value;
//            }
//        }
//
//        $values = array_merge([$stmt, $types], $stmt_data);
//
//        $func = 'mysqli_stmt_bind_param';
//        $func(...$values);
//
//        if (mysqli_errno($link) > 0) {
//            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
//            die($errorMsg);
//        }
//    }
//
//    return $stmt;
//}
//
//$db = [
//    'host' => '127.0.0.1',
//    'login' => 'root',
//    'password' => 'root',
//    'database' => 'taskforce'
//];
//
//$db_cfg = array_values($db);
//$conn = mysqli_connect(...$db_cfg);
//
//if (!$conn) {
//    show_error(mysqli_connect_error());
//}
//
//function setPoint ($conn) {
//    $sql = "INSERT INTO city (name, coordinates) VALUES (?, POINT(?,? ))";
//    $stmt = db_get_prepare_stmt($conn, $sql, ['Я', 1, 1]);
//    $result = mysqli_stmt_execute($stmt);
//
//}
//// setPoint($conn);
//
//function getPoint ($conn) {
//    $sql = "SELECT ST_X(coordinates), ST_Y(coordinates) FROM city WHERE name = 'Я'";
//    $result = mysqli_query($conn, $sql);
//
//    return mysqli_fetch_assoc($result);
//}
//
//$r = getPoint($conn);
//var_dump($r);


//$file = __DIR__ .'/data/csv/city.csv';
//$file = new SplFileObject($file);
//if($file->getExtension() === 'csv') {
//    echo "YEP";
//} else {
//    echo "NOPE";
//};

$a = Yii::$app->language;
echo $a;