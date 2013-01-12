<?php
include 'lemonScrapWrapper.php';

$targetURL = "http://www.detik.com/";

$rules = array();
$rules2 = array();

$rules1[] = array(
    //'startFrom' => '',
    'max' => 10,
    'key' => 'url',
    'skipIfNotContainString' => '/read/',
    //'regex' => '/<li><div><a href="(.*?)\?utm.+?"/s',
    'xpath' => array(
        '//h1/a/@href',
        '//h3[@class="l_yellow_detik"]/a/@href',
        '//h5[@class="l_yellow_detik"]/a/@href',
    ),
    'filters' => array('trim' => TRUE)        
);

// -------------------------------------------------------------------------- //

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'title',
    'xpath' => array(
        '//h1[@class="l_blue2_detik"]', // detik general        
    ),
    'filters' => array('trim' => TRUE, 
                       'striphtml' => TRUE
    ),
);

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'image',    
    'xpath' => array(
        '//div[@class="pic_artikel"]/img/@src', // detik general        
        '//div[@class="pic_artikel_2"]/img/@src', // detik news
    ),
    'filters' => array('trim' => TRUE, 'striphtml' => TRUE),            
);

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'content',    
    'xpath' => array(
        '//div[@class="artikel2"]', // kompas general    
    ),
    'xpathRaw' => TRUE,
    'filters' => array('trim' => TRUE,
                       'striphtml' => TRUE,
                       'allowedhtmltags' => '<p><br><div><span><strong><b><i><u><table><col><tr><td><th><img>'
                 ),
    'modify' => array(
        'regexReplace' => array(
                            array('regex1' => '/<br><br><div class="septiadi test">.+/s',
                              'regex2' => ''), // detik general
                            array('regex1' => '%<div class="pic_artikel">.+?</div>%s',
                              'regex2' => ''), // detik general                              
                            array('regex1' => '%<div class="leftside">.*?</div><strong>%s',
                              'regex2' => '<strong>'), // detik general
//                            array('regex1' => '%<div class="leftside">.*?</span>.+?</div>%s',
//                              'regex2' => ''), // detik general                              
                        )
    ),
    'filters' => array('trim' => TRUE,
                       'striphtml' => TRUE,
                       'allowedhtmltags' => '<p><br><div><span><strong><b><i><u><table><col><tr><td><th><img>'
                 ) 
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