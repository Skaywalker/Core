<?php

namespace Modules\Main\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Translation\Translator;
use Illuminate\View\Component;
use Illuminate\View\View;;

class Trans extends Component
{

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $locale = session('lang')&&in_array(session('lang'),config('app.available_languages')) ?session('lang'): app()->getLocale();
        $cacheKey = "translations.{$locale}";
        $cachedTranslations = Redis::get($cacheKey);
        if ($cachedTranslations) {

            return view('main::components.trans', ['trans' => json_decode($cachedTranslations, true)]);
        }
        $trans=$this->getTranslations($locale);
        Redis::set($cacheKey, json_encode($trans, JSON_UNESCAPED_UNICODE));
        // Optionally, set an expiration time for the cache
        Redis::expire($cacheKey, 60 * 60 * 24);
        return view('main::components.trans', ['trans' => $trans]);
    }
    private function getTranslations(string $locale): array
    {
        $moduleLang=app(Translator::class)->getLoader()->namespaces();
        $appPHPTranslations=[];
        foreach ($moduleLang as $path=>$namespace){
           $lang= $this->getPHPTranslations($namespace.DIRECTORY_SEPARATOR.$locale,$path);
            $appPHPTranslations = array_merge($appPHPTranslations, $lang);        }


        return $appPHPTranslations;
    }

    private function getPHPTranslations(string $directory,string $moduleName): array
    {
        if (! is_dir($directory)) {
            return [];
        }
        return collect(File::allFiles($directory))
            ->filter(fn ($file) => $file->getExtension() === 'php')->flatMap(function  ($file)use($moduleName) {$filePath = $file->getRealPath();
                $fileName = $file->getFilenameWithoutExtension();
                $translations = File::getRequire($filePath);
                $dotNotationArray = Arr::dot($translations);

                $prefixedArray = [];
                foreach ($dotNotationArray as $key => $value) {
                    $prefixedArray["{$moduleName}::{$fileName}.{$key}"] = $value;
                }

                return $prefixedArray;
            })->toArray();
    }
}
