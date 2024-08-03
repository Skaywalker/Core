<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Admin\Class\AdminRouter;
use Modules\Main\Class\BcmsRouterFile;
use Modules\Main\Class\BcmsRouterTypes;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tighten\Ziggy\Output\File;
use Tighten\Ziggy\Output\Types;
use Tighten\Ziggy\Ziggy;

//Kiskuta
class BCMSAdminRouteGenerate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bcms:admin-route-generate
                            {path? : Path to the generated JavaScript file. Default: `resources/js/ziggy.js`.}
                            {--types : Generate a TypeScript declaration file.}
                            {--types-only : Generate only a TypeScript declaration file.}
                            {--url=}
                            {--group=}';

    protected $description = 'Generate a JavaScript file containing Ziggy’s routes and configuration.';

    public function handle(Filesystem $filesystem)
    {
        $ziggy = new AdminRouter($this->option('group'), $this->option('url') ? url($this->option('url')) : null);

        $path = $this->argument('path') ?? config('ziggy.output.path', module_path('Admin','resources/assets/js/Plugins/adminRoutes.js'));
        if ($filesystem->isDirectory(base_path($path))) {
            $path .= '/ziggy';
        } else {

            $filesystem->ensureDirectoryExists(dirname($path), recursive: true);
        }

        $name = preg_replace('/(\.d)?\.ts$|\.js$/', '', $path);
        if (! $this->option('types-only')) {
            $output = config('ziggy.output.file', BcmsRouterFile::class);
            $filesystem->put("{$name}.js", new $output($ziggy));
        }

        if ($this->option('types') || $this->option('types-only')) {
            $types = config('ziggy.output.types', BcmsRouterTypes::class);

            $filesystem->put("{$name}.d.ts", new $types($ziggy));
        }

        $this->info('Files generated!');
    }
}
