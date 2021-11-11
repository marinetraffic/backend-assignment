<?php


namespace App\VesselPosition;


use Illuminate\Database\Eloquent\Collection;

class ResponseFormatter
{

    /**
     * @var Collection
     */
    private $data;

    public function __construct(Collection $data){
        $this->data = $data;
    }

    public function format($contentType){
        if( $contentType === 'application/xml' )
        {
            return response()->xml($this->data->toArray(), "vessel");
        }

        if( $contentType === 'text/csv' )
        {
            return response()->csv($this->data->toArray());
        }

        if( $contentType === 'application/vnd.api+json' )
        {
            return response()->json($this->data->toArray())->header('Content-Type', 'application/vnd.api+json');
        }

        if( $contentType === 'application/ld+json' )
        {
            return response()->jsonLd($this->data->toArray())->header('Content-Type', 'application/ld+json');
        }

        if( $contentType === 'application/json' )
        {
            return response()->jsonLd($this->data->toArray())->header('Content-Type', 'application/ld+json');
        }

        //return default
        return  response()->json($this->data->toArray());
    }


}
