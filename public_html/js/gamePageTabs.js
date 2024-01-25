
function toggleTabs(e) {
    console.log(e.target.id)
    let array = ['one', 'three']
    let contador = 0
    nav.forEach(element => {
        if (element.id != e.target.id) {
            element.classList.remove('active')
            console.log(array[e.target.id])
            document.getElementById(array[contador]).style.display = 'none'
        }
        else {
            element.classList.add('active')
            document.getElementById(array[contador]).style.display = 'flex'
        }
        contador++
    });
    if (typeof array['feedback'] != 'undefined') console.log('ok')
}
let nav = document.querySelector('nav').children
nav = Array.from(nav)
nav.forEach(element => {
    element.addEventListener('click', toggleTabs)
});