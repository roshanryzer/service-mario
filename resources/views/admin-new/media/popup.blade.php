@if (request()->input('media-action') === 'select-files')
    <html>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! Assets::renderHeader() !!}
            {!! RsMedia::renderHeader() !!}
        </head>
        <body>
            {!! RsMedia::renderContent() !!}
            {!! Assets::renderFooter() !!}
            {!! RsMedia::renderFooter() !!}
        </body>
    </html>
@else
    {!! RsMedia::renderHeader() !!}

    {!! RsMedia::renderContent() !!}

    {!! RsMedia::renderFooter() !!}
@endif
