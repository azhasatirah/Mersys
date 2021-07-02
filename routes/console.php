<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Carbon;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    log::info(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notifme',function(){
    DB::table('notif')->insert([
        'Notif'=> 'system call',
        'NotifFrom'=> '5405ac3680054cbf8669dbc09c51ba97',
        'NotifTo'=> 'admin',
        'IsRead'=>false,
        'Link'=>'',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
    ]);
});
