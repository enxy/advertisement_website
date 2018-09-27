/**
 * Created by Jolanta on 02.06.2018.
 */
var articlesModule = (function(){
    var saveChanges = function() {
        var article = '<div id="article">' + document.querySelector('#article').innerHTML + '</div>';
        var path = '/panel_informacyjny/prasa/'+ document.querySelector('#filename').value;
        var data = 'article=' + article;
        console.log(article);
        console.log(path);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', path);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(data);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                alert("Dane zostaly zaktualizowane");
            }
        }
    };
    var editMode = function() {
        var saveButton = document.querySelector('.save_button');
        var editButton = document.querySelector('.edit_mode');


        if (saveButton.style.display == 'block') {
            saveButton.style.display = 'none';
            editButton.innerText = 'Włącz edycję';
            alert('Tryb edycji wyłączony.');
        } else {
            saveButton.style.display = 'block';
            editButton.innerText = 'Wyłącz edycję';
            alert('Tryb edycji wlaczony. Aby edytowac, kliknij tresc strony!');
        }



    };
    return {
        saveChanges: saveChanges,
        editMode: editMode
    }
})();
