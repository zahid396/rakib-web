<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $storeName }}</title>
    <style>
        body { margin: 0; padding: 0; background: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .wrap { max-width: 600px; margin: 0 auto; padding: 24px 16px; }
        .card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .head { background: #1e293b; color: #ffffff; padding: 20px 24px; }
        .head h1 { margin: 0; font-size: 18px; font-weight: 700; }
        .head p { margin: 4px 0 0; font-size: 13px; color: #94a3b8; }
        .body { padding: 24px; color: #1e293b; font-size: 14px; line-height: 1.7; }
        .body p { margin: 0 0 14px; }
        .body ul { margin: 0 0 14px; padding-left: 20px; }
        .body li { margin-bottom: 4px; }
        .body strong { color: #0f172a; }
        .foot { padding: 16px 24px; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="head">
                <h1>{{ $storeName }}</h1>
                <p>Store notification</p>
            </div>
            <div class="body">
                {!! $body !!}
            </div>
            <div class="foot">
                Sent automatically by {{ $storeName }} admin panel.
            </div>
        </div>
    </div>
</body>
</html>