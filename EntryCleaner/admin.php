<?php


$app->on('admin.init', function() {

    if (!$this->module('cockpit')->hasaccess('entryCleaner', 'manage')) {

        $this->bind('/entryCleaner/*', function() {
            return $this->helper('admin')->denyRequest();
        });

        return;
    }

    // bind admin routes /entryCleaner/*
    $this->bindClass('EntryCleaner\\Controller\\Admin', 'entryCleaner');

    // add to modules menu
    $this('admin')->addMenuItem('modules', [
        'label' => 'EntryCleaner',
        'icon'  => __DIR__ . '/iconmonstr-eraser-1.svg',
        'route' => '/entryCleaner',
        'active' => strpos($this['route'], '/entryCleaner') === 0
    ]);

});
