<?php
/**
 * Copyright 2022 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/firestore/README.md
 */

namespace Google\Cloud\Samples\Firestore;

use Google\Cloud\Firestore\V1\ListenRequest;
use Google\Cloud\Firestore\V1\Target;

/**
 * Set document data by merging it into the existing document.
 *
 * @param string $project_id The project id in GCP
 * @param string $database_id The firestore realtime db in GCP
 */
function listen_document(string $project_id, string $database_id, string $document_path): void
{
    // Create a firestore listen request
    $cityRef = new ListenRequest(`projects/${project_id}/databases/${database_id}`);
    # [START firestore_listen_document]
    $target = new Target("projects/${project_id}/databases/${database_id}/documents/${document_path}");

    $cityRef->setAddTarget($target);
    $cityRef = $cityRef->getTargetChange();
    # [END firestore_listen_document]
    printf('Set document data by merging it into the existing BJ document in the cities collection.' . PHP_EOL);
}

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
