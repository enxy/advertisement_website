import admin from "./admin.js";

const addAdmin = document.getElementById('newAdmin');
addAdmin.addEventListener('click', function(){
    admin.form();
});

let adminEdit = document.getElementsByClassName('oEdit');
adminEdit[0].addEventListener('click', function(){
    import('./admin.js').then(
        admin.details(),
    );
});


