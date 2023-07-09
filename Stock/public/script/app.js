/**
 * This function is responsible for validating the first name entered by the 
 * user.
 * 
 * @var regex 
 *    This is the variable for storing the valid pattern.
 * 
 * @var fnamevalue 
 *    This is the variable for storing the first name entered by the user.
 */
function validateFirstName() {
  var fnamevalue = document.getElementById("fname").value;
  var regex = /^[A-Za-z]+$/;
  if (!fnamevalue.match(regex)) {
    document.getElementById("checkfname").innerHTML =
      "*Only letters are allowed!!";
    document.getElementById("submit").disabled = true;
  } 
  else {
    document.getElementById("checkfname").innerText = "";
    document.getElementById("submit").disabled = false;
  }
}

/**
 * This function is responsible for validating the last name entered by the user.
 * @var regex 
 *    This is the variable for storing the valid pattern.
 * @var lnamevalue 
 *    This is the variable for storing the last name entered by the user.
 */
function validateLastName() {
  var lnamevalue = document.getElementById("lname").value;
  var regex = /^[A-Za-z]+$/;
  if (!lnamevalue.match(regex)) {
    document.getElementById("checklname").innerHTML =
      "*Only letters are allowed!!";
    document.getElementById("submit").disabled = true;
  } 
  else {
    document.getElementById("checklname").innerText = "";
    document.getElementById("submit").disabled = false;
  }
}

/**
 * This function is responsible for validating the email entered by the user.
 * @var regex
 *    This is the variable for storing the valid pattern.
 * @var mail 
 *    This is the variable for storing the email entered by the user.
 */
function validateEmail() {
  var mail = document.getElementById("email").value;
  var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (!mail.match(regex)) {
    document.getElementById("checkemail").innerHTML =
      "*Enter a valid email address!!";
    document.getElementById("submit").disabled = TRUE;
  } 
  else {
    document.getElementById("checkemail").innerHTML =
      '<span style="color:green">This email address is valid !!</span>';
    document.getElementById("submit").disabled = FALSE;
  }
}

/**
 * This function is responsible for validating the login password entered by 
 * the user.
 * 
 * @var regex
 *    This is the variable for storing the valid pattern.
 * 
 * @var password 
 *    This is the variable for storing the password entered by the user.
 */
function loginPasswordValidate() {
  var password = document.getElementById("password").value;
  var regex =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
  if (!password) {
    document.getElementById("checkpass").innerHTML = 
    '<span style="color:red">Password is required !!</span>';
    document.getElementById("submit").disabled = TRUE;
  }
  else if (!password.match(regex)) {
    document.getElementById("checkpass").innerHTML =
      "*Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character.";
    document.getElementById("submit").disabled = TRUE;
  }
  else {
    document.getElementById("checkpass").innerHTML =
      '<span style="color:green">This password is valid !!</span>';
  }
}

/**
 * This function is responsible for validating the password format entered by 
 * the user. If the password format is invalid, it sets the incorrect message 
 * to the respective error element.
 * 
 * @var regex
 *    This is the variable for storing the valid pattern.
 * 
 * @var password 
 *    This is the variable for storing the password entered by the user.
 */
function validatePassword() {
  var password = document.getElementById("password").value;
  var cpassword = document.getElementById("cpassword").value;
  var regex =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
  if (!password || !cpassword) {
    document.getElementById("checkpass").innerHTML =
      '<span style="color:red">Password is required !!</span>';
    document.getElementById("submit").disabled = TRUE;
  }
  else if (!password.match(regex) && !cpassword.match(regex)) {
    document.getElementById("checkpass").innerHTML =
      "*Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character.";
    document.getElementById("submit").disabled = TRUE;
  }
  else if (password != cpassword){
      document.getElementById("checkpass").innerHTML =
        "*Passwords do not match";
      document.getElementById("submit").disabled = TRUE;
  }
  else {
    document.getElementById("checkpass").innerHTML =
      '<span style="color:green">This password is valid !!</span>';
  }
}
