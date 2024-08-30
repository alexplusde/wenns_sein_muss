<?php

namespace Alexplusde\Wsm;

include __DIR__ . '/install.php';

\rex_sql::factory()->setQuery('UPDATE `' . \rex::getTable('wenns_sein_muss_service') . '` SET status = 1 WHERE status = ""')->execute();
