<?php
  //Verizon FiOS
  
  //set_time_limit(30*60);
  ob_start();  
  $channels[] = '401'; // hbo hd w
  $channels[] = '402'; // hbo 2 hd
  $channels[] = '403'; // hbo 2 hd
  $channels[] = '404'; // hbo signature hd
  $channels[] = '405'; // hbo signature hd
  $channels[] = '406'; // hbo fam
  $channels[] = '407'; // hbo fam
  $channels[] = '408'; // hbo comedy
  $channels[] = '409'; // hbo comedy  hd
  $channels[] = '410'; // hbo zone  
  $channels[] = '458'; // charge!
  $channels[] = '459'; // comet
  $channels[] = '467'; // abc localish
  $channels[] = '473'; // wliw21 world
  $channels[] = '490'; // court tv live
  $channels[] = '493'; // movies
  $channels[] = '497'; // all arts
  $channels[] = '481'; // nhk
  $channels[] = '502'; // cbs
  $channels[] = '503'; // me too
  $channels[] = '504'; // nbc
  $channels[] = '505'; // fox
  //$channels[] = '506'; // rnn
  $channels[] = '507'; // abc
  $channels[] = '509'; // court tv
  $channels[] = '510'; // court tv
  $channels[] = '511'; 
  //$channels[] = '513'; // pbs
  $channels[] = '517'; // wmbc.tv
  //$channels[] = '519'; // pbs
  //$channels[] = '521'; // pbs
  //$channels[] = '523'; // pbs
  //$channels[] = '525'; // nyclife
  $channels[] = '529'; // news12
  $channels[] = '530'; // news12
  //$channels[] = '531'; // ion
  //$channels[] = '548'; // religious
  $channels[] = '550'; // usa
  $channels[] = '551'; // tnt
  $channels[] = '552'; // tbs
  $channels[] = '553'; // fxhd
  $channels[] = '554'; // paramount
  $channels[] = '568'; // news nation
  $channels[] = '569'; // axstv
  $channels[] = '600'; // cnn
  //$channels[] = '601'; // local now
  $channels[] = '602'; // cnbc
  $channels[] = '603'; // msnbc
  $channels[] = '604'; // yahoo finance
  $channels[] = '609'; // bbc world news
  //$channels[] = '610'; // i24news
  $channels[] = '611'; // weather channel
  //$channels[] = '614'; // cheddar news
  //$channels[] = '615'; // newsmax
  $channels[] = '616'; // one america news
  $channels[] = '617'; // fox business
  $channels[] = '618'; // fox news
  $channels[] = '619'; // accuweather
  $channels[] = '620'; // discovery
  $channels[] = '621'; // national geographic
  $channels[] = '622'; // sci
  $channels[] = '623'; // id
  $channels[] = '624'; // life
  //$channels[] = '625'; // ahc
  $channels[] = '628'; // history
  $channels[] = '629'; // fyi,hd
  //$channels[] = '630'; // animal planet
  $channels[] = '631'; // motortrend
  $channels[] = '632'; // national geographic wild
  $channels[] = '633'; // pets.tv
  $channels[] = '634'; // smithsonian
  $channels[] = '635'; // living
  //$channels[] = '639'; // tlc
  $channels[] = '662'; // 1 living
  //$channels[] = '668'; // destination america
  $channels[] = '669'; // awe
  $channels[] = '670'; // trvl
  $channels[] = '680'; // syfy
  //$channels[] = '681'; // a&e
  $channels[] = '683'; // trutv
  $channels[] = '684'; // game show
  $channels[] = '687'; // logo
  $channels[] = '689'; // bbc america hdd
  $channels[] = '690'; // comedy central
  $channels[] = '691'; // fxxhd
  $channels[] = '695'; // comedy.tv
  $channels[] = '697'; // vice
  $channels[] = '699'; // freeform
  $channels[] = '710'; // mtv
  $channels[] = '711'; // mtv2
  $channels[] = '715'; // mtv live
  $channels[] = '716'; // vh1
  $channels[] = '726'; // revolt
  $channels[] = '731'; // amc
  $channels[] = '732'; // fxm
  $channels[] = '734'; // ifc
  $channels[] = '736'; // sundance tv
  //$channels[] = '752'; // nick
  //$channels[] = '754'; // nick toons
  $channels[] = '757'; // cartoon network
  $channels[] = '772'; // aspire
  $channels[] = '804'; // g4
  $channels[] = '810'; // mavtv
  
  //$channels = array();
  //for($i=400; $i<500; $i++){
      //array_push($channels, str_pad((string)$i, 4, '0', STR_PAD_LEFT));
  //}
  
  $buttons[0] = "39,8958,4486,478,2254,476,2252,478,2254,476,2278,452,2252,476,2254,476,2280,452,2254,476,2254,476,2254,476,2252,478,2254,476,2278,452,2278,450,2256,476,2256,474,42002,8958,2270,452;";
  $buttons[1] = "39,8962,4484,480,4496,476,2252,478,2252,476,2254,478,2254,476,2254,476,2280,450,2256,476,2256,476,2254,476,2256,474,2252,478,4492,478,4494,478,4494,478,4494,478,30800,8958,2270,452;";
  $buttons[2] = "39,8962,4488,476,2254,478,4494,478,2252,478,2256,476,2254,478,2254,476,2254,476,2256,474,2254,476,2282,450,2256,476,2252,478,2254,478,4496,478,4498,474,4492,478,33050,8960,2248,476;";
  $buttons[3] = "39,8960,4512,450,4496,476,4494,476,2280,450,2254,476,2256,474,2254,478,2254,476,2254,476,2256,476,2252,478,2252,478,2254,476,4496,478,2256,474,4494,476,4494,478,30800,8962,2246,478;";
  $buttons[4] = "39,8964,4486,478,2252,478,2256,476,4496,476,2254,476,2256,474,2252,478,2254,478,2256,474,2280,452,2256,474,2256,476,2280,452,2254,476,2254,476,4522,450,4498,474,35098,8960,2272,450;";
  $buttons[5] = "39,8962,4486,476,4498,474,2252,478,4494,478,2280,450,2254,476,2280,450,2280,450,2256,476,2254,476,2256,476,2254,476,2254,476,4492,478,4494,478,2254,476,4494,478,30800,8964,2244,478;";
  $buttons[6] = "39,8964,4486,478,2254,476,4496,478,4494,478,2254,478,2254,476,2252,478,2256,476,2254,476,2256,474,2252,478,2254,476,2256,474,2280,450,4494,478,2254,476,4522,450,33044,8962,2246,476;";
  $buttons[7] = "39,8960,4486,478,4496,476,4494,476,4496,476,2252,478,2256,476,2256,474,2254,476,2254,476,2280,450,2254,478,2254,476,2254,476,4496,478,2278,452,2254,476,4494,478,30800,8964,2244,478;";
  $buttons[8] = "39,8958,4488,476,2254,476,2254,476,2256,476,4494,478,2280,452,2256,476,2278,452,2282,450,2254,476,2282,450,2254,478,2280,450,2252,478,2254,476,2254,476,4494,478,37398,8960,2248,476;";
  $buttons[9] = "39,8962,4486,476,4494,478,2254,478,2280,450,4492,480,2280,450,2254,478,2252,478,2254,476,2250,478,2254,478,2254,476,2254,476,4494,478,4496,476,4494,478,2280,450,30802,8960,2262,458;";
  
  /*foreach($channels as $channel){
      echo "changing to channel: ".$channel.'<br>';
      $channel = str_pad($channel, 4, '0', STR_PAD_LEFT);
      for($i=0; $i<strlen($channel); $i++){ 
        pressButton($buttons[$channel[$i]]);
      }
      sleep(10);
  }*/
  
  $randomChannel = array_rand($channels);
  $randomChannel = $channels[$randomChannel];
  $randomChannel = str_pad($randomChannel, 4, '0', STR_PAD_LEFT);
  
  file_put_contents('D:/currentFiosChannel.txt', $randomChannel);
  
  echo "random channel selected: ".$randomChannel.'!<br>';
  
  for($i=0; $i<strlen($randomChannel); $i++){
          pressButton($buttons[$randomChannel[$i]]); 
  }
  
  $output = ob_get_contents();
  ob_end_clean();
  file_put_contents('d:/log-fios-randomChannelChanger.html', date("F j, Y, g:i a").'<br>'.$output.'<hr>', FILE_APPEND);
  echo $output;
  
  function pressButton($button){
      $ch = curl_init("[your_server_URL_here]");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "p=".$button);
      $output = curl_exec($ch);
      echo $output.'<br>';
      curl_close($ch);
  }  
  
?>
