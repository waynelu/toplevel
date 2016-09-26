<?php
// require the Faker autoloader
require_once 'vendor/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

$worldcities = file('../worldcitiespop.txt');

date_default_timezone_set("America/Los_Angeles");
  
while(true) {
  $lines = $faker->numberBetween(1, 1000);
  for ($i = 0; $i < $lines; $i++) {
    $curDateTime = date("Y-m-d H:i:s");
    $microtimeArr = explode(' ', microtime());
    $milliseconds = floor($microtimeArr[0] * 1000);
    $logtime = $curDateTime . '.' . sprintf('%03d', $milliseconds);
    
    $curDateTimeArr = explode(' ', $curDateTime);
    $curDay = $curDateTimeArr[0];
    $curTimeArr = explode(':', $curDateTimeArr[1]);
    $curHour = $curTimeArr[0];
    
    $logDir = 'log/' . $curDay;
    if (!is_dir($logDir)) {
      mkdir($logDir);
    }
    $logFile = $logDir . '/usage-' . $curHour . '.log';
    
    
    $number = $faker->randomFloat(2, 10, 100);
    //$state = $faker->optional($weight=0.7, $default='california')->state;
    
    $cityInfo = explode(',', trim($worldcities[$faker->numberBetween(1, count($worldcities)-1)]));
    $country = $cityInfo[0];
    $city = $cityInfo[2];
    $lat = $cityInfo[5];
    $long = $cityInfo[6];
    //$lat = $faker->latitude();
    //$long = $faker->longitude();
    
    $logLine = implode("|", array($logtime, $number, $country, $city, $lat, $long)) . "\n";
    echo $logLine;
    file_put_contents($logFile, $logLine, FILE_APPEND);

    usleep(1000);
  }
  sleep(1);
}
