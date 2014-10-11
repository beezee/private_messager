<?php

require('../vendor/autoload.php');
include_once('EnhanceTestFramework.php');

\Enhance\Core::discoverTests('.');
\Enhance\Core::runTests(\Enhance\TemplateType::Cli);
