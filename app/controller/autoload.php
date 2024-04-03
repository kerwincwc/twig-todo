<?php

require_once dirname( __DIR__ , 2 ) . '/vendor/vendor/autoload.php' ;
require_once dirname( __DIR__ , 1 ) . '/config/settings.php' ;

// $loader = new \Twig\Loader\FilesystemLoader( array( $GLOBALS['_config']['webappdir'] . "/templates" , dirname( __DIR__ , 1 ) . "/webapp/templates" ) ) ;
$loader = new \Twig\Loader\FilesystemLoader( $GLOBALS['_config']['webappdir'] . "/template" ) ;
$GLOBALS['twig'] = new \Twig\Environment($loader , array( 'cache'=>$GLOBALS['_config']['webappdir'] . '/tmp/cache' , 'debug'=>true , 'auto_reload' => true ) ) ;
$GLOBALS['twig']->addGlobal('session', $_SESSION) ;
$GLOBALS['twig']->addGlobal('config', $GLOBALS['_config']) ;

$router = new \Bramus\Router\Router();


spl_autoload_register( function( $className ) {
  $dir1 = dirname( __DIR__ , 1 ) ;

  // Check if class is a view
  if( file_exists( "{$dir1}\\view\\class.{$className}.php" ) ) :
    $file = "{$dir1}\\view\\class.{$className}.php" ;
  // Check if class is a model
  elseif( file_exists( "{$dir1}\\model\\class.{$className}.php" ) ) :
    $file = "{$dir1}\\model\\class.{$className}.php" ;
  // Check if class is a controller
  elseif( file_exists( __DIR__ . "\\class.{$className}.php" ) ) :
    $file = __DIR__ . "\\class.{$className}.php" ;
  // Return null
  else :
    $file = null;
  endif ;

  if( !is_null( $file ) ) :
    $file = str_replace( '\\' , DIRECTORY_SEPARATOR, $file ) ;
    include_once $file ;
  endif ;
  
} ) ;


function render_template($template,$params=[]){
  if( 
    file_exists( $GLOBALS['_config']['webappdir'] . "/template/{$template}" )
  ) :
    return $GLOBALS['twig']->render( $template, $params ) ;
  else :
    return error_handler::err404( 1 ) ;
  endif ;
}

function redirect($url,$ext=false){
  if(!$ext) :
    return utils::redirectTo($GLOBALS['_config']['root'] . '/' . $url) ;
  else:
    return utils::redirectTo($url) ;
  endif;
}