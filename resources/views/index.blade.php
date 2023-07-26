<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <meta charset="UTF-8">
    <title>Все клиенты</title>
</head>
<body class="antialiased">

    <div class="container">
        <h2>Все клиенты</h2>
        <div>
            <a class="btn btn-outline-primary" href="{{ route('client.create') }}">Добавить клиента</a>
            <a class="btn btn-outline-primary" href="/list">Просмотр Автомобилей на стоянке</a>
        </div>
        <table class="table table-bordered table-striped">
            @foreach ($clientcars as $clientcar)
            <tr>
                <td class="col-4">{{ $clientcar->name }}</td>
                <td class="col-3">{{ $clientcar->brand }} {{ $clientcar->model }}</td>
                <td class="col-3">{{ $clientcar->number }}</td>
                <td class="col-1 text-center">
                    <a href="{{ route('client.edit', $clientcar->id_client) }}"><i class="bi bi-pencil-square fs-3"></i></a>
                </td>
                <td class="col-1  text-center">
                    <form action="{{ route('car.destroy', $clientcar->id_car) }}" method="post" class="form">
                        @csrf
                        @method('delete')
                        <button type="submit"><i class="bi bi-x-square fs-3"></i></button>
                    </form>
                </td>
                
            </tr>
            @endforeach
        </table>
        {{ $clientcars->links() }}
    </div>
 
</body>
</html>