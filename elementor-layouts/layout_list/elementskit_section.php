<?php
// elements_sections/blog/blog_page_1
// 1st level/2nd level / 3rd level
echo $tab;
$data = [
    'templates' => [
        0 => [
            'template_id' => '36343', //md5 has of last 3 lvl directory names
            'title' => 'Home  — Arnau', // 3rd level directory
            'categories' => [ // 2nd level directory
                0 => 'home'
            ],
            'keywords' => [ // static
               
            ],
            'source' => 'elementskit-api', // static
            'hasPageSettings' => '', // static
            'thumbnail' => 'http://xpeedstudio.com/wp/agmycoo/assets/images/demos/demo-2.png', // preview.jpg
            'preview' => 'http://xpeedstudio.com/wp/agmycoo/assets/images/demos/demo-2.png', // preview.jpg
            'type' => 'elementskit_page', // $tab value
            'author' => 'XpeedStudio', //static
            'modified' => '2019-01-15 15:32:17' //static
        ], 
    ],
    'categories' =>[ // list of 2nd level directory
      [
        'slug' => '', //static
        'title' => 'All', //  static
      ],
      [
        'slug' => 'about', // dirsectory as it is
        'title' => 'About', // formated directory name
      ],
      [
        'slug' => 'home',
        'title' => 'Home',
      ],
      [
        'slug' => 'test',
        'title' => 'Test',
      ],
    ],
    'keywords' => [ // static

    ],   
];