<?php

$path = __DIR__.'/../vendor/autoload.php';
include $path;

\PMVC\Load::plug();
\PMVC\addPlugInFolders([__DIR__.'/../../']);

\PMVC\l(__DIR__.'/resources/FakeTemplate.php');
