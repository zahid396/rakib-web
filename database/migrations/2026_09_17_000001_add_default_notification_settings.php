<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'notification_email' => '',
            'email_notifications_enabled' => '0',
            'mailer_transport' => 'log',
            'smtp_host' => '',
            'smtp_port' => '587',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_encryption' => 'tls',
            'mail_from_address' => '',
            'mail_from_name' => '',
        ];

        foreach ($defaults as $key => $value) {
            if (DB::table('store_settings')->where('key', $key)->exists()) {
                continue;
            }

            if ($key === 'notification_email') {
                $contactEmail = DB::table('store_settings')->where('key', 'contact_email')->value('value');
                $value = $contactEmail ?: '';
            }

            DB::table('store_settings')->insert([
                'key' => $key,
                'value' => $value,
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('store_settings')->whereIn('key', [
            'notification_email',
            'email_notifications_enabled',
            'mailer_transport',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'smtp_encryption',
            'mail_from_address',
            'mail_from_name',
        ])->delete();
    }
};