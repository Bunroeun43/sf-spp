console.log('ca marche');
let $selection = document.querySelector('#prix');
console.log($selection);

  let range = new Range();
  range.setStart($selection, start.value);
  range.setEnd($selection, end.value);

  // toString d'une plage renvoie son contenu sous forme de texte
  console.log(range); // ll