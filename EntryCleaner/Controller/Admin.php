<?php

namespace EntryCleaner\Controller;


use MongoHybrid\Client;
use MongoLite\Collection;
use MongoLite\Cursor;

class Admin extends \Cockpit\AuthController
{
    public function index()
    {
        $client = $this->app->storage;
        $entries = [];

        foreach ($this->app->module('collections')->collections(true) as $collection) {
            $name = $collection['name'];
            /** @var Cursor $cursor */
            $cursor = $this->app->module('collections')->entries($name)->find();

            $collectionFieldNames = $this->getCollectionFields($collection);

            while ($cursor->valid()) {
                $toRemove = $this->findFieldsToRemove($cursor->current(), $collectionFieldNames);

                if (!empty($toRemove)) {
                    $cleanedEntry = $cursor->current();
                    $entries[] = ['collection' => $name, 'entryId' => $cleanedEntry['_id']];

                    foreach ($toRemove as $remove) {
                        unset($cleanedEntry[$remove]);
                    }

                    $client->__call('getCollection', ['test', 'collections'])->update(
                        ['_id' => $cleanedEntry['_id']],
                        $cleanedEntry,
                        false
                    );
                }

                $cursor->next();
            }
        }

        return $this->render(__DIR__ . '/../views/index.php', ['entries' => $entries]);
    }

    private function getCollectionFields(array $collection): array
    {
        $collectionFieldNames = [];

        foreach ($collection['fields'] as $field) {
            $collectionFieldNames[] = $field['name'];
        }

        return $collectionFieldNames;
    }

    private function findFieldsToRemove(array $fields, array $collectionFieldNames): array
    {
        $toRemove = [];

        foreach ($fields as $fieldKey => $fieldVal) {
            if (
                !(substr($fieldKey, 0, 1) === '_')
                && !in_array($fieldKey, $collectionFieldNames, true)
            ) {
                $toRemove[] = $fieldKey;
            }
        }

        return $toRemove;
    }
}
