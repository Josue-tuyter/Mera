<?php

$projectRoot = dirname(__DIR__);
require $projectRoot . '/vendor/autoload.php';
$app = require_once $projectRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

Schema::dropIfExists('registro_de_atividades');
echo "Tabla registro_de_atividades eliminada.\n";
Schema::dropIfExists('estados');
Schema::dropIfExists('organizacions');
Schema::dropIfExists('materiales_e_insumos');
Schema::dropIfExists('equipos_y_herramientas');
Schema::dropIfExists('registro_actividad_equipo');
Schema::dropIfExists('registro_actividad_material');
echo "Tablas relacionadas eliminadas si existían.\n";
