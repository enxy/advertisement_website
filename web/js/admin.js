

function adminDetails(){
    const adminEdit = document.querySelector('.oEdit');
    let  divAdminDetails = document.querySelector('#adminDetails');

    adminEdit.addEventListener('click', function (){
        divAdminDetails.style.display = "block";
        const button = document.querySelector('.close');
        button.addEventListener('click', function () {
            divAdminDetails.style.display="none";
        });
    });
}

function adminForm(){
    let button = document.getElementById('newAdmin'),
        form = document.getElementById('admin-form'),
        buttonC = document.getElementById('cancelNew');

    button.addEventListener('click', function () {
        if(form.style.display === "none"){
            form.style.display="block";
            button.style.display="none";
        }else{
            form.style.display="none";
            button.style.display="block";
        }
    });
    buttonC.addEventListener('click', function (){
        form.style.display="none";
        button.style.display="block";
    });
}

const admin={
    form: adminForm,
    details: adminDetails
};
export default  admin;