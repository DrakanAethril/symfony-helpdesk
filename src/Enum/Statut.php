<?php

namespace App\Enum;

enum Statut: string
{
    case Nouveau = 'nouveau';
    case EnCours = 'en_cours';
    case Resolu = 'resolu';
    case Ferme = 'ferme';
}
