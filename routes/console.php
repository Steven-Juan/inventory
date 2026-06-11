<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:restart')->dailyAt('03:00');

