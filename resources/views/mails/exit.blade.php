@component('mail::message')
    # Hello {{ $f_name }},

    You exited at {{ $ended_at }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
