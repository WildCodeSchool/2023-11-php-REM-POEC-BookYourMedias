<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '/' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'login' => ['UserController', 'login',],
    'page_connexion' => ['UserController', 'login',],
    'logout' => ['UserController', 'logout',],
    'register' => ['UserController', 'register',],

    '' => ['MediaController', 'index',],
    'home/edit' => ['MediaController', 'edit', ['id']],
    'home/show' => ['MediaController', 'show', ['id']],
    'home/add' => ['MediaController', 'add',],
    'home/delete' => ['MediaController', 'delete',],
    'home/media/reserver' => ['MediaController', 'book'],
];
