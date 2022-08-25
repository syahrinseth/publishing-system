<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notification | {{ config('app.name') }}</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    </head>

    <body>
        <div class="flex items-center justify-center min-h-screen p-5 bg-gray-600 min-w-screen">
            <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
                <div class="flex justify-center">
                    <img class="mx-auto h-32 w-auto" src="{{ asset('/img/logo.png') }}" alt="Logo" />
                </div>
                <div class="mx-5 text-left">
                    <p>Dear {{ $user->first_name }},</p>
                    <br>
                    <p>Your manuscript {{ $manuscript->manuscript_no }} has been updated.</p>
                    <br>
                    <p>Click the link below to proceed to the manuscript page:</p>
                    <br>
                    <p>Kind regards,</p>
                    <p>Editor-In-Chief</p>
                    <p>Journal of Smart Sensor and Materials (JSSM)</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('manuscript.edit', ['id' => $manuscript->id]) }}" class="px-2 py-2 text-blue-200 bg-blue-600 rounded">
                        Open
                    </a>
                    <p class="mt-4 text-sm">If you’re having trouble clicking the "Open" button, copy
                        and
                        paste
                        the URL below
                        into your web browser:
                        <a href="{{ route('manuscript.edit', ['id' => $manuscript->id]) }}" class="text-blue-600">
                            {{ route('manuscript.edit', ['id' => $manuscript->id]) }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>