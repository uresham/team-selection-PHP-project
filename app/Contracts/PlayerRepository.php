<?php


namespace App\Contracts;

interface PlayerRepository
{
    public function findByPositionAndSkill($position, $skill): array;
    public function findByPosition($position): array;
}
