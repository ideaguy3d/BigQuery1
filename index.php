<?php
/**
 * Created by PhpStorm.
 * User: julius
 * Date: 9/10/2018
 * Time: 6:49 PM
 */

use Google\Cloud\BigQuery\BigQueryClient;

require __DIR__ . '\vendor\autoload.php';
require __DIR__ . '\config\info.php';

echo "hello world"; 

$bigQuery = new BigQueryClient([
    'projectId' => $argv[1]
]);

$q = <<<NinjaSQL
SELECT CONCAT(
      'https://stackoverflow.com/questions/',
      CAST(id AS STRING)
    ) AS url,
    view_count
FROM `bigquery-public-data.stackoverflow.posts_questions`
WHERE tags LIKE '%google-bigquery%'
ORDER BY view_count DESC
LIMIT 10
NinjaSQL;

$qJobConfig = $bigQuery->query($q);
$qResults = $bigQuery->runQuery($qJobConfig);

if($qResults->isComplete()) {
    $i = 0;
    $rows = $qResults->rows();
    foreach($rows as $row) {
        echo "\njha - next row:\n";
        printf('- ROW: %s', PHP_EOL, ++$i);
        printf('url: %s, views: $s', PHP_EOL, $row['url'], $row['view_count']);
    }
    printf('TOTAL ROWS: %s', PHP_EOL, $i);
} else {
    throw new Exception('ERROR - query failed');
}



echo RSM_PROJECT_ID . " query complete.";