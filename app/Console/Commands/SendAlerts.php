<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $today = \Carbon\Carbon::today();

    $missed = \App\Models\Patient::where('next_appointment', '<', $today->subWeek())->get();
    foreach($missed as $p){
        // مثال: ارسال ايميل
        \Log::info("Patient {$p->name} missed appointment.");
    }
}}
