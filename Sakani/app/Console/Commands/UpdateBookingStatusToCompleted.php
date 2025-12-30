<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateBookingStatusToCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-booking-status-to-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically exchange expired bookings to completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedCount = Booking::where('status', 'Accepted')
            ->where('end_date', '<', Carbon::today())
            ->update(['status' => 'Completed']);

        $this->info("Update status $updatedCount bookings to Completed ");
    }
    
}
