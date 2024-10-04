
<?php

$users = User::getAllUsers();


Response::send($users);
?>