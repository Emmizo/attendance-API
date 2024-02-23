@component('mail::message')
    # Hello {{ $f_name }},

    You attended at {{ $started_at }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
