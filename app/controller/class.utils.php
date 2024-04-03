<?php

class utils{

    /**
     * Redirect to specific url
     *
     * @param string          $url 		URL to redirect to
     */
	  static function redirectTo($url){
      echo "<script>location.href='{$url}'</script>";
    }

    /**
     * Check if current user has been assigned the roles to access a resource
     *
     * @param string          $security_role_key 		Security roles required to access the resource
     * @param string          $user_role 				 		Current user security roles
     */
		static function ifAssigned( $security_role_key = '' , $user_role = '' ){
			$user_role = ( is_null( $user_role ) OR $user_role == '' ) ? ( isset( $_SESSION['user_roles'] ) ? $_SESSION['user_roles'] : 'MANAGER' ) : $user_role ;
			$security_role_key = (isset($security_role_key) AND $security_role_key != '') ? $security_role_key : 'ALL';
		  $security_roles = explode(",","MASTER,SM_MASTER,{$security_role_key}");
		  $_ok = 0;
		  $_bad = 0;
		  $user_roles = explode(",",$user_role);
		  foreach($user_roles as $user){
		    if(in_array($user, $security_roles) OR in_array('ANY', $security_roles)){
		      $_ok++;
		    }else{
		      $_bad++;
		    }    
		  }
		    return $_ok > 0 ? true : false ;
		}

    /**
     * Check if key exists in the selection
     *
     * @param string          $key 					Key to check in the selection
     * @param string          $against 			Selection
     */
		static function inSelection( $key, $against ){
		  $keys = explode(",",$key);
		  $_ok = 0; $_bad = 0;
		  $needles = explode(",",$against);
		  foreach($needles as $needle) :
		    if( in_array($needle, $keys) ) :
		      $_ok++;
		    else :
		      $_bad++;
		    endif ;
		  endforeach ;
		  return $_ok > 0 ? true : false ;
		}


    /**
     * Check if key exists in the selection
     *
     * @param string          $key 					Key to check in the selection
     * @param string          $against 			Selection
     */
		static function notAssigned( $security_role_key = '' ){
		  $user_role =  __USER['ROLES'] ;
		  $security_role_key = $security_role_key ;
		  $security_roles = explode(",","{$security_role_key}");
		  $_ok = 0;
		  $_bad = 0;
		  $user_roles = explode(",",$user_role);
		  foreach($user_roles as $user){
		    if( in_array($user, $security_roles) ){
		      $_bad++;
		    }else{
		      $_ok++;
		    }    
		  }
		    return $_bad > 0 ? true : false ;
		}

    /**
     * Unset the session keys with prefix
     *
     * @param string          $prefix 			Session prefix to unset
     * @param string          $keys		 			Specify keys to unset
     */
		static function unset_session( $prefix = null , $keys = null ){
		  $prefix = is_null( $prefix ) ? $GLOBALS['_config']['session_key'] : $prefix ;
		  foreach($_SESSION as $key => $value)
		    {
		      if( $keys != null ){
		      	if (strpos($key, "{$prefix}") === 0 AND in_array( $key , $keys ) ){
			        unset($_SESSION[$key]);
		      	}
			    }else{
			        unset($_SESSION[$key]);
		      }
		    }
		}

    /**
     * Generate a pseudo UUID
     *
     * @param integer         $input 			Length of the returned string
     */
		static function uuid( $input = [10] ){
	    $src_str  = ((isset($input[0]) AND $input[0]!='') AND !is_numeric($input[0])) ? $input[0] : '1234567890abcdef';
	    $cnt      = count($input);
	    $chk_last = is_numeric($input[count($input)-1]) ? '' : $input[count($input)-1] ;
	    $stt_item = ((isset($input[0]) AND $input[0]!='') AND !is_numeric($input[0])) ? 1 : 0;
	    $min_item = is_numeric($input[count($input)-1]) ? 0 : 1 ;
	    $input_length = strlen($src_str);
	    $rand_string  = '';
	    for($i = $stt_item ; $i<count($input)-$min_item ; $i++){
	        for($x = 0; $x < $input[$i]; $x++){
	            $rand_character = $src_str[mt_rand(0, $input_length - 1)];
	            $rand_string .= $rand_character;
	        }
	        $rand_string .= ($i == (count($input)-( $min_item + 1 ))) ? '' : $chk_last ;
	    }
	    return $rand_string;
		}

