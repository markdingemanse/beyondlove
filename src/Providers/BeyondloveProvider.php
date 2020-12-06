<?php

namespace MarkDingemanse\Beyondlove\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BeyondloveProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'MarkDingemanse\\Beyondlove\\Controllers\\';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')->get('/', $this->namespace.'HomepageController@launch')->name('homepage');
        Route::get('random', $this->namespace.'HomepageController@getRandomFile')->name('getFile');
        Route::get('upload', $this->namespace.'HomepageController@uploadfileview')->name('upload_background_view');
        Route::post('upload', $this->namespace.'HomepageController@uploadFile')->name('upload_background_post');

        parent::boot();
    }
}
