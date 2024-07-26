<?php

namespace App\Services;

use App\DTOs\FlightImportItemDTO;
use App\Interfaces\FlightDataImportInterface;
use PHPUnit\Logging\Exception;
use PHPUnit\Util\InvalidJsonException;

class FlightDataImportAmadeusService extends FlightDataImportInterface
{
    /**
     * @TODO 1. Add pagination to batch process flights being imported
     */
    public function import(): void
    {
        // Fetch flights json data
        $flightJsonData = file_get_contents(__DIR__ . '../flightData/flightData.json');
        if (!$flightJsonData) {
            throw new Exception('Error whilst reading FileData.json.'); // @TODO create custom exception
        }

        // Decode json data
        $flightData = json_decode($flightJsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException('Error decoding JSON data: ' . json_last_error_msg());
        }

        $this->createOrUpdateDictionaries($flightData);

        if (!empty($flightData['data'])) {
            // Iterate through flightData and insert flight, fees and segments into database
            foreach ($flightData['data'] as $flightItem) {
                $flightItemDTO = new FlightImportItemDTO($flightItem);

                // @TODO check if flight already exists in db and update rather than create new flight
                $flight = Flight::create($flightItemDTO);
                if (!$flight) continue;

                // Fight fees
                if (isset($flightItem['price']['fees'])) {
                    $fees = [];
                    if (!empty($flightItem['price']['fees'])) {
                        foreach ($flightItem['price']['fees'] as $fee) {
                            if (!isset($fee['amount']) && !isset($fee['type'])) continue;

                            // @TODO check if fee already exists in db and update data
                            $fees[] = FlightFee::create([
                                'amount' => $fee['amount'],
                                'type' => $fee['type'],
                            ]);
                        }
                        if (!empty($fees)) {
                            $flight->fees()->saveMany($fees);
                        }
                    }
                }

                if (!empty($flightItem['itineraries'])) {
                    foreach ($flightItem['itineraries'] as $itinerary) {
                        // Fight segments
                        $flightSegments = [];
                        foreach ($itinerary['segments'] as $segment) {

                            // @TODO check if segments already exists in db and update data
                            $flightSegments[] = FlightSegment::create([
                                'depature_time' => $segment['depature']['at'],
                                'arrival_time' => $segment['arrival']['at'],
                                'arrivalLocationCode' => $segment['arrival']['iataCode'],
                                'depatureLocationCode' => $segment['depature']['iataCode'],
                                'duration' => $segment['duration'],
                                'numberOfStops' => $segment['numberOfStops'],
                                'carrierCode' => $segment['carrierCode'],
                                'aircraftCode' => $segment['aircraft']['code']
                            ]);
                        }
                    }
                    if (!empty($flightSegments)) {
                        $flight->segments()->saveMany($flightSegments);
                    }
                }

                $flight->save();
            }
        }
    }

    public function createOrUpdateDictionaries($flightData): void
    {
        // Create or update locations, aircrafts and carriers
        $dictionaries = $flightData['dictionaries'];
        if (!empty($dictionaries)) {
            $locations = $dictionaries['locations'];
            $airCrafts = $dictionaries['aircraft'];
            $carriers = $dictionaries['carriers'];

            foreach ($locations as $code => $location) {
                Location::create([
                    'code' => $code,
                    'country_code' => $location['country_code'],
                    'city_code' => $location['city_code']
                ]);
            }
            foreach ($airCrafts as $code => $name) {
                AirCraft::create([
                    'code' => $code,
                    'name' => $name
                ]);
            }
            foreach ($carriers as $code => $name) {
                Carrier::create([
                    'code' => $code,
                    'name' => $name
                ]);
            }
        }
    }
}
