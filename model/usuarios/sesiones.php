<?php
session_start();

function IniciarSession($dato)
{
    $_SESSION['session-user-id'] = $dato;
}

if (isset($_POST['session']) != "") {
    if (isset($_SESSION['session-user-id']) != "") {
        $cook = $_SESSION['session-user-id'];
        echo $cook;
    } else {
        echo "OFF";
    }
}

function LoadSession(){
    if (isset($_SESSION['session-user-id']) != "") {
        return $_SESSION['session-user-id'];
    } else {
        return "OFF";
    }
    
}
