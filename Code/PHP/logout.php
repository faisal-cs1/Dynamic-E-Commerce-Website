<?php

session_start();

session_destroy();

header('Location: ../PHP/home.php');

?>