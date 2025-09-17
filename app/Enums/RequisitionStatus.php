<?php

namespace App\Enums;

enum RequisitionStatus: string
{
    case PENDING_APPROVAL = 'Pending Approval';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
    case DISBURSED = 'Disbursed';
}
