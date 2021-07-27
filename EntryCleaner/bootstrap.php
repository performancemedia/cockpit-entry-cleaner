<?php

include(__DIR__ . '/vendor/autoload.php');

// ACL
$app('acl')->addResource('entryCleaner', ['manage']);


// ADMIN
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {

    include_once(__DIR__ . '/admin.php');
}