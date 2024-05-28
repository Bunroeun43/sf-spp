// On sélectionne 
var $fcartemere = $('#configurateur_cartemere');
// quand la carte mère est sélectionnée
console.log($fcartemere);
$fcartemere.change(function() {
  // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
//   var $form = $(this).closest('form');
  // Simulate form data, but only include the selected sport value.
  var data = {};
  data[$fcartemere.attr('name')] = $fcartemere.val();
  // Submit data via AJAX to the form's action path.
  console.log(data);
  $.ajax({
    url : $form.attr('action'),
    type: $form.attr('method'),
    data : data,
    complete: function(html) {
      // Replace current position field ...
      $('#configurateur_processeur').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_processeur')
      );
      $('#configurateur_typememoire').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_typememoire')
      );
      // Position field now displays the appropriate positions.
      $('#configurateur_boitier').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_boitier')
      );
      $('#configurateur_cartegraphique').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_cartegraphique')
      );
      $('#configurateur_cartegraphique2').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_cartegraphique2')
      );
      $('#configurateur_disquem2').replaceWith(
        // ... with the returned one from the AJAX response.
        $(html.responseText).find('#configurateur_disquem2')
      );
    }
  });
});