<?php
// GLOBAL CONFIGS
define("DEBUG", true); // Default in true

// Debug config for database
define("DEBUG_DATABASE_NAME", "petpetition");
define("DEBUG_DATABASE_USER", "root");
define("DEBUG_DATABASE_PASSWORD", "");
define("DEBUG_DATABASE_HOST", "localhost");
// Deploy config for database
define("DEPLOY_DATABASE_NAME", "id16397877_petpetition");
define("DEPLOY_DATABASE_USER", "id16397877_petpetitiondb");
define("DEPLOY_DATABASE_PASSWORD", "{L*CB@^L2XIEcG\@");
define("DEPLOY_DATABASE_HOST", "localhost");

// General settings
define('HOST', DEBUG ? DEBUG_DATABASE_HOST : DEPLOY_DATABASE_HOST);
define('USER', DEBUG ? DEBUG_DATABASE_USER : DEPLOY_DATABASE_USER);
define('PASS', DEBUG ? DEBUG_DATABASE_PASSWORD : DEPLOY_DATABASE_PASSWORD);
define('DATA', DEBUG ? DEBUG_DATABASE_NAME : DEPLOY_DATABASE_NAME);