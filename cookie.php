<?php
session_start();
if (isset($_COOKIE['cookie-user-id'])){
	$cook= $_COOKIE['cookie-user-id'];	
}else{  
    $cook="Off";
}



/*
if($cook=='0'){
    setcookie('cookie-user-id',"ddd", time()+60*30 );
}else{

        echo $_COOKIE['cookie-user-id'];	


}*/
?>