<?php

namespace App\Console\Commands\Pages;

use Illuminate\Console\Command;

class CreateSearchPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @author Minh than <than@httsolution.com>
     * 
     * 
     * command  php artisan cms:create_search_page
     * 
     * @var string
     */
    protected $signature = 'cms:create_search_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create search page';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start create search page ...');
        
        $indexs = [env('es_index', 'pages_dev'), env('es_index_demo', 'pages_dev_demo')];

        foreach ($indexs as $key => $index) {
            
            if(!\RES::indices()->exists(['index' => $index])) {

                $params = [
                    'index' => $index, // index mean schema like mysql
                    'body' => [
                        'settings' => [
                            'number_of_shards' => 3,
                            'number_of_replicas' => 1,
                            'analysis'=> [
                                'analyzer'=> [
                                    "content" => [
                                        "type" => "custom",
                                        "tokenizer" => "standard",
                                        "filter" => ['lowercase', 'stop', 'kstem'],
                                        "char_filters" => ['html_strip']
                                    ]
                                ]
                            ]
                        ],

                    ]
                ];

                \RES::indices()->create($params);

                $data = [
                    'index' => $index,
                    'type' => 'page',
                    'body' => [
                        'page' => [
                            '_source' => [
                                'enabled' => true
                            ],
                            'properties' => [
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true,
                                ],
                                'description' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true
                                ],
                                'language' => [
                                    'type' => 'string',
                                    'include_in_all' => false,
                                    'index' => 'not_analyzed'
                                    // we are setting index to no_analyzed. This means we are asking Elasticsearch not to analyze the string
                                    // this is required to do aggregation effectively
                                ],
                                'region' => [
                                    'type' => 'string',
                                    'include_in_all' => false,
                                    'index' => 'not_analyzed'
                                ],
                                'url' => [
                                    'type' => 'string',
                                    'include_in_all' => false,
                                    'index' => 'no'
                                    // we are setting index to no. This means that this field is not searchable but retrivable
                                ],
                                'html' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true,
           
                                ]

                            ]
                        ]
                    ]
                ];

                // Update the index mapping
                \RES::indices()->putMapping($data);
                
                $params = [
                    'index' => $index,
                    'type' => 'page_suggestion',
                    'body' => [
                        'page_suggestion' => [
                            'properties' => [
                                'name' => [
                                    'type' => 'string'
                                ], 
                                'suggest' => [
                                    "type" => 'completion',
                                    'index_analyzer' => 'simple',
                                    'search_analyzer' => 'simple',
                                    'payloads' => true,
                                ]
                            ]
                        ]
                    ]
                ];

                // Update the index mapping
                \RES::indices()->putMapping($params);

                // $params = [
                //     'index' => $index,
                //     'type' => 'document',
                //     'body' => [
                //         'document' => [
                //             'properties' => [
                //                 'content' => [
                //                     'type' => 'attachment',
                //                 ],
                //                 'url' => [
                //                     'type' => 'string',
                //                     'include_in_all' => false,
                //                     'index' => 'no',

                //                 ],
                //                 'name' => [
                //                     'type' => 'string',
                //                     'analyzer' => 'content',
                //                     'include_in_all' => true,
                //                 ],
                //                 'filename' => [
                //                     'type' => 'string',
                //                 ],
                //                 'description' => [
                //                     'type' => 'string',
                //                     'analyzer' => 'content',
                //                     'include_in_all' => true,
                //                 ],
                //                 'type' => [
                //                     'type' => 'string',
                //                     'include_in_all' => false,
                //                     'index' => 'no',

                //                 ],

                //             ]
                //         ]
                //     ]
                // ];

                // \RES::indices()->putMapping($params);

                $params = [
                    'index' => $index,
                    'type' => 'image',
                    'body' => [
                        'image' => [
                            '_source' => [
                                'enabled' => true
                            ],
                            'properties' => [
                               'name' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true,
                                ],
                                'filename' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true,
                                ],
                                'description' => [
                                    'type' => 'string',
                                    'analyzer' => 'content',
                                    'include_in_all' => true
                                ],
                                'url_page' => [
                                    'type' => 'string',
                                    'include_in_all' => false,
                                    'index' => 'no'
                                    // we are setting index to no. This means that this field is not searchable but retrivable
                                ],
                                'url_image' => [
                                    'type' => 'string',
                                    'include_in_all' => false,
                                    'index' => 'no'
                                    // we are setting index to no. This means that this field is not searchable but retrivable
                                ],
                            ]
                        ]
                    ]
                ];  

                \RES::indices()->putMapping($params);             
     
            }
        }

        $this->info('Success!');
    }
}
