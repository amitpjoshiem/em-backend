<!DOCTYPE html>
<html lang="en">
<head>
    <title>Yodlee Link</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}"/>
    <script type='text/javascript' src='https://cdn.yodlee.com/fastlink/v4/initialize.js'></script>
</head>
<body>
<div class="container-fluid">
    @if ($sandbox)
        <div class="w-50 m-auto">
            <ul class="nav nav-tabs" id="yodleeCreds" role="tablist">
                @foreach($sandbox_creds as $name => $cred)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($loop->first) active @endif" id="cred-{{ $loop->index }}-tab" data-bs-toggle="tab" data-bs-target="#cred-{{ $loop->index }}" type="button" role="tab" aria-controls="cred-{{ $loop->index }}" aria-selected="true">{{ $name }}</button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="yodleeCredsContent">
                @foreach($sandbox_creds as $name => $cred)
                    <div class="tab-pane fade show @if($loop->first) active @endif" id="cred-{{ $loop->index }}" role="tabpanel" aria-labelledby="cred-{{ $loop->index }}-tab">
                        <p>Login: {{ $cred['login'] }}</p>
                        <p>Pass: {{ $cred['pass'] }}</p>
                        <p>MFA: {{ $cred['MFA'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div id="container-fastlink">
    </div>
</div>
</body>
<script src="{{ asset('assets/js/admin.js') }}"></script>
<script>
    window.fastlink.open({
            fastLinkURL: '{{ $fastlink }}',
            accessToken: 'Bearer {{ $token }}',
            params: {
                configName : 'Aggregation'
            },
            onSuccess: function (data) {
                // will be called on success. For list of possible message, refer to onSuccess(data) Method.
                console.log(data);
            },
            onError: function (data) {
                // will be called on error. For list of possible message, refer to onError(data) Method.
                console.log(data);
            },
            onClose: function (data) {
                // will be called called to close FastLink. For list of possible message, refer to onClose(data) Method.
                window.close();
                console.log(data);
            },
            onEvent: function (data) {
                // will be called on intermittent status update.
                console.log(data);
            }
        },
        'container-fastlink');
</script>
</html>
