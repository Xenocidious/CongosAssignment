<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Congos Person Manager</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
        <div class="personContainer">
            @foreach($persons as $person)
                <p>{{ $person->name }} {{ $person->surname }}</p>
                <ul>
                    @foreach($person->addresses as $address)
                        <li>Address: {{ $address->street_name }} {{ $address->street_number }}, {{ $address->city }}</li>
                        <ul>
                            @foreach($address->notes as $note)
                                <li>Note: {{ $note->note }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
                <ul>
                    @foreach($person->notes as $note)
                        <li>Note: {{ $note->note }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </body>
</html>
