<?php

use Telegram\Bot\Helpers\Emojify;

$goodStatus = Emojify::getInstance()->toEmoji(':white_check_mark:');
$warningStatus = Emojify::getInstance()->toEmoji(':warning:');
$errorStatus = Emojify::getInstance()->toEmoji(':red_circle:');
?>

@php /** @var \App\Containers\AppSection\Salesforce\Models\SalesforceImport $import */ @endphp
@foreach($imports as $import)
{{ $import->end_date->diffInMinutes() >= 5 ? $errorStatus : ($import->end_date->diffInMinutes() >= 2 ? $warningStatus : $goodStatus)}}
<strong>{{ $import->getObjectName() }}</strong>: {{ $import->end_date->diffForHumans() }} ({{ $import->end_date->toDateTimeString() }})
@endforeach
