<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MoneyBox;
use App\Models\SystemPreference;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
       
        
    //     $banks = json_decode(SystemPreference::where('key', 'banks')->value('value'), true);
        
    //     foreach ($banks as $bankName) {
    //         if (!MoneyBox::where('bank_name', $bankName)->exists()) {
    //             MoneyBox::create(['bank_name' => $bankName, 'balance' => 0]);
    //         }
    //     }
        
    // }
}
