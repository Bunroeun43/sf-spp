var $memoire = $('#configurateur_processeur');
console.log($memoire);
// When sport gets selected ...
$memoire.change(function() {
  // ... retrieve the corresponding form.
    var $formMem = $(this).closest('form');
//   var $form = $(this).closest('form');
  // Simulate form data, but only include the selected sport value.
  var dataMem = {};
  dataMem[$memoire.attr('name')] = $memoire.val();
  // Submit data via AJAX to the form's action path.
  console.log(dataMem);
  $.ajax({
    url : $formMem.attr('action'),
    type: $formMem.attr('method'),
    data : dataMem,
    complete: function(htmlMem) {
      // Replace current position field ...
      $('#configurateur_memoire').replaceWith(
        // ... with the returned one from the AJAX response.
        $(htmlMem.responseText).find('#configurateur_memoire')
      );
      // Position field now displays the appropriate positions.
    }
  });
});