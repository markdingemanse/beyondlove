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
    protected $namespace = 'MarkDingemanse\Beyondlove\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/', 'HomepageController@launch')->middleware('web')->namespace($this->namespace)->name('homepage');
        Route::get('random', 'HomepageController@getRandomFile')->namespace($this->namespace)->name('getFile');
        Route::get('upload','HomepageController@uploadfileview')->namespace($this->namespace)->name('upload_background_view');
        Route::post('upload','HomepageController@uploadFile')->namespace($this->namespace)->name('upload_background_post');
    
        parent::boot();
    }
}
