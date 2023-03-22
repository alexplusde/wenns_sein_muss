<?php

rex_config::removeNamespace("wenns_sein_muss");

rex_sql::factory()->setQuery('DELETE FROM ' . rex_yform_manager_table::table() . ' where table_name="rex_wenns_sein_muss"');
