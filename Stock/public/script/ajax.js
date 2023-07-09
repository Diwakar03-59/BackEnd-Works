jQuery(function($) {
  /**
   * Function to handle the deletion of a stock using AJAX call and updates the 
   * home page with the updated data in the database. Makes an AJAX call to the
   * removeStock function of the HomeController and renders the updated data on 
   * the home page. 
   */
  $('.button_two').click(function(e){
    e.preventDefault();
    var id = $(this).val();
    $.ajax({url: "/remove", 
              type: 'POST',
              data: {id: id},
              success: function(result){
                $('.playback-container').html(result);
              }});
  });

  /**
   * Function to update the details of the stock added by the user. On 
   * successfull updation, renders the add profile page with updated data of the
   *  stocks using an AJAX request to the updateStock function of the 
   * Controller. 
   */
  $('.button_one').click(function(e){
    e.preventDefault();
    var id = $(this).val();
    var name = $('#stock-name').val();
    var price = $('#price').val();
    alert(name);
    $.ajax({url: "/update", 
              type: 'POST',
              data: {id: id, name: name, price, price},
              success: function(result){
                $('.banner-container').html(result);
              }});
  });
});
