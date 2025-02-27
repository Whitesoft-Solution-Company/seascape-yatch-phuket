<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NotifyUpcomingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-upcoming-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       // ดึงข้อมูล Booking ที่จะเกิดขึ้นในอีก 24 ชั่วโมงข้างหน้า
        $now = Carbon::now();

        // หาวันที่ต้องการแจ้งเตือน (2 วันก่อนวันกำหนด)
        $notifyDate = $now->addDays(2)->toDateString();

        // ค้นหา Booking ที่ตรงกับวันที่แจ้งเตือน
        $upcomingBookings = Booking::whereDate('booking_time', $notifyDate)->get();

        if ($upcomingBookings->isEmpty()) {
            $this->info('No upcoming bookings to notify.');
            return;
        }

        $message = "รายการ Booking ที่กำลังจะมาถึง:\n";
        foreach ($upcomingBookings as $booking) {
            $message .= " - Booking ID: {$booking->booking_code}, ลูกค้า: {$booking->name}, วันที่: {$booking->booking_time}\n";
        }

        // ส่งแจ้งเตือนผ่าน LINE Notify
        $this->sendLineNotify($message);

        $this->info('Notification sent successfully.');
    }

    private function sendLineNotify($message)
    {
        $lineToken = env('LINE_NOTIFY_TOKEN');

        if (!$lineToken) {
            $this->error('LINE_NOTIFY_TOKEN is not set');
            return;
        }

        Http::withToken($lineToken)->asForm()->post('https://notify-api.line.me/api/notify', [
            'message' => $message,
        ]);
    }
}
