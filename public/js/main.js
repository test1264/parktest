document.getElementById('clientSelect').addEventListener('click', fillCarList);

let carsInfo;

function fillCarList() {

    let select = document.getElementById('clientSelect');
    let clientId = select.options[select.selectedIndex].value;
    
    let xhr = new XMLHttpRequest();

    xhr.onload = function() {
        if(this.status == 200) {
            let result = JSON.parse(this.responseText);

            // массив с данными автомобилей выбранного клиента
            carsInfo = result;

                output = '';

            for (index = 0; index < result.length; ++index) {
                output += '<option value="' + result[index].id_car + '">' + result[index].brand + ' ' + result[index].model + '</option>';
            }
                
            document.getElementById('carSelect').innerHTML = output;

            // создание ивента только после создания списка
            document.getElementById('carSelect').addEventListener('click', fillCheck);
        }
    };

    url = '/getCars/' + clientId;
    xhr.open('get', url, true);

    xhr.send();
}

function fillCheck() {
    let select = document.getElementById('carSelect');
    let carId = select.options[select.selectedIndex].value;

    let is_parked = 0;

    for (index = 0; index < carsInfo.length; ++index) {
        if(carsInfo[index].id_car == carId) {
            if(carsInfo[index].is_parked == 1) {
                is_parked = 1;
            }
        }
    }

    output = '<option value="0"' + (is_parked == 0 ? 'selected' : '') + '>Не на стоянке</option>'
            +'<option value="1"' + (is_parked == 1 ? 'selected' : '') + '>На стоянке</option>';         

    document.getElementById('parkCheck').innerHTML = output;

    document.getElementById('submitBtn').innerHTML = '<button type="submit" class="btn btn-outline-primary">Сохранить</button>';
}