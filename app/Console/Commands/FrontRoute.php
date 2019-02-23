<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Route;
use Illuminate\Filesystem\Filesystem;


class FrontRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:home:route:js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成route.js';

    protected $filesystem;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->generateRoutes();
    }

    protected function generateRoutes()
    {
        $routes = Route::getRoutes();

        $map = [];
        foreach ($routes as $route) {
            if (!$route->getName()) {
                continue;
            }
            if(!str_contains($route->getName(),'api.home')) continue;

            $map[$route->getName()] = ltrim($route->uri(), '/');
        }

        $this->writeJsFile('route', $map);
    }


    protected function writeJsFile($filename, $data)
    {
        $this->isDirectory($path = resource_path('js'));
        $path = resource_path(sprintf('js/%s.js', $filename));
        $content = sprintf('module.exports = %s;', json_encode($data));
        file_put_contents($path, $content);
    }

    public function isDirectory($path)
    {
        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }
    }
}
