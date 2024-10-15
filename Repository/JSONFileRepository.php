<?php

class Repository_JSONFileRepository extends Repository_AbstractRepository
{
    public function save(Repository_Persistable $persistableToSave): string
    {
        return json_encode($persistableToSave->toSaveArray());
    }

    public function load(string $filename): array
    {
        return json_decode(file_get_contents($filename), true);
    }
}