<?php
  //https://web.archive.org/web/20200426004001/http://zap2xml.awardspace.info/  
  $startTime = microtime(true);
  set_time_limit(60*60); // one hour
  
  $skipPrograms = array();
  
  if(php_sapi_name() !== 'cli'){
    //$argv = array(null,"atsc","http://10.0.0.2:5004/auto/v","63.2","00:30:00","quest-channel","13");
    //$argv = array(null,"atsc","http://10.0.0.2:5004/auto/v","68.3","00:30:00","gettv-channel","5");
    //$argv = array(null,"atsc","http://10.0.0.2:5004/auto/v","21.2","00:30:00","pbs-channel","4");
    $argv = array(null,"fios","http://10.0.0.168/0.ts","auto","00:30:00","fios","5");
  }
  else{
      ob_start();
  }
  
  if(count($argv) < 7){
      die('needs 6 arguments: source, url, channel, time, folder prefix, seconds to trim');
  }
  
  if($argv[1] == "atsc"){
      $urlParts = parse_url($argv[2]);
      ini_set('default_socket_timeout', 2);
      @$pageResults = file_get_contents($urlParts['scheme'].'://'.$urlParts['host']);
      if(strstr($pageResults, 'HDHomeRun CONNECT QUATRO') === false){
        echo 'could not find index page of tuner! server down or on another IP address?<br>';
      }
      else{
        echo 'found tuner web page!<br>';
      }
      $xml = simplexml_load_file('D:/atsctv.xml');
  }
  else if($argv[1] == "fios"){
      $xml = simplexml_load_file('D:/fiostv.xml');
  }
  
  //echo '<pre>'.print_r($xml,true).'</pre>';'
  
  $channelId = '';
  $channelName = '';
  if($argv[3] == "auto"){
    $temp = intval(file_get_contents('D:/currentFiosChannel.txt'));
    if(is_integer($temp)){
        $argv[3] = $temp;
    }
  }
  
  foreach($xml->channel as $key => $channel){
      if($channel->{'display-name'}[1] == $argv[3]){ //63.2
        $channelId = $channel['id'];
        $channelName = (string)$channel->{'display-name'}[2];
        break;
      }
  }

  echo "Channel name found: ".$channelName.'<br>';
  
  $fiosChannelMap = json_decode(file_get_contents('D:/fiosChannelMap.json'),true);
  if(array_key_exists($channelName, $fiosChannelMap)){
      $channelName = $fiosChannelMap[$channelName];
      echo "Channel name alias found: ".$channelName.'<br>';
  }
  
  echo "Channel ID found: ".$channelId.'<br>';
  
  //$channelId = 'I63.2.34788.tvguide.com';
  $datetime1 = new DateTime('now', new DateTimezone('America/New_York'));
  $minutesSeconds = $datetime1->format('i') >= 30 ? '3000' : '0000';  
  $datetime1 = $datetime1->format("YmdH$minutesSeconds O");
  
  //echo $datetime1; // 2021 03 17 19 30 00 -0400
  //exit;
  
  // insert datetime from past/future tv program
  if(php_sapi_name() !== 'cli'){
    //$datetime1 = '20210402140000 -0500';
  }
  echo 'TV show half-hour date-time: '.$datetime1.'<br>'; // 8:31PM => 8:30pm, 9:01AM => 9:00am
  //2021 02 20 20 30 00 -0500
  
  $programTitle = '';
  $episodeTitle = '';
  $duration = '';
  $seasonEpisode = '';
  
  //echo '<pre>'.print_r($xml->programme[0],true).'</pre>';
  //exit;
  
  $count = count($xml->programme);
  for($i=0; $i<$count; $i++){
      if((string)$xml->programme[$i]['channel'] == $channelId){
          echo 'channel found!<br>';
          
          if(php_sapi_name() !== 'cli'){
             //echo '<pre>'.print_r($xml->programme[$i],true).'</pre>';
          }
          
          //echo $xml->programme[$i]['start'] . '<br>' . $datetime1 . '<br><br>';
          
          if((string)$xml->programme[$i]['start'] == $datetime1){
             echo 'program found! took '.number_format(microtime(true)-$startTime,2).' seconds<br>';
             $programTitle = $xml->programme[$i]->title;
             $episodeTitle = $xml->programme[$i]->{'sub-title'};
             
             $duration = gmdate('H:i:s', abs(strtotime(substr($xml->programme[$i]['stop'], 0, 14)) - strtotime(substr($xml->programme[$i]['start'], 0, 14))));
             echo 'duration: '.$duration.'<br>';
             $seconds = explode(':',$duration);
             $seconds = $seconds[0]*60*60+$seconds[1]*60+$seconds[2] - $argv[6];
             echo 'start delay: '.$argv[6].'<br>';
             echo 'duration in seconds: '.$seconds.'<br>';
             $trimSeconds = 10;
             echo 'trim duration by seconds: '.$trimSeconds.'<br>';
             $seconds -= $trimSeconds;
             $duration = implode(':', array(str_pad(floor($seconds/60/60),2,'0',STR_PAD_LEFT), str_pad(floor(($seconds%3600)/60),2,'0',STR_PAD_LEFT), str_pad($seconds%60,2,'0',STR_PAD_LEFT)));
             echo 'duration trimmed: '.$duration.'<br>';
             
             $seasonEpisode = (string)($xml->programme[$i]->{'episode-num'}[0]);             
             echo 'info: '.$seasonEpisode . ' ' . $programTitle . ' ' . $episodeTitle . ' ' . $duration.'<br>';
             break;
          }
      }
  }
  //exit;
  
  $startTime = time();
  $datetime = new DateTime('now', new DateTimezone('America/New_York'));
  $datetime = $datetime->format('Y-m-d_g-iA');

  if($argv[1] == 'fios'){
      $programTitle = $channelName . '-' . $programTitle;
  }
  $programTitle = preg_replace('/[^-A-Za-z0-9&, \']/', '-', $programTitle);
  $episodeTitle = preg_replace('/[^-A-Za-z0-9&, \']/', '_', $episodeTitle);
  
  $folder = 'D:/'.$argv[5].'/'.$programTitle.'/';
  if(php_sapi_name() === 'cli' && !file_exists($folder)){
    mkdir($folder,0777,true);
  }

  if($duration == ''){
      $duration = $argv[4];
  }
  if($programTitle != '' && $episodeTitle != ''){ // exclude date-time if program and episode title are found
    $videoFile = "\"D:/".$argv[5].'/'.$programTitle.'/'.$seasonEpisode.' - '.$episodeTitle.".mp4\"";    
  }
  else{
    $videoFile = "\"D:/".$argv[5].'/'.$programTitle.'/'.$datetime.".mp4\"";
  }
  
  echo "video file: ".$videoFile.'<br>';
  $cmd = "D:/ffmpeg.exe -y -i \"".$argv[2].(($argv[1] == 'atsc')?$argv[3]:'')."\" -c copy -t ".$duration . " " . $videoFile. " 2>&1";

  if(in_array($programTitle,$skipPrograms)){
    echo "Skipping program \"".$programTitle."\" in skip programs array: ".json_encode($skipPrograms,JSON_PRETTY_PRINT).'<br>';
  }
  else{
    echo("Running command: " . $cmd . '<br>');    
  }  
  
  if(php_sapi_name() !== 'cli'){
      exit;
  }
  
  $logFile = $folder.$datetime.'_log.html';
  //die($logFile);
  $fp = fopen($logFile, 'a');
  
  $echoedHtml = ob_get_contents();
  ob_end_clean();
  fwrite($fp, $echoedHtml. '<hr>');

  if(!in_array($skipPrograms,$programTitle)){
  
    $descriptorspec = array(
       0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
       2 => array("pipe", "w")    // stderr is a pipe that the child will write to
    );

    $process = proc_open($cmd, $descriptorspec, $pipes);
    fwrite($fp, '<pre>');
    if (is_resource($process)) {
        while (!feof($pipes[1])) {
            $s = fread($pipes[1],1);
            print $s;
            fputs($fp, $s);
            flush();
        }
    }
    fwrite($fp, '</pre>');
    fclose($fp);
  }
  
