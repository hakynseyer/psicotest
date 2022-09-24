<?php
require_once __DIR__ . '/vendor/autoload.php';

# Autoloader de mi aplicación
spl_autoload_register(function ($namespace) {
  $name = strtolower(str_replace('\\', '/', $namespace));

  if (preg_match('/^backend.*$/', $name)) {
    require_once "{$name}.php";
  }
});

// Aqui arranca el core de Arlequin
Arlequin\Route\Route::init();
