<?php

namespace App\Services;

use App\Mail\AdminNotification;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminNotifier
{
    /**
     * Whether email notifications are switched on in the admin panel.
     */
    public static function isEnabled(): bool
    {
        return (bool) StoreSetting::get('email_notifications_enabled', '0');
    }

    /**
     * The admin email address that receives notifications.
     */
    public static function recipient(): ?string
    {
        $email = StoreSetting::get('notification_email');

        return $email ?: null;
    }

    /**
     * Fallback to the store contact email when no dedicated notification email is set.
     */
    public static function fallbackRecipient(): ?string
    {
        $email = StoreSetting::get('contact_email');

        return $email ?: null;
    }

    /**
     * Send an email to the admin. Returns true when the message was dispatched.
     */
    public static function send(string $subject, string $messageHtml): bool
    {
        try {
            if (! static::isEnabled()) {
                return false;
            }

            $to = static::recipient() ?: static::fallbackRecipient();

            if (! $to) {
                Log::info('Notification email skipped: no recipient configured.');

                return false;
            }

            static::applyMailConfig();

            $storeName = (string) (StoreSetting::get('store_name') ?: config('app.name'));

            Mail::to($to)->send(new AdminNotification($subject, $messageHtml, $storeName));

            return true;
        } catch (\Throwable $e) {
            Log::warning('Notification email could not be sent: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Apply the SMTP settings saved in the store settings before sending.
     */
    protected static function applyMailConfig(): void
    {
        $transport = StoreSetting::get('mailer_transport', 'log');

        if ($transport !== 'smtp') {
            config(['mail.default' => 'log']);

            return;
        }

        $fromAddress = StoreSetting::get('mail_from_address') ?: config('mail.from.address');

        $encryption = StoreSetting::get('smtp_encryption') ?: null;

        if ($encryption === 'starttls') {
            $encryption = 'tls';
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => StoreSetting::get('smtp_host') ?: config('mail.mailers.smtp.host'),
            'mail.mailers.smtp.port' => (int) (StoreSetting::get('smtp_port') ?: 587),
            'mail.mailers.smtp.username' => StoreSetting::get('smtp_username') ?: null,
            'mail.mailers.smtp.password' => StoreSetting::get('smtp_password') ?: null,
            'mail.mailers.smtp.encryption' => $encryption,
            'mail.from.address' => $fromAddress,
            'mail.from.name' => StoreSetting::get('mail_from_name') ?: config('mail.from.name'),
        ]);
    }

    /**
     * Notify the admin that a new order was placed.
     */
    public static function orderPlaced($order): bool
    {
        $product = $order->product()->first();

        $html = '<p>A new order has been placed on your store.</p>'
            .'<ul>'
            .'<li><strong>Order ID:</strong> '.e($order->order_id).'</li>'
            .'<li><strong>Product:</strong> '.e($product->title ?? 'N/A').'</li>'
            .'<li><strong>Customer email:</strong> '.e($order->customer_email).'</li>'
            .'<li><strong>Payment method:</strong> '.e($order->payment_method).'</li>'
            .'<li><strong>Sender number:</strong> '.e($order->sender_number).'</li>'
            .'<li><strong>Transaction ID:</strong> '.e($order->transaction_id).'</li>'
            .'<li><strong>Amount:</strong> '.e((string) number_format((float) $order->amount, 2)).'</li>'
            .'<li><strong>Placed at:</strong> '.e($order->created_at?->format('d M Y, H:i')).'</li>'
            .'</ul>'
            .'<p>Log in to the admin panel to verify the payment.</p>';

        return static::send("New order {$order->order_id}", $html);
    }

    /**
     * Notify the admin that a new job application was submitted.
     */
    public static function jobApplication($application): bool
    {
        $job = $application->jobPosting()->first();

        $html = '<p>A new job application has been submitted.</p>'
            .'<ul>'
            .'<li><strong>Position:</strong> '.e($job->title ?? 'N/A').'</li>'
            .'<li><strong>Applicant:</strong> '.e($application->applicant_name).'</li>'
            .'<li><strong>Email:</strong> '.e($application->applicant_email).'</li>'
            .'<li><strong>Phone:</strong> '.e($application->phone ?? '—').'</li>'
            .'<li><strong>Message:</strong> '.e($application->cover_letter ?? '—').'</li>'
            .'</ul>'
            .'<p>Review the application from the admin panel.</p>';

        return static::send('New job application for '.($job->title ?? 'position'), $html);
    }

    /**
     * Notify the admin about a security related event.
     */
    public static function securityAlert(string $message): bool
    {
        $html = '<p>A security-related event was detected:</p>'
            .'<p>'.e($message).'</p>';

        return static::send('Security alert - '.config('app.name'), $html);
    }
}