<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $.ajax({
        url: 'api.json',
        type: "GET",
        success: function(data) {
          console.log(data)
          //$('#data').append(data.data[0])
        }
      })
    })
  </script>