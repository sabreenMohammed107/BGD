{{-- change your password  <a href="http://127.0.0.1:8000/api/reset/{{ $token }}">here</a> --}}
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p style="margin-bottom: 20px">{!! $dear !!} {!! $name !!},</p>
    <p style="margin-bottom: 20px">{!! $before !!}</p>
    <p style="margin-bottom: 20px">{!! $token !!}</p>
    <p style="margin-bottom: 20px">{!! $after !!}</p>
    <p>{!! $thanks !!}</p>
    <p>{!! $regards !!}</p>
</body>
</html>

