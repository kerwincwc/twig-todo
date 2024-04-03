<?php

session_start();
include_once __DIR__ . '/controller/autoload.php' ;
require_once __DIR__ . '/config/settings.php';

// include_once( __DIR__ . "/models/class.categories.php" ) ;

$router->get('/static/(.*)', function($filename){ print_r( Assets::load_asset( $filename ) ) ; });

$router->get('/', function() {
    $task_list = Todo::factory()->get();
    print_r( render_template( 'index.html' , [ "task_list"=>$task_list ] ) ) ;
} );

$router->post('/add', function() {
    $db = Todo::factory()->begin();
    $db->insert(['task'=>$_POST['todo']]);
    $db->commit();
    redirect('./');
});

$router->get('/delete/(\d+)', function( $todoId ) {
    $db = Todo::factory()->begin();
    $db->where('id', $todoId);
    $db->delete();
    $db->commit();
    redirect('./');
});


$router->post('/update/(\d+)', function( $todoId ) {
    $db = Todo::factory()->begin();
    $db->where('id', $todoId);
    $db->update(['task'=>$_POST['todo']]);
    $db->commit();
    redirect('./');
});

$router->get('/update/(\d+)/(\d+)', function( $todoId, $actionId ) {
    $db = Todo::factory()->begin();
    $db->where('id', $todoId);
    $db->update(['completed'=>$actionId]);
    $db->commit();
    redirect('./');
});

$router->match('GET|POST', '/(\d+)', function( $todoId ) {
    $db = Todo::factory();
    $db->where('id', $todoId);
    $task = $db->first();
    $task_list = Todo::factory()->get();
    print_r( render_template( 'index.html' , [ "task"=>$task , "task_list"=>$task_list ] ) ) ;
});

$router->get('/test', function() {
    $task_list = Todo::factory()->get();
    print_r( $task_list ) ;
} );


$router->run();

