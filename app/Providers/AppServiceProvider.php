<?php

namespace App\Providers;

use App\MailchimpManager;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailchimpManager::class, function ($app) {
            $mailChimp = new ApiClient();
            $mailChimp->setConfig([
                'apiKey' => config('mailchimp.apiKey'),
                'server' => 'us1',
            ]);

            return new MailchimpManager($mailChimp, config('mailchimp.listId'));
        });

        $this->app->alias(MailchimpManager::class, 'mailchimpmanager');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/mailchimp.php', 'mailchimp');
    }
}
