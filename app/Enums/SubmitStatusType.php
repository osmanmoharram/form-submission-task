<?php

namespace App\Enums;

enum SubmitStatusType: string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
}
