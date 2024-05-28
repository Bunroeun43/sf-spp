// Script pour les composants


console.log('Ca marche !!!');


console.log(composant);

function etape1() {
    let composant = document.querySelector('#composant');
    composant.addEventListener('change', etape2);
    // console.log(composant.value);
}

etape1();

function etape2() {

    let choice = composant.value;
    console.log(choice);
    if (choice == 'psu') {
        console.log('alimentation');
        window.location.replace('http://localhost:8000/alimentation/');
    }
    if (choice == 'case') {
        window.location.replace('http://localhost:8000/boitier/');
        console.log('boitier');
    }
    if (choice == 'cpu') {
        window.location.replace('http://localhost:8000/processeur/');
    }
    if (choice == 'mb') {
        window.location.replace('http://localhost:8000/carte/mere/');
    }
    if (choice == 'cpu') {
        window.location.replace('http://localhost:8000/processeur/');
    }
    if (choice == 'ram') {
        window.location.replace('http://localhost:8000/memoire/');
    }
    if (choice == 'cg') {
        window.location.replace('http://localhost:8000/carte/graphique/');
    }
    if (choice == 'dd') {
        window.location.replace('http://localhost:8000/disque/');
    }
}