echo 'File size of video: '.filesize($video).'<br>';
$fileSizeMinimum = 104857600;
if(file_exists($video) && filesize($video) < $fileSizeMinimum){ 
    echo 'File size '.number_format(filesize($video)/1024/1024,2).'MB is too small (less than '.number_format($fileSizeMinimum/1024/1024,2).'MB), deleting it! returned: '.unlink($video);
}
echo "Ended<br>";

// https://legacy.imagemagick.org/Usage/compare/#compare

// ffmpeg.exe -i C:\Users\Jesse\Desktop\2021-02-22_10-00AM_S16E15_Keep_Out.mp4 -loop 1 -i C:\Users\Jesse\AppData\Roaming\PotPlayerMini64\Capture\2021-02-22_9-00AM_S16E17_Doors.mp4_20210222_141855.680.jpg -an -filter_complex "blend=difference:shortest=1,blackframe=90:32" -f null - 2> C:\Users\Jesse\Desktop\output.txt
// ffmpeg.exe -copyts -i C:\Users\Jesse\Desktop\2021-02-22_9-00AM_S16E17_Doors.mp4 -i C:\Users\Jesse\Desktop\commercials\2021-02-22_9-00AM_S16E17_Doors.mp4_20210222_142312.447.jpg -filter_complex "[0]extractplanes=y[v];[1]extractplanes=y[i];[v][i]blend=difference,blackframe=0,metadata=select:key=lavfi.blackframe.pblack:value=80:function=greater,trim=duration=0.0001,metadata=print:file=-" -an -v 0 -vsync 0 -f null -


?>