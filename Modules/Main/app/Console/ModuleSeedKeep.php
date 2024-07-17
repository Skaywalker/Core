<?php

namespace Modules\Main\Console;

use ErrorException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\BaseCommand;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;
class ModuleSeedKeep extends BaseCommand
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'module:seed-keep {--class} {--database} {--force} {--direction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database seeder from the specified module or from all modules.';

    public function executeAction($name): void
    {
        $module = $this->getModuleModel($name);

        $this->components->task("Seeding <fg=cyan;options=bold>{$module->getName()}</> Module", function () use ($module) {
            try {
                $this->moduleSeed($module);
            } catch (\Error $e) {
                $e = new ErrorException($e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e);
                $this->reportException($e);
                $this->renderException($this->getOutput(), $e);

                return false;
            } catch (\Exception $e) {
                $this->reportException($e);
                $this->renderException($this->getOutput(), $e);

                return false;
            }
        });
    }

    public function getInfo(): ?string
    {
        return 'Seeding module ...';
    }

    /**
     * @throws RuntimeException
     */
    public function getModuleRepository(): RepositoryInterface
    {
        $modules = $this->laravel['modules'];
        if (! $modules instanceof RepositoryInterface) {
            throw new RuntimeException('Module repository not found!');
        }

        return $modules;
    }

    /**
     * @return Module
     *
     * @throws RuntimeException
     */
    public function getModuleByName($name)
    {
        $modules = $this->getModuleRepository();
        if ($modules->has($name) === false) {
            throw new RuntimeException("Module [$name] does not exists.");
        }

        return $modules->find($name);
    }

    /**
     * @return void
     */
    public function moduleSeed(Module $module)
    {
        $seeders = [];
        $name = $module->getName();
        $config = $module->get('migration');

        if (is_array($config) && array_key_exists('seeds', $config)) {
            foreach ((array) $config['seeds'] as $class) {
                if (class_exists($class)) {
                    $seeders[] = $class;
                }
            }
        } else {
            $class = $this->getSeederName($name); //legacy support
            $class = implode('\\', array_map('ucwords', explode('\\', $class)));
            if (class_exists($class)) {
                $seeders[] = $class;
            } else {
                //look at other namespaces
                $classes = $this->getSeederNames($name);
                foreach ($classes as $class) {
                    if (class_exists($class)) {
                        $seeders[] = $class;
                    }
                }
            }
        }

        if (count($seeders) > 0) {
            array_walk($seeders, [$this, 'dbSeed']);
            $this->info("Module [$name] seeded.");
        }
    }

    /**
     * Seed the specified module.
     *
     * @param  string  $className
     */
    protected function dbSeed($className)
    {
        if ($option = $this->option('class')) {
            $params['--class'] = Str::finish(substr($className, 0, strrpos($className, '\\')), '\\').$option;
        } else {
            $params = ['--class' => $className];
        }


        if ($option = $this->option('database')) {
            $params['--database'] = $option;
        }

        if ($option = $this->option('force')) {
            $params['--force'] = $option;
        }
        $this->call('db:seed', $params);
    }

    /**
     * Get master database seeder name for the specified module.
     *
     * @param  string  $name
     * @return string
     */
    public function getSeederName($name)
    {
        $name = Str::studly($name);
        $namespace = $this->laravel['modules']->config('namespace');
        $config = GenerateConfigReader::read('keepSeed');
        $seederPath = str_replace('/', '\\', $config->getPath());
        return $namespace.'\\'.$name.'\\'.$seederPath.'\\'.$name.'DatabaseKeepSeeder';
    }

    /**
     * Get master database seeder name for the specified module under a different namespace than Modules.
     *
     * @param  string  $name
     * @return array $foundModules array containing namespace paths
     */
    public function getSeederNames($name)
    {
        $name = Str::studly($name);

        $seederPath = GenerateConfigReader::read('keepSeed');
        $seederPath = str_replace('/', '\\', $seederPath->getPath());
        $foundModules = [];
        foreach ($this->laravel['modules']->config('scan.paths') as $path) {
            $namespace = array_slice(explode('/', $path), -1)[0];
            $foundModules[] = $namespace.'\\'.$name.'\\'.$seederPath.'\\'.$name.'DatabaseKeepSeeder';
        }

        return $foundModules;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Throwable  $e
     * @return void
     */
    protected function renderException($output, \Exception $e)
    {
        dd($output,$e);
        $this->laravel[ExceptionHandler::class]->renderForConsole($output, $e);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $e
     * @return void
     */
    protected function reportException(\Exception $e)
    {
        dd($e);
        $this->laravel[ExceptionHandler::class]->report($e);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['direction', 'd', InputOption::VALUE_OPTIONAL, 'The direction of ordering.', 'asc'],
            ['class', 'c', InputOption::VALUE_OPTIONAL, 'The class name of the root seeder.'],
            ['database', 'd', InputOption::VALUE_OPTIONAL, 'The database connection to seed.'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}