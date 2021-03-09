<?php

/*
$folder = 'D:/commercials/quest-channel/Modern Marvels/';
$commercials = scandir($folder);
$commercials = array_diff($commercials, array('.','..','Thumbs.db'));
$commercials = array_values($commercials);

$sortedCommercials = array();
foreach($commercials as $commercial){
    $sortedCommercials[filemtime($folder.$commercial)] = $commercial;
}
ksort($sortedCommercials);
$sortedCommercials = array_values($sortedCommercials);

//echo '<pre>'.print_r($sortedCommercials,true).'</pre>';
//exit;

for($i=0; $i<count($sortedCommercials); $i++){
    $randomStamp = ($i % 2 == 0)?substr(sha1(microtime(true)),0,8):$randomStamp;
    $input = $folder.$commercials[$i];
    $parts = pathinfo($commercials[$i]);
    $output = $parts['filename'].'_'.$randomStamp.'_'.(($i % 2 == 0)?'begin':'close').'.'.$parts['extension'];
    rename($input, $folder.$output);
}

exit;
*/
$startTime = microtime(true);
set_time_limit(600);

$root = 'D:/';
$tempyPath = $root.'/temp/1614305863/'; // $root.'/temp/'.time().'/'; 
//mkdir($tempyPath, 0777, true);

$videoPath = '/quest-channel/Modern Marvels/2021-02-22_2-00AM_S16E16_Super_Steam.mp4';
$imagesPath = '/commercials/quest-channel/Modern Marvels/';

//mkdir($tempyPath.pathinfo($videoPath, PATHINFO_DIRNAME), 0777, true);
//mkdir($tempyPath.$imagesPath, 0777, true);

$commercials = array();
$imageFiles = array_diff(scandir($root.$imagesPath),array('.','..','Thumbs.db'));

//echo '<pre>'.print_r($imageFiles, true).'</pre>';

/*foreach($imageFiles as $imageFile){
    $tempImageResized = $tempyPath.$imagesPath.$imageFile;
    //echo $root.$imagePath.$imageFile;
    //echo $tempImageResized;
    //exit;
    scaleDownMedia($root.$imagesPath.$imageFile, $tempImageResized);
    if(!file_exists($tempImageResized) || filesize($tempImageResized) == 0){
        echo 'failed to convert image!'.'<br>';
        exit;
    }
}*/

//scaleDownMedia($root.$videoPath, $tempyPath.$videoPath);
//exit;

$i=1;
$lastFoundTime = 0.0;
foreach($imageFiles as $imageFile){
    $tempImageResized = $tempyPath.$imagesPath.$imageFile;
    //echo $tempyPath.$videoPath.' => '.$tempImageResized;
    $result = findCommercials($tempyPath.$videoPath, $tempImageResized, $lastFoundTime);
    /*if(isset($result['t'])){
        $lastFoundTime = $lastFoundTime + $result['t'];
    }*/
    echo $i.' of '.count($imageFiles). '<br><pre>'.print_r($result, true).'</pre><br>';
    //exit;
    echo '<hr>';
    flush();
    $i=$i+1;
}

echo '<pre>'.print_r($commercials, true).'</pre><br>';
echo '<hr>';
echo 'Took '.number_format(microtime(true)-$startTime,2).' seconds';
exit;

function scaleDownMedia($inputFilePath, $outputFilePath){
    $command = array();
    $command[] = 'D:/ffmpeg.exe';
    $command[] = '-vb 50M';
    $command[] = '-i "'.$inputFilePath.'"';
    $command[] = '-vf scale=iw/2:ih/2';
    $command[] = '"'.$outputFilePath.'"';
    $command[] = '2>&1';
    $command = implode(' ', $command);
    //echo $command;
    //exit;
    $output = array();
    exec($command, $output, $returnVar);
    echo 'Running command: '.$command.'<br>';
    echo '<pre>'.print_r($output, true).'</pre><br>';
    
    if(file_exists($outputFilePath) && filesize($outputFilePath) > 0){
        echo 'conversion successful! '.$outputFilePath.' is '.filesize($outputFilePath).' bytes <br><hr>';
        return true;
    }
    else{
        echo 'conversion failed! '.$outputFilePath.' is '.filesize($outputFilePath).' bytes <br><hr>';
        return false;
    }
    
}

function findCommercials($videoPath, $imagePath, $startTime='00:00:01', $duration='2:00:00', $limit='start'){
    $commercials = array();
    
    $command = array();
    $command[] = 'D:/ffmpeg.exe';
    $command[] = ' -ss '.$startTime;//.' -t '.$duration;
    $command[] = '-i "'.$videoPath.'"';
    $command[] = '-loop 1';
    $command[] = '-i "'.$imagePath.'"';
    $command[] = '-an -filter_complex "blend=difference:shortest=1,blackframe=98:32"';
    $command[] =  '-f null -';
    $command[] = '2>&1';
    //$command[] = '2> d:/output.txt';
    $command = implode(' ',$command);

    //$command = "ping 127.0.0.1";
    echo 'Running command: '.$command.'<br>';

    $descriptorSpec = array(
       0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
       2 => array("pipe", "w")    // stderr is a pipe that the child will write to
    );
    $process = proc_open($command, $descriptorSpec, $pipes);
    
    if(is_resource($process)){
        while(!feof($pipes[1])){
            $line = stream_get_line($pipes[1], 0, "\r");
            $line = trim($line);
            if($line != ''){
                echo $line.'<br>';
                if(strstr($line, '[Parsed_blackframe_1')){
                    $properties = parseFoundCommercialInfo($line);
                    //$commercials[] = $properties;
                    
                    if($limit == 'start'){
                        $ffmpegProcessStatus = proc_get_status($process);
                        //echo '<pre>'.print_r($processStatus,true).'</pre>';
                        closeProcess($ffmpegProcessStatus['pid']);
                        return $properties;//$commercials;
                    }
                }
            }
        }
    }
    //echo '</pre>';
    return array();//$commercials;
}

function parseFoundCommercialInfo($line){
    //echo 'commercial detected!: ';
    $properties = explode(' ', substr($line, strpos($line, ']')+2));
    foreach($properties as $key => $value){
        $temp = explode(':', $value);
        unset($properties[$key]);
        $properties[$temp[0]] = $temp[1];
    }
    return $properties;
}

function closeProcess($pid){
    $output = array();
    $command = 'D:/PsExec64.exe -h -i 0 -accepteula -nobanner -u Administrator -p ??? taskkill /T /F /IM '.$pid;
    
    $descriptorSpec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "w")
    );

    $process = proc_open($command, $descriptorSpec, $pipes);
}

function cropCommercialsFromVideo(){
    $command = array();
    $command[] = 'D:/ffmpeg.exe';
    $command = implode(' ', $command);
    $output = array();
    exec($command, $output, $returnVar);
    echo 'Running command: '.$command.'<br>';
    echo '<pre>'.print_r($output, true).'</pre><br>';
}
  
?>