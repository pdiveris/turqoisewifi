<?php

namespace App;

class InMemoryPersistence implements Persistence
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var int
     */
    private $lastId = 0;

    /**
     * Generate an Id
     *
     * @return int
     */
    public function generateId(): int
    {
        $this->lastId++;

        return $this->lastId;
    }

    /**
     * Store in persistence layer (memory in ths instance)
     *
     * @param array $data
     */
    public function persist(array $data)
    {
        $this->data[$this->lastId] = $data;
    }

    /**
     * Retrieve by Id
     *
     * @param int $id
     * @return array
     */
    public function retrieve(int $id): array
    {
        if (!isset($this->data[$id])) {
            throw new \OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }

        return $this->data[$id];
    }

    /**
     * Delete by Id
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        if (!isset($this->data[$id])) {
            throw new \OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }

        unset($this->data[$id]);
    }

    /**
     * All entries
     *
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
