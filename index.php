<?php
declare(strict_types=1);

// index.php
session_start();
spl_autoload_register();
header('Location: MainController.php?action=index');
exit();
