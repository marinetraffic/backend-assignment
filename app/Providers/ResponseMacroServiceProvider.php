<?php


namespace App\Providers;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Spatie\ArrayToXml\ArrayToXml;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('xml', function (array $data, $nodeName = "item") {
            $header['Content-Type'] = 'application/xml';
            $content = ArrayToXml::convert([$nodeName => $data]);
            return Response::make($content, 200, $header);
        });
    }
}
