<?php

use Google\Cloud\BigQuery\BigQueryClient;

require __DIR__ . '\config\info.php';

$bigQuery = new BigQueryClient([
    'projectId' => RSM_PROJECT_ID
]);