<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ResourceMakeCommand;

class ApiResourceMakeCommand extends ResourceMakeCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'api:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api resource class';

    /**
     * The type of the class being generated.
     *
     * @var string
     */
    protected $type = "Resource";

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\API\Resources';
    }
}
