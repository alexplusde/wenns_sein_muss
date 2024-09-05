<?php

namespace Alexplusde\Wsm;

use rex;
use rex_sql;

include __DIR__ . '/install.php';

rex_sql::factory()->setQuery('UPDATE `' . rex::getTable('wenns_sein_muss_service') . '` SET status = 1 WHERE status = ""')->execute();
