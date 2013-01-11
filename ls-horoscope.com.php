<?php
include 'lemonScrapWrapper.php';

$targetURL = "http://www.horoscope.com/";

$rules = array();
$rules2 = array();

$rules1[] = array(
    'startFrom' => '<!-- END Include topnavhome -->',
    'max' => 1,
    'key' => 'url',
    //'skipIfNotContainString' => 'free-daily',
    'regex' => '/<td width="55" align="center"><a href="(.*?)"/s',
    'filters' => array('trim' => TRUE)        
);

// -------------------------------------------------------------------------- //

$rules2[] = array(
    'startFrom' => 'Include horoscope-daily.html -->',
    'max' => 1,
    'key' => 'sign',
    'xpath' => array(
        '//table/tr/td[@class="col640"]/table/tr/td/h1[@class="h1b"]', 
    ),
    'modify' => array('stringReplace' => array('string1' => 'Daily Horoscope: ',
                                               'string2' => ''
                                        )
    ),
    'filters' => array('trim' => TRUE, 
                       'striphtml' => TRUE    
    ),
);

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'date',
    'xpath' => array(
        '//td/div[@id="advert"]', 
    ),
    'filters' => array('trim' => TRUE, 
                       'striphtml' => TRUE
    ),
);

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'general',    
    'xpath' => array(
        '//div[@class="fontdef1"]',
    ),
    'xpathRaw' => TRUE,
    'filters' => array('trim' => TRUE,
                       'striphtml' => TRUE,
                       'allowedhtmltags' => '<p><br><div><span><strong><b><i><u><table><col><tr><td><th><img>'
    ),
);

$rules2[] = array(
    'startFrom' => '<div class="fontsma10" style="font-weight:bold; text-transform:none;">ADDITIONAL FORECASTS</div>',
    'max' => 4,
    'key' => 'extra',
    'regex' => '/<div class="fontultrasma1"><a href="(.*?)"/s',
    'filters' => array('trim' => TRUE, 
                       'striphtml' => TRUE
    ),
);


$rules2[] = array(
    'max' => 1,
    'key' => 'extraData',
    'child' => array('key' => 'extra',
                     'rules' => $rules2[2]
    ),
);


$rules2[] = array(
    'max' => 1,
    'key' => 'url',
    'urlInfo' => TRUE,
    'modify' => array('regexReplace' => array('regex1' => '/\?.+/', 
                                              'regex2' => ''))
);

// ----------------------------------------------------------------------------- //

$data = lemonScrapNewsWrapper($targetURL, $rules1, $rules2);
print_r($data);

// ----------------------------------------------------------------------------- //