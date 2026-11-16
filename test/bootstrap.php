<?php

\chdir(\dirname(__DIR__));
\ini_set('memory_limit', '512M');
\error_reporting(E_ALL);

require './vendor/antecedent/patchwork/Patchwork.php';
require './vendor/autoload.php';

require './src/Rah/Vinyl/TagRegistry.php';
require './src/Rah/Vinyl/Config.php';
require './src/Rah/Vinyl/BuildPoolStringAction.php';
require './src/Rah/Vinyl/Client.php';
require './src/Rah/Vinyl/AddHeadersAction.php';
require './src/Functions.php';
require './src/Rah/Vinyl/Main.php';
