<?php  

include('../../src/iNav.php');

$dynamicData = [
    [
        'title' => 'home', 
        'href' => '/home',
        'permission' => true,
    ],
    [
        'title' => 'Contact', 
        'href' => '/contact',
        'permission' => true,
    ],
    [
        'title' => 'Partner', 
        'href' => '/partner',
        'permission' => true,
    ],
    [
        'title' => 'Register', 
        'href' => '#', 
        'config' => [
            'side' => 'right'
        ],
        'permission' => true
    ],
];

$dynamicData = array_filter($dynamicData, function($d) {  return isset($d['permission']) && $d['permission'] == true OR !isset($d['permission']); });

$navbar = new iZume\iNav();

$navbar->header([
    'before' => [
        'element' => 'div',
        'class' => 'nav',
    ],
    'start' => [
        'element' => 'ul',
        'class' => 'nav-struct'
    ],
]);
$navbar->configItem('in', [
    'element' => 'span'
]);
$navbar->clearItem('out');

foreach(array_filter($dynamicData, function($d) { return !isset($d['config']) or isset($d['config']) && $d['config']['side'] == 'left'; }) as $i) {
    $navbar->createItem([
        'element' => 'li', 
            'href' => $i['href'], 
            'html' => $i['title']
        ]
    );   
}

$navbar->configItem('out', [
    'element' => 'div',
    'class' => 'right'
]);
foreach(array_filter($dynamicData, function($d) { return isset($d['config']) && $d['config']['side'] == 'right'; }) as $i) {
    $navbar->createItem([
        'element' => 'li', 
            'href' => $i['href'], 
            'html' => $i['title']
        ]
    );   
}

$navbar->clearItem('out');

return $navbar->render();    

?>
