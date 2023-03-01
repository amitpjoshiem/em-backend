<tr>
    <td class="plate" style="text-align: center; font-size:21px; color: #282828; background: #D9F0FF;">
        @foreach($lines as $line)
            @if ($line instanceof Illuminate\Support\HtmlString)
                {!! $line !!}
            @else
                <p style="margin: 10px;">{{ $line }}</p>
            @endif
        @endforeach
    </td>
</tr>
