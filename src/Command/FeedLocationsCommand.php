<?php

namespace App\Command;

use DateTime;
use DateTimeInterface;
use Elasticsearch\Client;
use Nelmio\Alice\Definition\Flag\OptionalFlag;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Uuid;

class FeedLocationsCommand extends Command
{
    protected static $defaultName = 'app:feed-locations';
    /**
     * @var Client
     */
    private $client;

    /**
     * @var boolean
     */
    private bool $dryRun = false;

    /**
     * @var array
     */
    private $indexDefinition;

    /** bool */
    private $recreateIndex;

    /**
     * FeedProductsCommand constructor.
     * @param Client $client
     * @param string $productFilePath
     * @param array $indexDefinition
     */
    public function __construct(Client $client, string $indexDefinition)
    {
        $this->client = $client;
        $this->indexDefinition = $indexDefinition;
        parent::__construct(null);
    }
    /**
     * Command configuration setup.
     */
    protected function configure()
    {
        $this->setDescription('Feed Locations to Elasticsearch');
        $this->addArgument('json-file', InputArgument::REQUIRED, 'File to be injected into ES');
        $this->addOption('dry-run', 'r' ,InputOption::VALUE_NONE,'How many records to be added');
        $this->addOption('recreate-index', 'i',InputOption::VALUE_NONE,'Recreate the index');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->recreateIndex = $input->getOption('recreate-index');
        $this->dryRun = $input->getOption('dry-run');
        $this->locationFilePath = $input->getArgument('json-file');
        $io = new SymfonyStyle($input, $output);
        
        if ($this->recreateIndex == 1) {
            $io->note('CREATING INDEX [' .  $this->indexDefinition . ']');
            $this->createIndex();
        }

        $io->note('FEEDING INDEX....');
        $this->feedData($io);

        $io->success('FEEDING DONE');

        return Command::SUCCESS;
    }

    /**
     * Parse csv and feed the data to Elasticsearch.
     */
    private function feedData(SymfonyStyle $io): void
    {
        $locationsFile = json_decode(file_get_contents($this->locationFilePath));
        $io->progressStart(count($locationsFile));

        
        foreach ($locationsFile as $key => $location) {
            $uuid4 = Uuid::v4();
            $doc = array_merge(
                ['index' => $this->indexDefinition],
                [
                    'id' => $uuid4->toRfc4122(),
                    'body' => [
                        'mmsi' => (int)$location->mmsi,
                        'status' => (int)$location->status,
                        'stationId' => (int)$location->stationId,
                        'speed' => (int)$location->speed,
                        'geolocation' => ['lon' => (float)$location->lon, 'lat' => (float)$location->lat],
                        'course' => (int)$location->course,
                        'heading' => (int)$location->heading,
                        'rot' => (float)$location->rot,
                        'timestamp' => (int)$location->timestamp
                    ]
                ]
            );

            if ($this->dryRun != 1) {
                $this->client->index($doc);
            }

            $io->progressAdvance();
        }
        $io->progressFinish();
    }

    /**
     * Creates index with mapping and analyzer.
     */
    private function createIndex(): void
    {
        if ($this->client->indices()->exists(['index' => $this->indexDefinition])) {
            $this->client->indices()->delete(['index' => $this->indexDefinition]);
        }

        $params = [
            'index' => $this->indexDefinition,
            'body' => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => [
                    'mmsi' => [
                        'type' => 'integer'
                    ],
                    'status' => [
                        'type' => 'byte'
                    ],
                    'stationId' => [
                        'type' => 'integer'
                    ],
                    'speed' => [
                        'type' => 'integer'
                    ],
                    'course' => [
                        'type' => 'integer'
                    ],
                    'heading' => [
                        'type' => 'integer'
                    ],
                    'rot' => [
                        'type' => 'float'
                    ],
                    'timestamp' => [
                        'type' => 'date',
                        'format' => 'epoch_second'

                    ],
                    'geolocation' => [
                        'type' => 'geo_point'
                    ],
                ]
            ]
        ];

        $area = [
            "id" => 'polygonize_circles',
            'body' => [
                "description" => "translate circle to polygon",
                "processors" => [
                    [
                        "circle" => [
                            "field" => "circle",
                            "error_distance" => 28.0,
                            "shape_type" => "geo_shape"
                        ]
                    ]
                ]
            ]
        ];


        $this->client->ingest()->putPipeline($area);
        $this->client->indices()->create(['index' => $this->indexDefinition]);
        $this->client->indices()->putMapping($params);
    }
}
