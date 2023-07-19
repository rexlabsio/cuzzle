<?php

namespace Tests\Support;

use Psr\Log\AbstractLogger;

/**
 * Used for testing purposes.
 *
 * It records all records and gives you access to them for verification.
 *
 */
class TestLogger extends AbstractLogger
{
    /**
     * @var array
     */
    public $records = [];

    public $recordsByLevel = [];

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = []): void
    {
        $record = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
        ];

        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
    }

    public function hasRecordThatContains($message, $level)
    {
        if (!isset($this->recordsByLevel[$level])) {
            return false;
        }
        foreach ($this->recordsByLevel[$level] as $rec) {
            if (strpos($rec['message'], $message) !== false) {
                return true;
            }
        }
        return false;
    }
}
