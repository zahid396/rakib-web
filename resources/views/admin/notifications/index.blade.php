@extends('admin.layouts.app')

@section('title', 'Email Notifications')

@section('content')
    <div class="page-header">
        <h1>Email Notifications</h1>
        <p>Get email alerts for new orders, job applications and security events.</p>
    </div>

    @if(!$settings['email_notifications_enabled'])
        <div class="flash-message flash-error" style="margin-bottom:1rem;">
            &#9888; Notifications are currently <strong>disabled</strong>. Enable them below to start receiving alerts.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.update') }}">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-section">
                    <h4 class="form-section-title">General</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="notification_email">Notification Email</label>
                            <input type="email" id="notification_email" name="notification_email" class="form-control @error('notification_email') is-invalid @enderror" value="{{ old('notification_email', $settings['notification_email']) }}" placeholder="admin@example.com">
                            <div class="form-text">All alerts (orders, applications, security) are sent here. Leave empty to use the store contact email.</div>
                            @error('notification_email')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-section-title" style="margin-bottom:0.375rem;">Enable Notifications</label>
                            <div class="form-check" style="margin-top:0.5rem;">
                                <input type="checkbox" id="email_notifications_enabled" name="email_notifications_enabled" value="1" {{ $settings['email_notifications_enabled'] ? 'checked' : '' }}>
                                <label for="email_notifications_enabled">Send email notifications</label>
                            </div>
                            <div class="form-text">Turn this off to stop all notification emails.</div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Mailer Configuration</h4>
                    <p style="margin-bottom:1rem; font-size:0.8rem; color:var(--text-secondary);">
                        Choose <strong>Log</strong> to simply write emails to the log file (safe for testing), or <strong>SMTP</strong> to send real emails through your hosting provider's mail server.
                    </p>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="mailer_transport">Transport</label>
                            <select id="mailer_transport" name="mailer_transport" class="form-control">
                                <option value="log" {{ $settings['mailer_transport'] === 'log' ? 'selected' : '' }}>Log (test mode)</option>
                                <option value="smtp" {{ $settings['mailer_transport'] === 'smtp' ? 'selected' : '' }}>SMTP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mail_from_address">From Address</label>
                            <input type="email" id="mail_from_address" name="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" value="{{ old('mail_from_address', $settings['mail_from_address']) }}" placeholder="noreply@yourdomain.com">
                            @error('mail_from_address')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="mail_from_name">From Name</label>
                            <input type="text" id="mail_from_name" name="mail_from_name" class="form-control @error('mail_from_name') is-invalid @enderror" value="{{ old('mail_from_name', $settings['mail_from_name']) }}" placeholder="Your Store">
                            @error('mail_from_name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div id="smtpFields" style="{{ $settings['mailer_transport'] === 'smtp' ? '' : 'display:none;' }}">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" class="form-control @error('smtp_host') is-invalid @enderror" value="{{ old('smtp_host', $settings['smtp_host']) }}" placeholder="mail.yourdomain.com">
                                @error('smtp_host')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="number" id="smtp_port" name="smtp_port" class="form-control @error('smtp_port') is-invalid @enderror" value="{{ old('smtp_port', $settings['smtp_port']) }}" min="1" max="65535">
                                @error('smtp_port')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="smtp_encryption">Encryption</label>
                                <select id="smtp_encryption" name="smtp_encryption" class="form-control">
                                    <option value="" {{ $settings['smtp_encryption'] === '' ? 'selected' : '' }}>None</option>
                                    <option value="tls" {{ $settings['smtp_encryption'] === 'tls' ? 'selected' : '' }}>TLS (recommended)</option>
                                    <option value="ssl" {{ $settings['smtp_encryption'] === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="starttls" {{ $settings['smtp_encryption'] === 'starttls' ? 'selected' : '' }}>STARTTLS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_username">SMTP Username</label>
                                <input type="text" id="smtp_username" name="smtp_username" class="form-control @error('smtp_username') is-invalid @enderror" value="{{ old('smtp_username', $settings['smtp_username']) }}">
                                @error('smtp_username')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="smtp_password">SMTP Password</label>
                                <input type="password" id="smtp_password" name="smtp_password" class="form-control @error('smtp_password') is-invalid @enderror" autocomplete="new-password">
                                <div class="form-text">Leave blank to keep the current password.</div>
                                @error('smtp_password')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section" style="margin-bottom:0; padding-bottom:0; border-bottom:none;">
                    <h4 class="form-section-title">What triggers a notification?</h4>
                    <ul style="margin:0; padding-left:1.25rem; font-size:0.875rem; color:var(--text-secondary); line-height:1.9;">
                        <li>New order placed by a customer</li>
                        <li>New job application submitted</li>
                        <li>Repeat failed admin login attempts (security)</li>
                        <li>Admin password changed (security)</li>
                    </ul>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </form>

    <div class="card" style="margin-top:1.25rem;">
        <div class="card-header">
            <h3>Send a Test Email</h3>
        </div>
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
            <p style="margin:0; font-size:0.875rem; color:var(--text-secondary);">Verify that your notification email and SMTP settings work correctly.</p>
            <form method="POST" action="{{ route('admin.notifications.test') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Send Test Email</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('mailer_transport').addEventListener('change', function() {
        document.getElementById('smtpFields').style.display = this.value === 'smtp' ? '' : 'none';
    });
</script>
@endpush