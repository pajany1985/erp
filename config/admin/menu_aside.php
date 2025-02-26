<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'bi bi-grid fs-3', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/admin',
            'id'=>'admin', // id Same as page name of after last slash
            'new-tab' => false,
            'default' => true,
            'permisson' => 'menu dashboard',
            
        ],
        [
            'title' => 'Manage Users',
            'icon' => 'bi bi-people fs-3',
            'bullet' => 'line',
            'root' => true,
            'default' => false,
            'permisson' => 'menu user',
            'submenu' => [
                [
                    'title' => 'Users',
                    'bullet' => 'dot',
                    'permisson' => 'list users',
                    'page' => '/admin/users',
                    'id'=>'users',
                    'default' => false,
                ],
                [
                    'title' => 'Role',
                    'bullet' => 'dot',
                    'permisson' => 'list role',
                    'page' => '/admin/roles',
                    'id'=>'roles',
                    'default' => false,
                ],
               
            ]
        ],

        [
            'title' => 'Manage Package',
            'desc' => '',
            'icon' => 'bi bi-archive fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu package',
            'root' => true,
            'default' => false,
            'page' => '/admin/packages',
            'id'=>'packages',
        ],
        
        // [
        //     'title' => 'Manage Employer',
        //     'desc' => '',
        //     'icon' => 'bi bi-people fs-3',
        //     'bullet' => 'dot',
        //     'permisson' => 'menu employer',
        //     'root' => true,
        //     'default' => false,
        //     'page' => '/admin/employers',
        //     'id'=>'employers',
        // ],
        [
            'title' => 'Manage Employer',
            'icon' => 'bi bi-people fs-3',
            'bullet' => 'line',
            'root' => true,
            'default' => false,
            'permisson' => 'menu employer',
            'submenu' => [
                [
                    'title' => 'Manage Employer',
                    'bullet' => 'dot',
                    'permisson' => 'list employer',
                    'page' => '/admin/employers',
                    'id'=>'employers',
                    'default' => false,
                ],
                [
                    'title' => 'Manage Subuser',
                    'bullet' => 'dot',
                    'permisson' => 'list subuser',
                    'page' => '/admin/subemployers',
                    'id'=>'subemployers',
                    'default' => false,
                ],
               
            ]
        ],

        [
            'title' => 'Manage Position',
            'desc' => '',
            'icon' => 'bi bi-boxes fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu position',
            'root' => true,
            'default' => false,
            'page' => '/admin/positions',
            'id'=>'positions',
        ],


        //   [
        //     'title' => 'Manage Assessment',
        //     'desc' => '',
        //     'icon' => 'bi bi-flower3 fs-3',
        //     'bullet' => 'dot',
        //     'permisson' => 'menu assessment',
        //     'root' => true,
        //     'default' => false,
        //     'page' => '/admin/assessments',
        //     'id'=>'assessments',
        // ],

          [
            'title' => 'Manage Candidate',
            'desc' => '',
            'icon' => 'bi bi-people fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu candidate',
            'root' => true,
            'default' => false,
            'page' => '/admin/candidates',
            'id'=>'candidates',
        ],

        [
            'title' => 'Manage Transaction',
            'desc' => '',
            'icon' => 'bi bi-arrow-left-right fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu transaction',
            'root' => true,
            'default' => false,
            'page' => '/admin/transactions',
            'id'=>'transactions',
        ],
        [
            'title' => 'Manage Mail Content',
            'desc' => '',
            'icon' => 'bi bi-envelope fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu transaction',
            'root' => true,
            'default' => false,
            'page' => '/admin/mailcontent',
            'id'=>'mailcontent',
        ],
        [
            'title' => 'Manage CMS',
            'desc' => '',
            'icon' => 'bi bi-gear-wide fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu cms',
            'root' => true,
            'default' => false,
            'page' => '/admin/cmspage',
            'id'=>'cmspage',
        ],
       
          [
            'title' => 'Manage Offers',
            'desc' => '',
            'icon' => 'bi bi-patch-check fs-3',
            'bullet' => 'dot',
            'permisson' => 'menu offers',
            'root' => true,
            'default' => false,
            'page' => '/admin/offers',
            'id'=>'offers',
        ],
        [
            'title' => 'Manage Template',
            'icon' => 'bi bi-subtract fs-3',
            'bullet' => 'line',
            'root' => true,
            'default' => false,
            'permisson' => 'menu template',
            'submenu' => [
                [
                    'title' => 'Question Template',
                    'bullet' => 'dot',
                    'permisson' => 'list questiontemp',
                    // 'root' => true,
                    'default' => false,
                    'page' => '/admin/questiontemp',
                    'id'=>'questiontemp',
                ],
               
            ]
        ],
      
    ]

];
