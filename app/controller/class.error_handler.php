<?php

class error_handler{

  static function err404( $bool = 1 ){
    $error = [ 'code'=>'404','message'=>'The requested resource was not found on this server.','hash'=>hash( 'sha256', microtime() ) ] ;
    if( $bool ) :
      header( 'content-type:text/html' );
      ob_start();
      echo $GLOBALS['twig']->render( 'errors.html', ['config'=>$GLOBALS['_config'],'error'=>$error] ) ;
      $output = ob_get_contents();
      ob_clean();
    else:
      $output = json_encode( $error , JSON_PRETTY_PRINT ) ;
    endif;
    return $output;
  }

  static function err401( $bool = 1 ){
    $error = [ 'code'=>'401','message'=>'You are not authorized to view this content.','hash'=>hash( 'sha256', microtime() )  ] ;
    if( $bool ) :
      header( 'content-type:text/html' );
      ob_start();
      echo $GLOBALS['twig']->render( 'errors.html', ['config'=>$GLOBALS['_config'],'error'=>$error] ) ;
      $output = ob_get_contents();
      ob_clean();
    else:
      $output = json_encode( $error , JSON_PRETTY_PRINT ) ;
    endif;
    return $output;
  }

  static function err415( $bool = 1 ){
    $error = [ 'code'=>'415','message'=>'The requested resource is of an unsupported file type.','hash'=>hash( 'sha256', microtime() )  ] ;
    if( $bool ) :
      header( 'content-type:text/html' );
      ob_start();
      echo $GLOBALS['twig']->render( 'errors.html', ['config'=>$GLOBALS['_config'],'error'=>$error] ) ;
      $output = ob_get_contents();
      ob_clean();
    else:
      $output = json_encode( $error , JSON_PRETTY_PRINT ) ;
    endif;
    return $output;
  }

  static function err405( $bool = 1 ){
    $error = [ 'code'=>'405','message'=>'The requested method is not allowed.','hash'=>hash( 'sha256', microtime() )  ] ;
    if( $bool ) :
      header( 'content-type:text/html' );
      ob_start();
      echo $GLOBALS['twig']->render( 'errors.html', ['config'=>$GLOBALS['_config'],'error'=>$error] ) ;
      $output = ob_get_contents();
      ob_clean();
    else:
      $output = json_encode( $error , JSON_PRETTY_PRINT ) ;
    endif;
    return $output;
  }

}