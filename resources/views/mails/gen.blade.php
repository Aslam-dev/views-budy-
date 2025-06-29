
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content->subject }}</title>

</head>
<body style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
    {!! xss_clean($content->body)  !!}
</body>
</html>
