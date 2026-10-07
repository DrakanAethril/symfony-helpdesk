<?php

namespace App\Enum;

enum Priorite: string
{
    case Basse = 'basse';
    case Normale = 'normale';
    case Haute = 'haute';
    case Critique = 'critique';
}
