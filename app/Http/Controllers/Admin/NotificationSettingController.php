<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Services\AdminNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class NotificationSettingController extends Controller
{
    public function index(): View
    {
        $stored = StoreSetting::pluck('value', 'key')->all();

        $settings = [
            'notification_email' => $stored['notification_email'] ?? '',
            'email_notifications_enabled' => (bool) ($stored['email_notifications_enabled'] ?? false),
            'mailer_transport' => $stored['mailer_transport'] ?? 'log',
            'smtp_host' => $stored['smtp_host'] ?? '',
            'smtp_port' => $stored['smtp_port'] ?? '587',
            'smtp_username' => $stored['smtp_username'] ?? '',
            'smtp_password' => $stored['smtp_password'] ?? '',
            'smtp_encryption' => $stored['smtp_encryption'] ?? 'tls',
            'mail_from_address' => $stored['mail_from_address'] ?? '',
            'mail_from_name' => $stored['mail_from_name'] ?? '',
        ];

        return view('admin.notifications.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notification_email' => 'nullable|email|max:255',
            'email_notifications_enabled' => 'nullable|boolean',
            'mailer_transport' => 'required|in:log,smtp,sendmail',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|between:1,65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:ssl,tls,starttls,',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
        ]);

        $settings = [
            'notification_email' => $validated['notification_email'] ?? '',
            'email_notifications_enabled' => $request->boolean('email_notifications_enabled') ? '1' : '0',
            'mailer_transport' => $validated['mailer_transport'],
            'smtp_host' => $validated['smtp_host'] ?? '',
            'smtp_port' => (string) ($validated['smtp_port'] ?? '587'),
            'smtp_username' => $validated['smtp_username'] ?? '',
        ];

        // Only overwrite the SMTP password when a new one is provided.
        if ($request->filled('smtp_password')) {
            $settings['smtp_password'] = $validated['smtp_password'];
        }

        $settings['smtp_encryption'] = $validated['smtp_encryption'] ?? '';
        $settings['mail_from_address'] = $validated['mail_from_address'] ?? '';
        $settings['mail_from_name'] = $validated['mail_from_name'] ?? '';

        foreach ($settings as $key => $value) {
            StoreSetting::set($key, $value);
        }

        Cache::forget('shop.store_settings');

        return redirect()->route('admin.notifications.index')->with('success', 'Email notification settings saved.');
    }

    public function sendTest(Request $request): RedirectResponse
    {
        $sent = AdminNotifier::send(
            'Test notification from your store',
            '<p>This is a test notification. If you are reading this, email notifications are working correctly.</p>',
            true
        );

        if ($sent) {
            $mode = StoreSetting::get('mailer_transport', 'log');

            $message = $mode === 'log'
                ? 'Test message written to the application log (log mode never delivers a real email; switch to SMTP or PHP mail() on the live site).'
                : 'A test email was sent successfully.';

            return redirect()->route('admin.notifications.index')->with('success', $message);
        }

        return redirect()->route('admin.notifications.index')->with('error', 'Test email could not be sent. '.AdminNotifier::lastError());
    }
}