<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\Make\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\CanClearModulesCache;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeSeedKeep extends GeneratorCommand
{
    use CanClearModulesCache;
    use ModuleCommandTrait;
    protected $argumentName = 'name';
    protected string $argumentTableName = 'tableName';

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'module:make-seeder-keep {name} {tableName} {module?}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new keep seeder file for a specified table';
    /**
     * Create a new command instance.
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of seeder will be created.'],
            ['tableName', InputArgument::REQUIRED, 'The name of the table to be seeded.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }


    protected function getTemplateContents(): mixed
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/keep-seeder.stub', [
            'NAME' => $this->getSeederName(),
            'MODULE' => $this->getModuleName(),
            'TABLE'=> $this->getTableName(),
            'NAMESPACE' => $this->getClassNamespace($module),

        ]))->render();
    }

    protected function getDestinationFilePath(): mixed
    {
        $this->clearCache();

        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $seederPath = GenerateConfigReader::read('keepSeed');

        return $path.$seederPath->getPath().'/'.$this->getSeederName().'.php';
    }

    /**
     * Get the seeder name.
     */
    private function getSeederName(): string
    {
        $string = $this->argument('name');
        $suffix = 'KeepSeeder';

        if (strpos($string, $suffix) === false) {
            $string .= $suffix;
        }

        return Str::studly($string);
    }
    private function getTableName()
    {
        $string = $this->argument('tableName');
        return Str::snake($string);
    }

    /**
     * Get default namespace.
     */
    public function getDefaultNamespace(): string
    {
        return config('modules.paths.generator.keepSeed.namespace')
            ?? ltrim(config('modules.paths.generator.keepSeed.path', 'Database/KeepSeeders'), config('modules.paths.app_folder', ''));
    }
}
