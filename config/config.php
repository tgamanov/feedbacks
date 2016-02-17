<?php

Config::set('site_name', 'Messages');// название нашего сайта

Config::set('languages', array('en', 'fr'));//языки

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'messages');
Config::set('default_action', 'index');

Config::set('db.host', '127.0.0.1');
Config::set('db.user', 'root');
Config::set('db.password', 'root');
Config::set('db.db_name', 'scotchbox');

Config::set('salt', 'jd7sjdfdfdfasdasdasdccc3sdkd964he7e');