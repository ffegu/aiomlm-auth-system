<?php

namespace Aiomlm\Auth;
use Illuminate\Support\ServiceProvider;
/**
 *
 */
class AuthServiceProvider extends ServiceProvider
{

   public function boot()
   {
      $this->publishables();
   }

   public function register()
   {
      $this->mergeConfigFrom(__DIR__.'/../config/profile.php', 'profile');
   }

   private function publishables()
   {

       if (app()->runningInConsole()) {
           $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
       $this->loadFactoriesFrom(__DIR__.'/../database/factories');
   }

}
