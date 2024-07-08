<?php

namespace Modules\Website\tests\Unit;

use Illuminate\Support\Facades\Redis;
use Modules\Main\View\Components\Trans;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslateTest extends TestCase
{

    public function test_translate_default_loaded()
    {
        $lang = config('app.locale');
        $res=$this->get('/');
        $res->assertSee('lang="'.$lang.'"', false); // A második paraméter (false) azt jelenti, hogy a keresés nem érzékeny a kis- és nagybetűkre

        }
    public function test_translate_lang_change_invalid()
    {

        $res=$this->get('/');
        $res->assertStatus(200);
        $res=$this->get(route('locale','fr'));
        $res->assertStatus(302);
        $res->assertSessionMissing('locale');
        app()->getLocale()!==config('app.locale')? $this->assertFalse('App local not allow the default value'):$this->assertTrue(true);



    }
    public function test_translate_lang_change_and_loaded()
    {
        $language=config('app.available_languages');
        $languages=array_reverse($language);
        foreach ($languages as $lang){
            $res=$this->get(route('locale',$lang));
            $res->assertStatus(302);
            $res->assertSessionHas('lang',$lang);
            $res->assertRedirect();
            $res->assertSessionHas('lang',$lang);
            $expectedTranslations =Redis::get('translations.'.$lang);
            $res=$this->get('/');
            $res->assertSee(   'window._translations = ' . $expectedTranslations . ';',false);
            $res->assertSee('lang="'.$lang.'"', false);
        }

    }
}
