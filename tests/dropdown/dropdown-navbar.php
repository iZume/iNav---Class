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
        'title' => 'User', 
        'href' => '#', 
        'config' => [
            'side' => 'right',
            'buttons' => [
                [
                    'title' => 'Register',
                    'href' => '/register'
                ],
                [
                    'title' => 'Login',
                    'href' => '/login'
                ]
            ]
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

$navbar->configDropdown([
    'start' => [
        'element' => 'ul',
        'class' => 'dropdown'
    ],
    'after' => [
        'element' => 'div',
        'class' => 'dropdown-content'
    ]
]);
$navbar->configItem('in', [
    'element' => 'span'
]);
$navbar->clearItem('out');

foreach(array_filter($dynamicData, function($d) { return !isset($d['config']) or isset($d['config']) && $d['config']['side'] == 'left'; }) as $i) {
    if(isset($i['config']['buttons']) && count($i['config']['buttons']) > 0) {
        foreach ($i['config']['buttons'] as $sub) {
            $navbar->dropdown([
                'element' => 'li',
                'html' => $sub['title'],
                'href' => $sub['href']
            ]);
        }
    }
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
    if(isset($i['config']['buttons']) && count($i['config']['buttons']) > 0) {
        foreach ($i['config']['buttons'] as $sub) {
            $navbar->dropdown([
                'element' => 'li',
                'html' => $sub['title'],
                'href' => $sub['href']
            ]);
        }
    }
    $navbar->createItem([
        'element' => 'li', 
            'href' => $i['href'], 
            'html' => $i['title']
        ]
    );   
}

return $navbar->render();    

?>
