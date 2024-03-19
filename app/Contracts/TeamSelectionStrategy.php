<?php


namespace App\Contracts;

interface TeamSelectionStrategy
{
    public function selectTeam(array $requirement): array;
}
