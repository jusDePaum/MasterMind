<?php

interface Repository_Persistable
{
    public function toSaveArray(): array;
    public function fromSaveArray(array $data): void;
}