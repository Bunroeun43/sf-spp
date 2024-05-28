console.log('ca marche');

let nomConfig = '';
let buttonValider = document.querySelector('#valider');


buttonValider.addEventListener('click', etape1);

function etape1() {
    let nomconfig = document.querySelector('#nomconfig');
    console.log('etape1');
    console.log(nomconfig);
}
