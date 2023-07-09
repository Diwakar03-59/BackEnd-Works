jQuery(function($) {
  /**
   * Onclick function to make an AJAX call to update the user profile and update 
   * the databse accordingly if all the fiels are filled properly, otherwise 
   * renders a proper message. It renders the profile page after successful 
   * udation of the profile.
   */
  $('#update-profile').click(function(e){
    e.preventDefault();    
    var phone = $('#contact').val();
    var email = $('#email').val();
    var selected = [];
    var interest = $("input[type=checkbox]:checked").length;
    var genre = $('input[type=checkbox]:checked').each(function () {
                if (this.checked)
                  selected.push($(this).val());
                });
    if(phone == '' || email == '' ) {
      alert('All fields are required');
    }
    else if(!interest) {
      $('#checkInterest').html("You must check at least one checkbox.");
    }
    else {
      $.ajax({url: "/update", 
              type: 'POST',
              data: {contact: phone, email: email, interest: selected},
              success: function(result){
                alert(result);
                $('.banner-container').html(result);
              }});
    }
    
  }); 
});

