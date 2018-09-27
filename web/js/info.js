/**
 * Created by Jolanta on 09.04.2018.
 */

function loadArticles(){
    let xhr = new XMLHttpRequest();
    xhr.overrideMimeType('application/json');
    xhr.open('GET', 'http://127.0.0.1:8000/../../../js/articles.json', true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200 ){
            let json = JSON.parse( xhr.responseText);
            recommended(json);
        }
    };
    xhr.send();
}
function recommended(data){
    console.log(data['1']);
}
loadArticles();