    /**
     * Generate a pseudo UUID v4 using sprintf
     */
    public static function uuid_v4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),
          mt_rand(0, 0xffff),
          mt_rand(0, 0x0fff) | 0x4000,
          mt_rand(0, 0x3fff) | 0x8000,
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate a pseudo UUID v5 using random bytes
     *
     * @param array          $_Array 			Params for generation [ first set length, opt second set length .... , separator ]
     */
		static function uuid_v5( $_Array = [5,5,6,'-'] ){
				$_Separator = is_numeric( $_Array[count($_Array) - 1] ) ? '' : $_Array[count($_Array) - 1] ;
				$_ArrLength = is_numeric( $_Array[count($_Array) - 1] ) ? count($_Array) - 2 : count($_Array) - 1 ;
		    $_Output = null ;

				for($i = 0 ; $i < $_ArrLength ; $i++ ){
					$_Output .= ( $_Output == null ? '' : $_Separator ) . bin2hex( random_bytes( ( $_Array[$i] - ( $_Array[$i] % 2 ) ) / 2 ) ) ;
				}

		    return strtoupper( $_Output ) ;
		}

    /**
     * Random string generator
     *
     * @param integer         $length 			Length of the returned string
     */
    public static function str_rand( int $length = 16 ){
        $length = ( $length < 4 ) ? 4 : $length;
        return bin2hex( random_bytes( ( $length - ( $length % 2 ) ) / 2 ) );
    }

    /**
     * Clean a string value
     *
     * @param string         $string 			String to clean
     */
		static function clean($string){
				$string = trim($string);
				return preg_replace('/[^a-zA-Z0-9\,\/_|+ .-:]/', '', $string);
		}

    /**
     * JSON encode a value
     *
     * @param string         $data 			Data to encode to JSON
     * @param string         $errorTxt	Error text when data is not a valid array
     */
		static function returnJson( $data , $errorTxt = null ){
			 $payload = isset( $data ) ? $data : $errorTxt ;
			 return json_encode( $payload , JSON_PRETTY_PRINT ) ;
		}

    /**
     * HTML Encode a string
     *
     * @param string         $string 			String to encode
     */
		static function enc( $string ){
			$substr = substr( $string , 0 , 6) ;
			if( $substr == '$_json' ){
				return substr( $string , 6 , strlen( $string ) - 6 ) ;
			}else{
				return htmlspecialchars( $string, ENT_QUOTES ) ;
			}
		}

    /**
     * Return Flash Messages
     */
	  static function flashMessage(){
	  	if( isset( $_SESSION[ $GLOBALS['_config']['session_key'] . '_FLASH_ERROR' ] ) ){
			  $flashMessage = "<div class='alert alert-danger alert-dismissible'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>{$_SESSION[ $GLOBALS['_config']['session_key'] . '_ERROR' ]}</div>";
			  unset( $_SESSION[ $GLOBALS['_config']['session_key'] . '_ERROR' ] );
			}elseif( isset($_SESSION[ $GLOBALS['_config']['session_key'] . '_SUCCESS' ]) ) {
			  $flashMessage = "<div class='alert alert-success alert-dismissible'><button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Success!</strong> {$_SESSION[ $GLOBALS['_config']['session_key'] . '_SUCCESS' ]}</div>";
			  unset( $_SESSION[ $GLOBALS['_config']['session_key'] . '_SUCCESS' ] );
			}elseif( isset($_SESSION[ $GLOBALS['_config']['session_key'] . '_WARN' ]) ) {
			  $flashMessage = "<div class='alert alert-success alert-dismissible'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>{$_SESSION[ $GLOBALS['_config']['session_key'] . '_WARN' ]}</div>";
			  unset( $_SESSION[ $GLOBALS['_config']['session_key'] . '_WARN' ] );
			}else{
				$flashMessage = "";
			}
			return $flashMessage ;
	  }

}