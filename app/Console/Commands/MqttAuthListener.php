<?php

namespace App\Console\Commands;

use App\Models\UserCardsTemporary;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MqttAuthListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to MQTT topic for authentication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('connecting to mqtt server');
        $mqtt = MQTT::connection();
        $host = $mqtt->getHost();

        $this->info("Terkoneksi dengan $host");

        $mqtt->subscribe('catdoom/device/auth', function (string $topic, string $uuid) {
            $this->info("Terdeteksi uuid baru: $uuid");

            if (UserCardsTemporary::count() == 1) {
                $first = UserCardsTemporary::first();
                $first->uuid = $uuid;
                $first->update();
            } else {
                UserCardsTemporary::create([
                    'uuid' => $uuid,
                ]);
            }
        });

        $mqtt->loop();
    }
}
