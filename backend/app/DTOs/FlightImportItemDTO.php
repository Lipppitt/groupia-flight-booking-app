<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Log;

class FlightImportItemDTO
{
    public string $type;
    public int $external_id;
    public string $source;
    public bool $instantTicketingRequired;
    public bool $nonHomogeneous;
    public bool $oneWay;
    public string $lastTicketingDate;
    public string $duration;
    public string $numberOfBookableSeats;
    public string $currency;
    public string $total_price;
    public string $base_price;

    public function __construct(array $flightData)
    {
        Log::info(print_r($flightData, true));

        $this->type                     = $flightData['type'];
        $this->external_id              = $flightData['id'];
        $this->source                   = $flightData['source'];
        $this->instantTicketingRequired = $flightData['instantTicketingRequired'];
        $this->nonHomogeneous           = $flightData['nonHomogeneous'];
        $this->oneWay                   = $flightData['oneWay'];
        $this->lastTicketingDate        = $flightData['lastTicketingDate'];
        $this->numberOfBookableSeats    = $flightData['numberOfBookableSeats'];
        $this->currency                 = $flightData['price']['currency'];
        $this->total_price              = $flightData['price']['total'];
        $this->base_price               = $flightData['price']['base'];
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'external_id' => $this->external_id,
            'source' => $this->source,
            'instant_ticketing_required' => $this->instantTicketingRequired,
            'non_homogeneous' => $this->nonHomogeneous,
            'one_way' => $this->oneWay,
            'last_ticketing_date' => $this->lastTicketingDate,
            'number_of_bookable_seats' => $this->numberOfBookableSeats,
            'currency' => $this->currency,
            'total_price' => $this->total_price,
            'base_price' => $this->base_price,
        ];
    }
}
