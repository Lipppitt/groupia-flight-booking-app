<?php

namespace App\Enums;

enum FlightBookingStatus: string
{
	case Pending = 'pending';
	case Completed = 'completed';
	case Cancelled = 'cancelled';
}

