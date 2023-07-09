jQuery(function($) {
  /**
   * Function to handle the updation of a player using AJAX call and updates the 
   * home page with the updated data in the database. Makes an AJAX call to the
   * update.php function and renders the updated data on 
   * the home page. 
   */
  $('.button_two').click(function(e){
    e.preventDefault();
    var name = $('#name').val();
    var runs = $('#runs').val();
    var balls = $('#balls').val();
    var id = $(this).val();
    if(id != '' && name != '' && runs != '' && balls != '') {
      $.ajax({url: "update.php", 
      type: 'POST',
      data: {id: id, name: name, runs: runs, balls: balls},
      success: function(result){
        window.location = "http://www.local-ipl.com/index.php";
      }});
    }
    else {
      $('.error').html('<p>Please fill the fields</p>');
    }
   
  });

  /**
   * Function to delete the details of the player added by the admin. On 
   * successfull deletion, renders the index page with updated data of the
   *  players using an AJAX request to the delete.php page.
   */
  $('.button_one').click(function(e){
    e.preventDefault();
    var id = $(this).val();
    $.ajax({url: "delete.php", 
              type: 'POST',
              data: {id: id},
              success: function(result){
                window.location = "http://www.local-ipl.com/index.php";
              }});
  });

  /**
   * Function to find the man of the match of the game and upadate the home page
   *  accordingly by doing an AJAX call to the man.php file.
   */
  $('.man_of_the_match').click(function(e){
    e.preventDefault();
    $.ajax({url: "man.php", 
              success: function(result){
                $('.man_natch').html('<p>'+result+'</p>');
              }});
  });

})
