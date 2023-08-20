<?php

$routes = [
  '/users/create'      => 'UserService@index',
  '/users/login'       => 'UserService@login',
  '/users/update'      => 'UserService@update',
  '/users'             => 'UserService@list',
  
  '/books'             => 'BookService@index',
  '/books/all'         => 'BookService@listAll',
  '/books/alldata'     => 'BookService@allData',
  '/books/create'      => 'BookService@create',
  '/books/list/{id}'   => 'BookService@listById',
  '/books/update/{id}' => 'BookService@update',
  '/books/remove/{id}' => 'BookService@remove',

  '/'                  => 'HomeService@index',
];
