<?php

namespace App\Services;

use App\DTOs\FlightImportItemDTO;
use App\Interfaces\FlightDataImportInterface;
use App\Models\AirCraft;
use App\Models\Carrier;
use App\Models\Flight;
use App\Models\FlightFee;
use App\Models\FlightSegment;
use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JsonException;

class FlightDataImportAmadeusService extends FlightDataImportInterface
{
    protected $locations;
    protected $airCrafts;
    protected $carriers;

    /**
     * @TODO 1. Add pagination to batch process flights being imported
     * @throws Exception
     */
    public function import(): void
    {
        // Fetch flights json data
        $flightJsonData = file_get_contents(base_path('flightData/flightData.json'));
        if (!$flightJsonData) {
            throw new Exception('Error whilst reading FileData.json.'); // @TODO create custom exception
        }

        // Decode json data
        $flightData = json_decode($flightJsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException('Error decoding JSON data: ' . json_last_error_msg());
        }

        $this->createOrUpdateDictionaries($flightData);
        $this->fetchDictionaryIds();

        if (!empty($flightData['data'])) {
            // Iterate through flightData and insert flight, fees and segments into database
            foreach ($flightData['data'] as $flightItem) {

                DB::beginTransaction();

                try {
                    $flightItemDTO = new FlightImportItemDTO($flightItem);
                    $flight = Flight::updateOrCreate(
                        ['external_id' => $flightItem['id']],
                        $flightItemDTO->toArray()
                    );

                    if (!$flight) {
                        throw new Exception('Error when creating flight or updating flight.');
                    }

                    // Fight fees
                    if (!empty($flightItem['price']['fees'])) {
                        foreach ($flightItem['price']['fees'] as $fee) {
                            if (!isset($fee['amount']) && !isset($fee['type'])) continue;
                            FlightFee::updateOrCreate(
                                [
                                    'flight_id' => $flight->uuid,
                                    'amount' => $fee['amount'],
                                    'type' => $fee['type'],
                                ],
                            );
                        }
                    }

                    // Fight segments
                    if (!empty($flightItem['itineraries'])) {
                        foreach ($flightItem['itineraries'] as $itinerary) {
                            foreach ($itinerary['segments'] as $segment) {
                                FlightSegment::updateOrCreate(
                                    [
                                        'external_id' => $segment['id'],
                                        'flight_id' => $flight->uuid,
                                    ],
                                    [
                                    'departure_time' => $segment['departure']['at'],
                                    'arrival_time' => $segment['arrival']['at'],
                                    'departure_location_id' => $this->locations[$segment['departure']['iataCode']] ?? null,
                                    'arrival_location_id' => $this->locations[$segment['arrival']['iataCode']] ?? null,
                                    'duration' => $segment['duration'],
                                    'number_of_stops' => $segment['numberOfStops'],
                                    'carrier_id' => $this->carriers[$segment['carrierCode']] ?? null,
                                    'aircraft_id' => $this->airCrafts[$segment['aircraft']['code']] ?? null
                                ]);
                            }
                        }
                    }

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
        }
    }

    public function createOrUpdateDictionaries($flightData): void
    {
        // Create or update locations, air-crafts and carriers
        $dictionaries = $flightData['dictionaries'];
        if (!empty($dictionaries)) {
            $locationData = [];
            $airCraftsData = [];
            $carriersData = [];

            if (!empty($dictionaries['locations'])) {
                foreach ($dictionaries['locations'] as $code => $location) {
                    $locationData[] = [
                        'code' => $code,
                        'country_code' => $location['countryCode'],
                        'city_code' => $location['cityCode']
                    ];
                }
                Location::upsert($locationData, uniqueBy: ['code']);
            }

            if (!empty($dictionaries['aircraft'])) {
                foreach ($dictionaries['aircraft'] as $code => $name) {
                    $airCraftsData[] = [
                        'code' => $code,
                        'name' => $name
                    ];
                }
                AirCraft::upsert($airCraftsData, uniqueBy: ['code']);
            }

            if (!empty($dictionaries['carriers'])) {
                foreach ($dictionaries['carriers'] as $code => $name) {
                    $carriersData[] = [
                        'code' => $code,
                        'name' => $name
                    ];
                }
                Carrier::upsert($carriersData, uniqueBy: ['code']);
            }
        }
    }

    protected function fetchDictionaryIds(): void
    {
        $this->locations = Location::pluck('id', 'code')->toArray();
        $this->airCrafts = AirCraft::pluck('id', 'code')->toArray();
        $this->carriers = Carrier::pluck('id', 'code')->toArray();
    }
}
