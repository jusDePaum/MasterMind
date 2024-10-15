<?php


abstract class Repository_AbstractRepository
{
    abstract public function save(Repository_Persistable $persistableToSave);
    abstract public function load(string $filename);
}