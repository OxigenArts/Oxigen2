<?php

global $Router;

$Router->createRoute("/user/:id", "GET", "Test/test/:id");
$Router->createRoute("/user/hello/:name/:other", "GET", "Test/othertest/:name/:other");
$Router->createRoute("/hello/:name", "GET", "Router/hello/:name");
?>