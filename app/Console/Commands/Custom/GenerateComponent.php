<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;

use Storage;

class GenerateComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:component {component}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate componet js';

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
        $this->info('start');
        $component = $this->argument('component');

        $commandDisk = Storage::disk('console');
        $publicDisk =  Storage::disk('public');


        $conentComponentService = $commandDisk->get('components/componentService.js');
        $conentComponetController = $commandDisk->get('components/componentController.js');

        //replace component.
        $conentComponentService = str_replace('{component}', $component, $conentComponentService);
        $conentComponetController = str_replace('{component}', $component, $conentComponetController);

        //replace content controller.
        $componentController = ucfirst($component).'Controller';
        $conentComponetController = str_replace('{componentController}', $componentController, $conentComponetController);

        //replace componet resource.
        $componentResource = ucfirst($component).'Resource';
        $conentComponentService = str_replace('{componentResource}', $componentResource, $conentComponentService);

          //replace componet service.
        $componentService = ucfirst($component).'Service';
        $conentComponentService = str_replace('{componentService}', $componentService, $conentComponentService);
         $conentComponetController = str_replace('{componentService}', $componentService, $conentComponetController);

          //replace componet module.
        $componentModule = $component.'Module';
        $conentComponentService = str_replace('{componentModule}', $componentModule, $conentComponentService);
        $conentComponetController = str_replace('{componentModule}', $componentModule, $conentComponetController);
        

        $publicDisk->put('app/components/'.$component.'/'.$component.'Service.js', $conentComponentService);
        $publicDisk->put('app/components/'.$component.'/'.$component.'Controller.js', $conentComponetController);
        $this->info('end');
    }
}
