<?php 



function wpb_custom_cron_coins_cronjob_action(){


    $coinjson = file_get_contents('https://min-api.cryptocompare.com/data/all/coinlist');
  
    $topcoins = json_decode($coinjson);
  
    $coinNameList=[];
    $coinList = [];
    $coinNameListFifty=[];
    $coinData=[];
    $coinPriceDetails=[];
  
    $i=0;
      foreach($topcoins->Data as $ckey => $cval){
  
  
      $coinNameListFifty[] = $cval->Name;
  
      $img           = '<img class="thumb" src="https://www.cryptocompare.com'.$cval->ImageUrl.'">';
     
      $coinData[ $cval->Name ]        =   array('Name'=>$cval->Name,'ImageUrl'=>$cval->ImageUrl,'FullName'=>$cval->FullName,'CoinName'=>$cval->CoinName);
  
    }
  
    $i=1;
    foreach(array_chunk($coinNameListFifty,50) as $k=>$v){
  
  
    $coinName =  str_replace(' ','',implode(",",$v));
 
  
     $coindtljson = file_get_contents("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=".$coinName."&tsyms=USD");
  
     $coinPriceFull = json_decode($coindtljson);
  
  
    foreach($coinPriceFull->DISPLAY as $a => $b){
  
    
  
            $coinSinglePrice = $b->USD;

  
  
      if(isset($coinData[$a])){
        $coinPriceDetails[] = array_merge( array_merge( array('id'=>$i),  $coinData[$a]    ),[
          'CHANGEPCT24HOUR'=> $coinSinglePrice->CHANGEPCT24HOUR,
          'PRICE'=>  $coinSinglePrice->PRICE,
          'VOLUME24HOURTO'=> $coinSinglePrice->VOLUME24HOURTO,
          'MKTCAP'=> $coinSinglePrice->MKTCAP,
          'SUPPLY'=> $coinSinglePrice->SUPPLY]);
          $i++;
      }
  
  
    }
  
  
  
  }
  
 

    file_put_contents(WP_CONTENT_DIR.'/uploads/coinlist.json', json_encode(['data'=>$coinPriceDetails]));

  
  
  
  }
  
  
  
  function nice_number($n) {
    // first strip any formatting;
    $n = (0+str_replace(",", "", $n));
  
    // is this a number?
    if (!is_numeric($n)) return false;
  
    // now filter it;
    if ($n > 1000000000000) return $n.' T';
    elseif ($n > 1000000000) return $n.' B';
    elseif ($n > 1000000) return $n.' M';
    elseif ($n > 1000) return $n.'TH';
  
    return nice_number($n);
  }

?>