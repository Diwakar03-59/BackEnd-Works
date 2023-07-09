jQuery(function($) {

  /**
   * The function checks if the parking form is filled or not.
   * If not, it asks the user to fill the form to proceed, otherwise 
   * makes an AJAX call to the controller to book a parking slot 
   * and updates the home page accordingly.
   */
  $('#submit').click(function(e){
    e.preventDefault();
    var vehiclenumber = $('#vehiclenumber').val();
    var vehicletype = $('input[name="vehicletype"]').filter(":checked").val();

    // Condition to handle whether the parking form is filled by the user
    // or not. 
    if (vehiclenumber == '') {
      alert('Please fill the form');
    }

    // AJAX call to the controller to book a parking slot. Passes the vehicle
    // number and vehicle type as data to the controller and after getting a
    // response renders the updated tickets on the home page.
    else {
      $.ajax({url: "/book", 
              type: 'POST',
              data: {vehiclenumber: vehiclenumber, vehicletype: vehicletype},
              success: function(result){
                alert(result);
                $('.container').html(result);
              }});
    }
    
  });

  /**
   * The function checks if the release form is filled or not.
   * If not, it asks the user to fill the form to proceed, otherwise 
   * makes an AJAX call to the controller to release the parking slot 
   * based on the slot id and updates the home page accordingly.
   */
  $('#release').click(function(p){
    p.preventDefault();
    var id = $('#slotID').val();
    // Checks if the user has given the slot id to be released or not.
    if (id == '') {
      alert('Please provide the slot to be released!');
    }

    // AJAX call to the controller to release a vehicle from parking area.
    // Passes the slot id as data to the route and after getting the response
    // renders the updated tickets list on the home page.  
    else {
      $.ajax({url: "/release", 
              type: 'POST',
              data: {id: id},
              success: function(result){
                if(result == 'Please book a slot first') {
                  alert(result);
                }
                else{
                  alert(result);
                  $('.container').html(result);
                }                
              }});
    }
  });
});
