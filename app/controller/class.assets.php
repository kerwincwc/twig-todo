<?php

class Assets{
  static function load_asset( $filename ){

    $filepath = explode( "/" , $filename )[ count( explode( "/" , $filename ) ) - 1 ] ;
    $fileext = explode( "." , $filepath )[ count( explode( "." , $filepath ) ) - 1 ] ;
    $known_mimes = [
      'css'=>'text/css',
      'js'=>'application/javascript',
      'json'=>'application/json',
      'png'=>'image/png',
      'jpg'=>'image/jpg',
      'jpeg'=>'image/jpeg',
      'gif'=>'image/gif',
      'woff'=>'font/woff',
      'woff2'=>'font/woff2',
      'ttf'=>'font/ttf'
    ];
    
    if( file_exists( $GLOBALS['_config']['webappdir'] . '/static/' . $filename ) ) :
      $filecontents = file_get_contents( $GLOBALS['_config']['webappdir'] . '/static/' . $filename , true ) ;
      $fileexists = true;
	  $output = dirname( __DIR__ , 1 ) . '/webapp/static' . $filename ;
    elseif( file_exists( dirname( __DIR__ , 1 ) . '/webapp/static/' . $filename ) ):
      $filecontents = file_get_contents( dirname( __DIR__ , 1 ) . '/webapp/static/' . $filename , true ) ;
      $fileexists = true;
	  $output = dirname( __DIR__ , 1 ) . '/webapp/static' . $filename ;
    else:
      $fileexists = false;
    endif;
    
    if( $fileexists ) :
      if( isset( $known_mimes[ $fileext ] ) ):
        header( "content-type:{$known_mimes[ $fileext ]}" );
        ob_start();
        print_r( $filecontents ) ;
        $output = ob_get_contents();
        ob_clean();
      else :
        $output = error_handler::err415( 1 );
      endif;
    else :
      $output = error_handler::err404( 1 ) ;
    endif;

    return $output ;
  }
  
}