/**
 * Created by Jolanta on 24.06.2018.
 */

if (document.getElementById('advert_voivodeship_id')) {
    var voivodeship = document.getElementById('advert_voivodeship_id').parentNode;
    voivodeship.addEventListener('change', selectVoivodeship);
}

if (document.getElementById('titleBtn')) {
    var titleBtn = document.getElementById('titleBtn');
    titleBtn.addEventListener('click', searchByTitle);
}

if (document.getElementById('filter_params')) {
    var searchBtn = document.getElementById('filter_params');
    searchBtn.addEventListener('click', searchFilters);
}

var userBtns = document.querySelectorAll('user-block-btn');

if (userBtns){
    userBtns.forEach(function(bttn){
        bttn.addEventListener('click', function(e){
            console.log(e.target.id);
        });
    });
}

function selectVoivodeship(){
    var xhr = new XMLHttpRequest();
    var voivodeship_id = document.getElementById('advert_voivodeship_id').value;

    if (voivodeship_id != 0) {
        var data = 'voivodeship_id=' + voivodeship_id;
        xhr.open('POST', '/ogloszenia/cities');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var cities = JSON.parse(xhr.responseText);
                var options = '';

                if (cities) {
                    options += "<option value=0>Select city... </option>";
                    cities.forEach( function(city){
                        options += "<option value=" + city.name + ">" +city.name + "</option>";
                    });
                    document.getElementById('city_select').disabled = false;
                    document.getElementById('city_select').innerHTML = options;
                } else {
                    options = '<option value="none" >Brak miast dla wybranego wojewodztwa</option>';
                    document.getElementById('city_select').disabled = true;
                    document.getElementById('city_select').style.height = '';
                    document.getElementById('city_select').innerHTML = options;
                }
            }
        };
        xhr.send(data);
    } else {
        document.getElementById('city_select').disabled = true;
        document.getElementById('city_select').innerHTML = "<option value=0>Choose...</option>";
    }

}

function preSend() {
    var city_name = document.getElementById("city_select").value;
    var submit_button = document.getElementById('send');

    if (!city_name) {
        alert('Wybierz conajmniej jedno miasto!');
    } else {
        var xhr = new XMLHttpRequest();
        var data = "city=" + city_name;
        xhr.open('POST', '/user/advert/add');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.addEventListener('load', function() {
            if (this.status === 200) {
                document.querySelector('form').submit();
            } else {
                alert('Dodawanie nie powiodlo sie');
            }
        });
        xhr.send(data);
    }
}

function changePublic(advertId){
    var xhr = new XMLHttpRequest();
    var data = "advert_id=" +advertId;
    xhr.open('POST', '/advert/public');

    xhr.addEventListener('load', function(){
        if (this.status === 200) {
            console.log(xhr);
            var public = JSON.parse(xhr.responseText);
            var publicBtn = document.getElementById('eyeIcon' + advertId);
            if (public) {
                publicBtn.className = "glyphicon glyphicon-eye-open";
            } else {
                publicBtn.className = "glyphicon glyphicon-eye-close";
            }
        } else {
            alert('Unable to change visibility of the advert. Try again or contact with serwis administrator.')
        }
    });

    xhr.send();
}

function deleteAdvert(advertId) {
    var agreement = confirm('Czy na pewno chcesz usunąć ogłoszenie?');
    if (agreement) {
        window.location.href = 'http://' + window.location.host + '/adverts/delete/' + advertId;
    }
}

function searchByTitle() {
    var title = document.getElementById('advert_title').value;
    if (title) {
        var pathname = '/adverts/page/1/' + title;
        window.location.pathname = pathname;
    } else {
        alert('Please type the title first!');
    }
}

function searchFilters() {
    var category = document.getElementById('filterCategory').value,
    voivodeship = parseInt(document.getElementById('advert_voivodeship_id').value),
    city = parseInt(document.getElementById('city_select').value);

    if (!category && !voivodeship && !city) {
        alert('Plaese fill at least one filter value!');
    } else {
        document.getElementById('filter_form').submit();
    }
}

function blockUserAccount(userId) {
    console.log(userId);
}


