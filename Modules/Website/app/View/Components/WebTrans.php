<?php

namespace Modules\Website\View\Components;

use Illuminate\Support\Facades\Redis;
use Illuminate\View\Component;
use Illuminate\View\View;

class WebTrans extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {

        return view('website::components.translate',['translations'=>[],'value'=>$value]);
    }
}
