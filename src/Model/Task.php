<?php

namespace Model;

use Middleware\IsProtected;

class Task extends ActiveRecord
{
    public $id;
    public $title;
    public $description;
    public $status;

    public static function getTable(): string
    {
        return "tasks";
    }

    public  function setTitle(string $value):string
    {
        return $this->title = IsProtected::isApproved($value);
    }

    public  function setDescription(string $value):string
    {
        return $this->description = IsProtected::isApproved($value);
    }
    public  function setStatus(string $value): string
    {
        return $this->status = IsProtected::isApproved($value);
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
