<?php

namespace App\Helpers;

use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

class ApiValidation
{
    const CONTENT_TYPE_jSON = "application/json";
    const CONTENT_TYPE_VND_jSON = "application/vnd.api+json";
    const CONTENT_TYPE_CSV = "text/csv";
    const CONTENT_TYPE_XML = "application/xml";

    private VesselTrackingHandler $vesselTrackingHandler;

    #[Pure] public function __construct(VesselTrackingHandler $vesselHandler)
    {
        $this->vesselTrackingHandler = $vesselHandler;
    }

    #[Pure] public function isFormatValid(): bool
    {
        return in_array($this->vesselTrackingHandler->getFormat(), [self::CONTENT_TYPE_CSV, self::CONTENT_TYPE_jSON, self::CONTENT_TYPE_VND_jSON, self::CONTENT_TYPE_XML]);
    }

    #[Pure] public function mmsiExist(): bool
    {
        return !empty($this->vesselTrackingHandler->getMmsi());
    }


    #[Pure] public function isTimeToGreaterThanTimeFrom(): bool
    {
        $timeFrom = $this->vesselTrackingHandler->getFilterTimeFrom();
        $timeTo = $this->vesselTrackingHandler->getFilterTimeTo();

        if(is_null($timeFrom))
            return true;

        return $timeTo>= $timeFrom;
    }

    #[Pure] public function mmsiExistWithoutTimeStamps(): bool
    {
        $timeFrom = $this->vesselTrackingHandler->getFilterTimeFrom();
        $timeTo = $this->vesselTrackingHandler->getFilterTimeTo();

        if (!is_null($timeTo) || !is_null($timeFrom))
            return true;

        return !empty($this->vesselTrackingHandler->getMmsi());
    }

}
