@component('mail::message')
    {{-- Greeting --}}
    @if (! empty($greeting))
        <tr>
            <td style="color:#073763;">
                <h1 style="font-size:23px;margin:0 0 20px 0;font-family:Arial,sans-serif;line-height: 140%;">{{ $greeting }}</h1>
            </td>
        </tr>
    @else
        @if ($level === 'error')
            <tr>
                <td style="color:#073763 !important;">
                    <h1 style="font-size:20px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                        @lang('Whoops!')
                    </h1>
                </td>
            </tr>
        @else
            <tr>
                <td style="color:#073763 !important;">
                    <h1 style="font-size:20px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                        @lang('Hello!')
                    </h1>
                </td>
            </tr>
        @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
        @if ($line instanceof Illuminate\Support\HtmlString)
            {!! $line !!}
        @else
            <tr>
                <td style="color:#073763;">
                    <p style="margin:0 0 30px 0;font-size:21px;line-height:24px;font-family:Arial,sans-serif;color:#282828;line-height: 140%;">
                        {{ $line }}
                    </p>
                </td>
            </tr>
        @endif
    @endforeach

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
        @if ($line instanceof Illuminate\Support\HtmlString)
            {!! $line !!}
        @else
            <tr>
                <td style="color:#073763;">
                    <p style="margin:0 0 30px 0;font-size:21px;line-height:24px;font-family:Arial,sans-serif;color:#282828;line-height: 140%;">
                        {{ $line }}
                    </p>
                </td>
            </tr>
        @endif
    @endforeach

    {{-- Subcopy --}}
    @isset($actionText)
        <tr>
            <td style="font-size: 12px;text-align: center;padding:0 35px 10px 35px; word-break: break-word;">
                <p style="color: #808080;border-top: 1px solid #808080; padding-top: 30px;line-height: 140%;">
                    If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your
                    web browser:
                    {{ $actionUrl }}
                </p>
            </td>
        </tr>
    @endisset
@endcomponent
