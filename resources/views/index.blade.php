<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body class="antialiased">

    <div class="container">
        <h2>Все клиенты</h2>
        <table class="table table-bordered table-striped">
            @foreach ($clients as $client)
            <tr>
                <td class="col-4">{{ $client->name }}</td>
                <td class="col-3">{{ $client->brand }} {{ $client->model }}</td>
                <td class="col-3">{{ $client->number }}</td>
                <td class="col-1 text-center"><i class="bi bi-pencil-square fs-3"></i></td>
                <td class="col-1  text-center"><i class="bi bi-x-square fs-3"></i></td>
            </tr>
            @endforeach
        </table>
        {{ $clients->links() }}
    </div>
 
</body>
</html>