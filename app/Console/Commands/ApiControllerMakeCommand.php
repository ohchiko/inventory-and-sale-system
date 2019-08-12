<?php

namespace App\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand;

class ApiControllerMakeCommand extends ControllerMakeCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'api:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api controller class';

    /**
     * The type of the class being generated.
     *
     * @var string
     */
    protected $type = "Controller";

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\API\Controllers';
    }
}
