
#Who is?
Is a simply navbar class to create navbars in php in a way elegant and configurable.


----------

Start
==

    $navbar = new iZume\iNav([
            'allowedAttr' => [
                'class' => [], 
                'id' => [], 
                'href' => [
                    'a'
                ],
                'data' => []
            ]
    ]);

#Header

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
    # Output
    <div class="nav">
	    <ul class="nav-struct>
	        <Replazable>
	    </ul
    </div>

#Items
-> In

    $navbar->configItem('in', [
        'element' => 'span'
    ]);
	# output
    <li>
	    <a>
    		<span> 
    		    <Replazable>
		    </span>
        </a>    
    </li>

-> Out

    $navbar->configItem('out', [
            'element' => 'div',
            'class' => 'right'
        ]);
    	# output
        <div class="right">
    	    <li>
        		<a> 
        		    <Replazable>
    		    </a>
            </li>
        </div>

-> After of config -> Create item

    $navbar->createItem([
            'element' => 'li', 
                'href' => '/contact', 
                'html' => 'Contact'
            ]
        );

   
-> Clear item-config

    $navbar->clearItem('out');
    
    $navbar->clearItem('in');

#Dropdowns in first level

the dropdown config is before of item create

Config ->

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

	<ul class="dropdown">
		<div class="dropdown-content">

		</div>
	</ul>

-> Apply config
			

    $navbar->dropdown([
	   'element' => 'li',
       'html' => 'Config',
       'href' => '/config'
    ]);
	$navbar->dropdown([
       'element' => 'li',
       'html' => 'Logout',
       'href' => '/logout'
    ]);
	# To create the dropdown is needed is needed apply CreateItem after
