<?php $clientcar = $clientcars[0]?>

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
        <h2>Редактирование клиента</h2>
        <h3>Клиент</h3>
        <form action="{{ route('client.update', $clientcar->id_client) }}" method="post" class="form w-50 p-3">
            @csrf
            @method('patch')
            <label for="name">ФИО</label>
            <input type="text" class="form-control" name="name" value="{{ $clientcar->name }}">
            <label for="sex">Пол:</label> 
            <select class="form-select" name="sex">
                <option <?php echo $clientcar->sex === 'Мужской' ? 'selected' : '' ?> value="Мужской">Мужской</option>
                <option <?php echo $clientcar->sex === 'Женский' ? 'selected' : '' ?> value="Женский">Женский</option>
            </select>
            <label for="phone">Номер телефона</label>
            <input type="text" class="form-control" name="phone" value="{{ $clientcar->phone }}">
            <label for="address">Адрес</label>
            <input type="text" class="form-control" name="address" value="{{ $clientcar->address }}">

            <button type="submit" class="btn btn-outline-primary m-3">Сохранить</button>
        </form>

        <h3>Автомобили клиента</h3>
        @foreach ($clientcars as $clientcar)
            <form action="{{ route('car.update', $clientcar->id_car) }}" method="post" class="form w-50 p-3">
                @csrf
                @method('patch')
                <label for="brand">Марка</label>
                <input type="text" class="form-control" name="brand" value="{{ $clientcar->brand }}">
                <label for="model">Модель</label>
                <input type="text" class="form-control" name="model" value="{{ $clientcar->model }}">
                <label for="color">Цвет кузова</label>
                <input type="text" class="form-control" name="color" value="{{ $clientcar->color }}">
                <label for="number">Регистрационный номер</label>
                <input type="text" class="form-control" name="number" value="{{ $clientcar->number }}">
                
                <button type="submit" class="btn btn-outline-primary m-3">Сохранить</button>
            </form>
        @endforeach
        

        <h3>Добавить автомобиль</h3>
        <form class="form w-50 p-3">
            <label for="brand">Марка</label>
            <input type="text" class="form-control" name="brand">
            <label for="model">Модель</label>
            <input type="text" class="form-control" name="model">
            <label for="color">Цвет кузова</label>
            <input type="text" class="form-control" name="color">
            <label for="number">Регистрационный номер</label>
            <input type="text" class="form-control" name="number">
            
            <button type="submit" class="btn btn-outline-primary m-3">Добавить</button>
        </form>
    </div>
 
</body>
</html>