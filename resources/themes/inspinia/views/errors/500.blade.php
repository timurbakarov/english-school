@extends('layout')

@section('content')

    <div class="content">
        <div class="title">Something went wrong.</div>

        @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
            <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

            <!-- Sentry JS SDK 2.1.+ required -->
            <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

            <script>
                Raven.showReportDialog({
                    eventId: '{{ Sentry::getLastEventID() }}',
                    // use the public DSN (dont include your secret!)
                    dsn: 'https://3f90518b8db8485a90b221786e9f909f@sentry.io/1354306',
                    user: {
                        'name': 'Jane Doe',
                        'email': 'jane.doe@example.com',
                    },
                    lang: 'ru'
                });
            </script>
        @endif
    </div>

@endsection()
