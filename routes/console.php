<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\LancarFinanceiroJob;
use App\Jobs\LancarProjecoes;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new LancarFinanceiroJob)
    ->dailyAt('01:00')
    ->withoutOverlapping();

Schedule::job(new LancarProjecoes)
    ->dailyAt('03:00')
    ->withoutOverlapping();
