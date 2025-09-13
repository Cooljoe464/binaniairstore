<?php

namespace App\Enums;

enum Status: string
{
    case Serviceable = 'serviceable';
    case Unserviceable = 'unserviceable';
    case Quarantined = 'quarantined';
    case Expired = 'expired';
}
