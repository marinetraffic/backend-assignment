<?php


namespace App\Utilities;


class ParamsResolver
{

    /**
     * @param array $requestParams
     * @return array
     */
    public static function resolve(array $requestParams): array{

        foreach ($requestParams as $name => $value){

            //param multiple values
            if (strpos($value, ",") !== false){
                $requestParams[$name] = explode(",", $value);
            }

            if (strpos($value, "[and]") !== false){
                $range = explode("[and]", $value);
                $resolvedRange = [];
                foreach ($range as $id => $rangeItem){
                    //param passed as min and max range
                    if (strpos($rangeItem, "gt:") !== false){
                        $resolvedRange["min"] = str_replace("gt:", "", $rangeItem );
                    }
                    if (strpos($rangeItem, "lt:") !== false){
                        $resolvedRange["max"] = str_replace("lt:", "", $rangeItem );
                    }
                }
                $requestParams[$name] = $resolvedRange;
            }
        }
        return $requestParams;

    }

}
