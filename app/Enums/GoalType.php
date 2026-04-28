<?php

namespace App\Enums;

enum GoalType: string
{
    case FatLoss = 'fat_loss';
    case MuscleRetention = 'muscle_retention';
    case Maintenance = 'maintenance';
    case Recomposition = 'recomposition';
}
