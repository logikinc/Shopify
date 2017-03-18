<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
</head>
<body style="background-color: #ebeef0">
<script type="text/javascript">
    window.top.location.href = '{{ $redirect }}';
</script>
</body>
</html>