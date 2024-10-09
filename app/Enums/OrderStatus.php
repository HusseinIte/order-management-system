<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Waiting = 'Waiting';
    case In_Progress = 'In Progress';
    case Completed = 'Completed';
}
