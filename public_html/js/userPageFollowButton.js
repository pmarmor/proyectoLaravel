let buttonText = {
    unfollow: 'Dejar de seguir',
    follow: 'Seguir',
    edit: 'Editar información'
};
let continuar=true;
let url = window.location.href;
visitedUser = url.split('/') //almacena la id del usuario cuya página estamos visualizando
visitedUser = visitedUser[visitedUser.length - 1]
console.log(userFollows)
let buttonToggle = document.getElementById('buttonToggle');
if (userFollows!=null && userFollows.indexOf(parseInt(visitedUser)) > -1 ) {
    buttonToggle.innerHTML = buttonText.unfollow
    buttonToggle.classList.add('unfollow')
}
else if(userFollows!=null) buttonText.indexOf = buttonText.follow;
if(buttonToggle!=null)buttonToggle.addEventListener('click', handleFollow)


async function handleFollow() {
    if(continuar){
        continuar=false;
        setInterval(()=>{
            continuar=true;
        }
        ,1000);
        let followersFollow= document.querySelector('.userFollowersyFollow').children[0].innerHTML
    console.log('followersFollow: ', followersFollow);
    
    followersFollow=followersFollow.split(': ');
    let formData = new FormData();
    formData.append('visitedUser', visitedUser);
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
    if (data == 1) {
        let value=parseInt(followersFollow[1])+1
        buttonToggle.innerHTML = buttonText.unfollow
        document.querySelector('.userFollowersyFollow').children[0].innerHTML='Seguidores: '+value
        buttonToggle.classList.add('unfollow')
    }
    else {
        let value=parseInt(followersFollow[1])-1
        buttonToggle.innerHTML = buttonText.follow
        document.querySelector('.userFollowersyFollow').children[0].innerHTML='Seguidores: '+ value
        if(value<1) value=0
        buttonToggle.classList.remove('unfollow')
    }
    }
    
}