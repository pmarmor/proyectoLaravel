/**
 * EJECUCIÓN DE FUNCIONES
 */
checkAsideCookie();
/**
 * VARIABLES
 */
let userPagination=document.querySelectorAll('.userPaginationRow')
let sancionar=document.querySelectorAll('.ban')
let banButton=document.getElementById('banButton')
let removeBanButton=document.getElementById('removeBanButton')
/**
 * EVENTOS
 */
if(document.querySelector('.userBanForm')!=null){
    document.querySelector('.userBanForm').addEventListener('submit',banAccount)
    document.querySelector('.removeBanForm').addEventListener('submit',banAccount)
    banButton.addEventListener('click',banAccount)
    removeBanButton.addEventListener('click',removeBan)
}
userPagination.forEach(row => {
    row.addEventListener('click',rowEventHandler,false)
});
sancionar.forEach(row => {
    row.addEventListener('click',banAccount,false)
});
document.getElementById('editIcon').addEventListener('click',uploadImage)
document.getElementById('imgUpload').addEventListener('change',cargarArchivo)

/**
 * Funciones
 */
function muestraAside(){
    let aside=document.querySelector('aside');
    aside.classList.contains('showAside')? aside.classList.remove('showAside')  : aside.classList.add('showAside');
    if(aside.classList.contains('showAside')) document.cookie = "muestraAside=true; path=/";
    else document.cookie = "muestraAside=false; path=/";

}
function checkAsideCookie(){
    let aside=document.querySelector('aside');
    aside.style.transition='0s';
    if(document.documentElement.clientWidth > '725'){
        console.log(getCookie('muestraAside'))
if (getCookie('muestraAside')=='true') {
    aside.classList.add('showAside')
}
else document.cookie = "muestraAside=false; path=/";
    }
setTimeout(()=>{
    aside.style.removeProperty("transition");
},200)
//aside.style.removeProperty("transition");

}
function rowEventHandler(e){
    if(e.target.innerHTML.toLowerCase()=='eliminar'){

    let userId=e.currentTarget.id
    let deleteUser=confirm(`¿Seguro que quieres borrar a este usuario? `)
    let url= e.currentTarget.children[e.currentTarget.children.length -1].children[0].getAttribute('link')
   if(deleteUser) window.location.href=url

}
}
function banAccount(e){
    e.preventDefault()
    if(e.target.classList=='ban'){
        document.getElementById('username').value=e.target.getAttribute('username')
        const date = new Date();
        date.setDate(date.getDate() + 11);
        let day = date.getDate();
        if(day<10)day='0'+day
        let month = date.getMonth() + 1; // Se agrega 1 porque los meses van de 0 a 11
        if(month<10)month='0'+month
        let year = date.getFullYear();
        if(year<10)year='0'+year
        let hour = date.getHours();
        if(hour<10)hour='0'+hour
        let minutes = date.getMinutes();
        if(minutes<10)minutes='0'+minutes
        console.log(document.getElementById('dateTime').value)
        document.getElementById('dateTime').value=`${year}-${month}-${day}T${hour}:${minutes}`
        document.getElementById('usernameRemove').value=e.target.getAttribute('username');
        //document.getElementById('datetime').value=date
    }
    else{
    let userId=e.currentTarget.id
    let form=document.querySelector('.userBanForm')
    let deleteUser=confirm(`¿Seguro que quieres sancionar a este usuario?`)
   if(deleteUser) form.submit();
    }
}
function removeBan(e) {
    e.preventDefault()
    let form=document.querySelector('.removeBanForm')
    let deleteUser=confirm(`¿Seguro que quieres eliminar las sanciones a este usuario?`)
   if(deleteUser) form.submit();
}
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
function uploadImage(e){
    document.getElementById('imgUpload').click();
}
function cargarArchivo(event) {
    const file = event.target.files[0]; // Obtener el archivo seleccionado

    if (file) {
        // Aquí puedes manejar el archivo seleccionado, por ejemplo, subirlo al servidor
        if(document.getElementById('userAvatarPlaceholder'))document.getElementById('userAvatarPlaceholder').src=URL.createObjectURL(file)
        else if(document.getElementById('gameImgPlaceholder'))document.getElementById('gameImgPlaceholder').src=URL.createObjectURL(file)
        console.log('Nombre del archivo:', file.name);
        console.log('Tipo de archivo:', file.type);
        console.log('Tamaño del archivo:', file.size, 'bytes');
        // Aquí puedes implementar lógica para subir el archivo al servidor
    }
}

function goToRegister(e) {
    let aside=document.querySelector('aside');
    if(!aside.classList.contains('showAside'))aside.classList.add('showAside'); 
    document.cookie = "showAside=true";
    let customMessage='seguir'
    if(e.id=='heart') customMessage='dar me gusta'
    document.getElementById('errorDiv').innerHTML=`<span>Inicia sesión para ${customMessage}</span>`
}
