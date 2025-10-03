<?php

namespace App\Enums;

enum GoodsReceivedNoteStatus: string
{
    case PENDING_APPROVAL = 'Pending Approval';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';
}
