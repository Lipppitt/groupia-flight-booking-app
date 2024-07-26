<?php

namespace App\DTOs;

class FlightImportItemDTO
{
    public string $type;
    public string $source;
    public bool $instantTicketingRequired;
    public bool $nonHomogeneous;
    public bool $oneWay;
    public string $lastTicketingDate;
    public string $lastTicketingDateTime;
    public string $numberOfBookableSeats;
    public string $currency;
    public string $total;
    public string $base;

    public function __construct(array $flightData)
    {
        $this->type                     = $flightData['type'];
        $this->source                   = $flightData['source'];
        $this->instantTicketingRequired = $flightData['instantTicketingRequired'];
        $this->nonHomogeneous           = $flightData['nonHomogeneous'];
        $this->oneWay                   = $flightData['oneWay'];
        $this->lastTicketingDate        = $flightData['lastTicketingDate'];
        $this->lastTicketingDateTime    = $flightData['lastTicketingDateTime'];
        $this->numberOfBookableSeats    = $flightData['numberOfBookableSeats'];
        $this->currency                 = $flightData['price']['currency'];
        $this->total                    = $flightData['price']['total'];
        $this->base                     = $flightData['price']['base'];
    }
}
