<?php

namespace Google\Cloud\Samples\Firestore;

include 'firestoreTest.php';

class firestoreListenTest extends firestoreTest
{
    // use TestTrait;

    private static $projectId;
    private static $database_id;
    private static $document_path;

    /**
     * @depends testAddData
     */
    public function testListenDocument()
    {
        // self::$projectId = self::requireEnv('FIRESTORE_PROJECT_ID');
        // self::$database_id = self::requireEnv('FIRESTORE_REALTIME_PROJECT_ID');
        self::$projectId = 'the-book-club-337319';
        self::$database_id = 'the-book-club-337319-default-rtdb';
        self::$document_path = 'users';

        $output = $this->runFirestoreSnippet(
            'listen_document',
            array(
                self::$projectId,
                self::$database_id,
                self::$document_path,
            )
        );
        $this->assertStringContainsString('Listening to changes in the document ' . self::$document_path, $output);
    }
}
