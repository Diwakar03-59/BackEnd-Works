<?php 
require_once 'php_validate.php';
require_once 'admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="home.css">
  <script src="ajax.js"></script>
  <script lang="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
</head>
<body>

<?php

session_start();
$username = '';
$admin = new Admin();
$player_data = $admin->getPlayers();

// Checks if it is a admin login or user login. If admin sets the Session 
// variable, which is used later.
if(isset($_SESSION['user'])) {
  $username = $_SESSION['user'];
}

?>

<div class="navbar">
  <div class="page-wrapper">
    <div class="nav">
        <div class="nav-logo">
          <a href="#"><img src="" alt="">IPLZilla</a>
        </div>
        <ul class="nav-ul">
          <?php

          // If it is an admin login, the email of the admin is rendered, 
          // otherwise a login button is rendered.
          if(isset($_SESSION['user'])) {?>
            <li><a href=""><?php echo $username; ?></a></li>
          <?php 
          } 
          else { ?>
            <li><a href="login.php">Login</a></li>
          <?php } ?>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Sign Out</a></li>
        </ul>
    </div>
  </div>
</div>


<?php if($player_data) { ?>
  <h2>SCORECARD: </h2>
    <table>
      <thead>
        <tr>
          <th>Player name</th>
          <th>Runs Scored</th>
          <th>Balls Played</th>
          <th>Strike Rate</th>
          <th>Operation</th>
        </tr>
      </thead>
      
      <tbody>
        <?php 
        foreach($player_data as $player) { 
          // Checks for the admi login, if it is an admin login, provides him 
          // with update and deletion feature, otherwise renders the player 
          // details without admin features. 
          if(isset($_SESSION['user'])) {
          ?>
            <tr>
              <td><input id="name" type="text" value="<?php echo $player['name'] ?>" placeholder="Name" required></td>
              <td><input id="runs" type="text" value="<?php echo $player['runs'] ?>" placeholder="Runs Scored" required></td>
              <td><input id="balls" type="text" value="<?php echo $player['balls'] ?>" placeholder="Balls Faced" required></td>
              <td><input type="text" readonly value="<?php echo $player['strike_rate'] ?>" placeholder="Strike Rate"></td>
              <span id="error" style="color: red;"></span>
              <td>
                <button id="<?php echo $player['id']?>" value="<?php echo $player['id']?>" type="submit" class="button_two">Update</button>
                <button type="submit" id="<?php echo $player['id']?>" value="<?php echo $player['id']?>" class="button_one">Delete</button>
              </td>
            </tr>
          <?php 
          }
          else { ?>
            <tr>
              <td><input type="text" value="<?php echo $player['name'] ?>" placeholder="Name" readonly required></td>
              <td><input type="text" value="<?php echo $player['runs'] ?>" placeholder="Runs Scored" readonly required></td>
              <td><input type="text" value="<?php echo $player['balls'] ?>" placeholder="Balls Faced" readonly required></td>
              <td><input type="text" readonly value="<?php echo $player['strike_rate'] ?>" placeholder="Strike Rate"></td>
            </tr>
          <?php }} ?>
      </tbody>
    </table>
    
    <?php 

    // Checks if the admin is logged in or not, if not renders the Man of the 
    // match button.
    if(!isset($_SESSION['user'])) { ?>
      <button type="submit" class="man_of_match">Man of the Match</button>
      <span class="man_match"></span>
    <?php 
    }
    ?>

    <?php 
    
    // Checks if the the admin is logged in or not, if logged in gives him the 
    // funtionality of adding the players.
    if(isset($_SESSION['user'])) { ?>
      <form action="add.php" method="post">
        Player Name:
        <input type="text" class="" id="name" name="name" required placeholder="Player Name">
        <span style="color: red;">*</span>
        <br>
        <br><br>
        Score:
        <input type="text" class="" id="score" name="score" required placeholder="Score">
        <span style="color: red;">*</span>
        <br>
        <br><br>
        Balls Played:
        <input type="text" class="" id="balls" name="balls" required placeholder="Balls Played">
        <span style="color: red;">*</span>
        <br>
        <br><br>
        <div class="flex">
          <input class="login" type="submit" name="submit" id="submit" value="Add">
        </div>
      </form>
    <?php 
    }
  } 

?>
</body>
</html>
