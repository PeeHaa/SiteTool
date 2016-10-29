<?php

namespace SiteTool;


use Auryn\Injector;
use SiteTool\ResultWriter;
use SiteTool\ErrorWriter;
use SiteTool\StatusWriter;
use Zend\EventManager\EventManager;

class Crawler
{
    public function run(
        Injector $injector,
        CrawlerConfig $crawlerConfig,
        EventManager $eventManager,
        StatusWriter $statusWriter
    ) {
        $plugins = [
            Rules::class,
            SiteChecker::class,
            ResponseParser::class,
            SkippingStatusWriter::class
        ];

        $pluginInstances = [];
        foreach ($plugins as $plugin) {
            $pluginInstances[] = $injector->make($plugin);
        }

        $firstUrlToCheck = new URLToCheck('http://' . $crawlerConfig->domainName . $crawlerConfig->path, '/');
        $eventManager->trigger(SiteChecker::FOUND_URL_TO_FOLLOW, null, [$firstUrlToCheck]);
        
        $fn = function() {
            echo "Start.";
        };

        \Amp\run($fn);
        $statusWriter->write("fin.");
    }
}
