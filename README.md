## Тестовое задание: система учёта клиентов автостоянки

Реализовать систему учёта клиентов автостоянки на фреймворке Laravel. Система должна иметь функции создания, редактирования, удаления данных о клиентах и их автомобилях, (*)а также должна быть возможность ведения учёта того, сколько и какие автомобили находится на стоянке.

PHP 8.1
Laravel 10
MySQL 5.7

Данные о клиентах и автомобилях хранятся в трёх таблицах:

clients (id, name, sex, phone, address)

cars(id, brand, model, color, number, is_parked, parked_at)

clientcar(id_client, id_car) - содержит композитный ключ, ссылающийся на clients и cars

Запросы направляются в контроллеры, где обрабатывается логика и происходит взаимодействие с БД

app/Http/ClientController.php

app/Http/CarController.php