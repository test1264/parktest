<?php
    $now = new DateTime();
    $now->format('Y-m-d H:i:s');

    $now->getTimestamp();
    $now->modify('+3 hour');
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <meta charset="UTF-8">
    <title>Автомобили на стоянке</title>
</head>
<body class="antialiased">
    <div class="container">
        <h2>Автомобили на стоянке</h2>
        <div class="container">
            <table class="table table-bordered table-striped">
                @foreach ($clientcarspark as $clientcarpark)
                <tr>
                    <td class="col-3">{{ $clientcarpark->name }}</td>
                    <td class="col-3">{{ $clientcarpark->brand }} {{ $clientcarpark->model }}</td>
                    <td class="col-2">{{ $clientcarpark->number }}</td>
                    <td class="col-4"><?php
                        $date2 = new DateTime($clientcarpark->parked_at);

                        $timezone = new DateTimeZone('Europe/Moscow');
                        $date2->setTimezone($timezone);

                        $interval = $now->diff($date2);
                        echo $interval->d." дней " . $interval->h." часов " . $interval->i." минут";
                    ?></td>
                </tr>
                @endforeach
            </table>
            {{ $clientcarspark->links() }}

        <form action="/updateList" method="post" class="form w-50 p-3">
            @csrf
            @method('patch')

            <label for="clientSelect">Клиент:</label>
            <select class="form-select" name="clientSelect" id="clientSelect">
                @foreach ($clientcars as $clientcar)
                    <option value="{{ $clientcar->id_client }}">{{$clientcar->name}}</option>
                @endforeach
            </select>

            <label for="carSelect">Автомобиль:</label>
            <select class="form-select" name="carSelect" id="carSelect"></select>

            <label for="parkCheck">Автомобиль:</label>
            <select class="form-select" name="parkCheck" id="parkCheck"></select>

            
            <div class="py-3 fs-5" id="submitBtn"></div>
        </form>
    </div>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>