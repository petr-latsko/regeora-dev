<?php

namespace App\Providers;

use App\Services\Interfaces\SourceParser;
use App\Services\XmlParserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SourceParser::class,
            XmlParserService::class
        );

        $this->app->bind(XmlParserService::class, function ($app) {
            return new XmlParserService(
                $app->storagePath(
                    str_finish(env('XML_SOURCE_PATH'), '/') . env('XML_SOURCE_FILE')
                )
            );
        });
    }
}
