let heart=document.getElementById('heart')
let cards=document.querySelectorAll('.favGameCard')
let feedback=document.querySelectorAll('.feedback')
let developing=document.querySelector('.developing')
let finished=document.querySelector('.finished')

if(heart !=null)heart.addEventListener('click',addGameToFav)
if(cards !=null){
    cards.forEach(element => {
        element.addEventListener('click',removeGame)
    });
}
if(feedback !=null){
    feedback.forEach(element => {
        element.addEventListener('click',removeComment)
    });
} 
if(developing !=null){
    developing.addEventListener('click',addFeature)
    developing.addEventListener('keypress',addFeature)
}
if(finished !=null){
    finished.addEventListener('click',addFeature)
    finished.addEventListener('keypress',addFeature)
}
async function addGameToFav(e){ 
    let formData = new FormData();
    formData.append('gameId', gameId);
    formData.append('loggedInUser', loggedInUserId);
    let response = await fetch(buttonToggleURL, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            "X-CSRF-Token": token
        },
        body: formData
    })
    let data = await response.json() 
    console.log('data: ', data);
    if (data === 1) {
        heart.src = heartAssets[0];
    } else {
        heart.src = heartAssets[1];
    }
    console.log(data);
}
async function removeGame(e){
    let id=e.currentTarget.id
    if(e.target.classList=='binIcon'){
        console.log('click')
    let formData = new FormData();
    formData.append('gameId', id);
   fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            "X-CSRF-Token": token
        },
        body: formData
    }) ;
    e.currentTarget.style.animation='fadeOut 0.7s forwards';
    }
}
async function removeComment(e){
    let id=e.currentTarget.id
    if(e.target.classList=='binIcon'){
        let url=e.target.getAttribute('link')
    let formData = new FormData();
    formData.append('feedbackId', id);
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            "X-CSRF-Token": token
        },
        body: formData
    }) 
    e.currentTarget.style.animation='fadeOut 0.7s forwards';
    }
}

/*
function addFeature(e) {
    let devContent=document.getElementById('developingContent')
if(e.which==13){
    if(e.currentTarget.classList=='developing'){
        let element=document.createElement('div')
        let button=document.createElement('button')
        button.setAttribute('class','deleteButton')
        button.textContent='eliminar'
        element.textContent=e.target.value
        element.append(button)
        devContent.appendChild(element)
    }
}
}*/