<?php
require __DIR__.'/../vendor/autoload.php';


exec('build/run_all_tests', $output, $ret);

//var_dump($output);

echo "output <<<" . implode("\n", $output) . ">>>";
echo "ret <$ret>";

$token = 'YOUR_TOKEN';
$roomId = 'ROOM_ID';


$hipChat = new Mamor\HipChat($token);

if ($ret)
{
	$hipChat->post("/v2/room/$roomId/notification", ['message' => "test run failed -- [" . implode("\n", $output) . "]"]);
}
else
{
	$hipChat->post("/v2/room/$roomId/notification", ['message' => "test run passed -- [" . implode("<br/>", $output) . "]"]);
}

$hipChat->curl()->response;

exit($ret);
