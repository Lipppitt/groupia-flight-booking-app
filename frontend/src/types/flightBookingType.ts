import {FLIGHT_BOOKING_STATUS} from "@/utils/constants";

type StatusKeys = keyof typeof FLIGHT_BOOKING_STATUS;

export type FlightBookingType = {
    uuid: string;
    status: StatusKeys;
    departs: {
        city_code: string;
    };
    arrives: {
        city_code: string;
    }
};


