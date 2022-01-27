<?php
namespace Orm;

require_once("ActiveRecord.php");
require_once("AssertNumeric.php");

final class DownloadLog extends ActiveRecord
{
    use AssertNumeric;

    /* @var int */
    private $fileId;

    /* @var int */
    private $userId;

    public function isModified(): bool {
        return $this->isModified;
    }

    public static function create(): DownloadLog {
        return new DownloadLog();
    }

    public function setFileId(int $fileId): ActiveRecord {
        $this->assertValueIsNumeric($fileId);
        $this->fileId = $fileId;
        $this->isModified = true;
        return $this;
    }

    public function getFileId(): int {
        return $this->fileId;
    }

    public function setUserId(int $userId): ActiveRecord {
        $this->assertValueIsNumeric($userId);
        $this->userId = $userId;
        $this->isModified = true;
        return $this;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function __destruct()
    {
        echo "Destroying DownloadLog";
    }
}
