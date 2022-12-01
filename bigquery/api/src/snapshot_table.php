<?php
/**
 * Copyright 2022 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/bigquery/api/README.md
 */

namespace Google\Cloud\Samples\BigQuery;

# [START bigquery_snapshot_table]
use Google\Cloud\BigQuery\BigQueryClient;

/**
 * Create snapshot of the contents of table from source table to destination table.
 *
 * @param string $projectId The project Id of your Google Cloud Project.
 * @param string $datasetId The BigQuery dataset ID.
 * @param string $sourceTableId Source tableId in dataset.
 * @param string $destinationTableId Destination tableId in dataset.
 */
function snapshot_table(
    string $projectId,
    string $datasetId,
    string $sourceTableId,
    string $destinationTableId
): void {
    $bigQuery = new BigQueryClient([
      'projectId' => $projectId,
    ]);
    $dataset = $bigQuery->dataset($datasetId);
    $sourceTable = $dataset->table($sourceTableId);
    $destinationTable = $dataset->table($destinationTableId);
    $copyConfig = $sourceTable->copy($destinationTable, [
        'configuration' => [
            'copy' => ['operationType' => 'SNAPSHOT']
        ]
    ]);
    $job = $sourceTable->runJob($copyConfig);

    // check if the job is complete
    $job->reload();
    if (!$job->isComplete()) {
        throw new \Exception('Job has not yet completed', 500);
    }
    // check if the job has errors
    if (isset($job->info()['status']['errorResult'])) {
        $error = $job->info()['status']['errorResult']['message'];
        printf('Error running job: %s' . PHP_EOL, $error);
    } else {
        print('Snapshot created successfully' . PHP_EOL);
        print_r($destinationTable->reload());
    }
}
# [END bigquery_snapshot_table]
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
