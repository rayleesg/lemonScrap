<?php
include 'lemonScrapWrapper.php';

$targetURL = "http://www.kompas.com/";

$rules = array();
$rules2 = array();

$rules1[] = array(
    //'startFrom' => '',
    'max' => 5,
    'key' => 'url',
    //'skipIfNotContainString' => '',
    //'regex' => '/<li><div><a href="(.*?)\?utm.+?"/s',
    'xpath' => '//li/div/a/@href',    
    'filters' => array('trim' => TRUE)        
);

// -------------------------------------------------------------------------- //

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'title',
    'regex' => array(
        '%<div class="judul_artikel2011">(.*?)</div>%s', // kompas general        
        '%<span class="judul judul_artikel2011">(.*?)</span>%s' // kompas entertaiment
    ),
    'xpath' => array(
        '//div[@class="judul_artikel2011 pb_10 pt_10"]', // kompas bola
        '//div[@class="title_news_detail"]' // kompas tekno
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
        '//div[@id="foto1"]/img/@src', // kompas general
        '//div[@class="isi_artikel"]/div[@class="photo"]', // kompas tekno
    ),
    'filters' => array('trim' => TRUE, 'striphtml' => TRUE),            
);

$rules2[] = array(
    //'startFrom' => '',
    'max' => 1,
    'key' => 'content',    
    'xpath' => array(
        '//div[@class="isi_berita2011 pt_5"]', // kompas general
        '//div[@class="isi_berita pt_5"]', // kompas bola // kompas entertaintment
        '//div[@class="isi_artikel"]', // kompas tekno        
    ),
    'xpathRaw' => TRUE,
    'filters' => array('trim' => TRUE,
                       'striphtml' => TRUE,
                       'allowedhtmltags' => '<p><br><div><span><strong><b><i><u><table><col><tr><td><th>'
                 ),
    'modify' => array(
        'regexReplace' => array(
                            array('regex1' => '/Editor :.+/s',
                              'regex2' => ''), // kompas general
                            array('regex1' => '/Editor:.+/s',
                              'regex2' => ''), // kompas tekno
                            array('regex1' => '/<!--s:I-->(.*?)<!--e:I-->/s', // kompas tekno
                              'regex2' => ''),
                            array('regex1' => '/<div class="isi_.+?>(.*?)<!--.+/s',
                              'regex2' => '$1'), // kompas general
                            array('regex1' => '%<div class="isi_.+?>(.*?)<br /><br /> <br /><br /> </p><p> </p></div>%s',
                              'regex2' => '$1'),
                            array('regex1' => '%<div class="clearit"></div><div class="left">.*%s',
                              'regex2' => ''),
                            array('regex1' => '%(</p>)<div class="clearit.+</div>%s', 
                              'regex2' => '$1'),
                        )
    ),
    'filters' => array('trim' => TRUE,
                       'striphtml' => TRUE,
                       'allowedhtmltags' => '<p><br><div><span><strong><b><i><u><table><col><tr><td><th>'
                 ) 
);

$rules2[] = array(
    'max' => 1,
    'key' => 'url',
    'urlInfo' => TRUE,
    'modify' => array('stringReplace' => array('string1' => '?utm_source=WP&utm_medium=box&utm_campaign=Kknwp', 
                                               'string2' => ''))
);

// ----------------------------------------------------------------------------- //

$data = lemonScrapNewsWrapper($targetURL, $rules1, $rules2);
print_r($data);

// ----------------------------------------------------------------------------- //