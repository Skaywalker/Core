<?php

namespace Modules\Main\Class;
use Illuminate\Support\Str;
use Modules\Main\Exceptions\FilePathIsIncorrect;
use Modules\Main\Exceptions\FilePathNotSpecified;
use Modules\Main\Exceptions\ModuleNameNotFound;
use Modules\Main\Exceptions\ModuleNotExist;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;


class ModulesInertiaSource
{
    public function build(string $source): string
    {
        $sourceData = $this->explodeSource($source);
        $moduleName = $this->getModuleName($sourceData[0]);
        $resourcePath = config('modules.paths.source');
        $path = $this->getPath($sourceData[1]);

        return $this->getFullPath($moduleName, $resourcePath, $path);
    }

    /**
     * @throws FilePathIsIncorrect
     */
    private function getFullPath(string $moduleName, string $resourcePath, string $path): string
    {
        $fullPath = module_path($moduleName, $resourcePath . DIRECTORY_SEPARATOR . $path . '.vue');

        if (!File::exists($fullPath)) {
            throw FilePathIsIncorrect::make($fullPath);
        }

        return $moduleName . "::" . $resourcePath . '/' . $path;
    }

    /**
     * @throws FilePathNotSpecified
     */
    private function getPath(string $string): string
    {
        if (blank($string)) {
            throw FilePathNotSpecified::make();
        }

        $path = "";
        $pathSource = $this->explodeString($string);

        foreach ($pathSource as $item) {
            $path .= $item . DIRECTORY_SEPARATOR;
        }

        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    private function explodeString(string $string): array
    {
        if (Str::contains($string, '.vue')) {
            $string = Str::before($string, '.vue');
        }

        return explode(".", $string);
    }

    /**
     * @throws ModuleNotExist
     */
    private function getModuleName(string $moduleName): string
    {
        $moduleName = Str::title($moduleName);

        if (!Module::has($moduleName)) {
            throw ModuleNotExist::make($moduleName);
        }

        return $moduleName;
    }

    /**
     * @throws ModuleNameNotFound
     */
    private function explodeSource(string $source): array
    {
        if (stripos($source, "::", 0) === false) {
            throw ModuleNameNotFound::make();
        }

        return explode("::", $source);
    }
}