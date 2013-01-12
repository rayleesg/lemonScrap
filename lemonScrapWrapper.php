<?php

include 'lemonScrap.php';

$myUserAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11';

function lemonScrapNewsWrapper($targetURL, $rules1, $rules2) {
    
    global $myUserAgent;
    
    $ls = new LemonScrap();
    $ls->setFirstURL($targetURL);
    $ls->setUserAgent($myUserAgent);
    $ls->setRules($rules1);
    $ls->scrap();
    
    $data1 = $ls->getResults();
    print_r($data1);
    foreach($data1['url'] as $url) {    
        $ls2 = new LemonScrap();
        $ls2->setFirstURL($url);
        $ls2->setUserAgent($myUserAgent);
        $ls2->setRules($rules2);
        $ls2->scrap();
        
        $data2[] = $ls2->getResults();
        unset($ls2);
    } unset($ls);

    return $data2;
}