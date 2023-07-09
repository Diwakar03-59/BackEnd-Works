<?php

namespace App\Controller;

use App\model\DbConnect;
use App\model\User;
use App\model\Stock;
use Exception;
use App\Controller\phpValidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class to handle all the routes available in the Music web app. It handle the 
 * routing and the operations involved with that particular route.
 * 
 * @var object $conn
 *    Variable to store the mysqli database connection object.
 * 
 * @var object $stock 
 *    Variable to store the object of the stock class.
 * 
 * @var object $connection_obj 
 *    Variable to store the object od the DbConnect class.
 * 
 * @var object $user 
 *    Variable to store the object of the User class.
 * 
 * @var object $php_obj
 *    Variable to store the object of the phpValidate class.
 */ 
class HomeController extends AbstractController {

  private $conn = '';
  private $stock = '';
  private $connection_obj = '';
  private $user = '';
  private $php_obj = '';

  /**
   * Construction to initialize the objects of the classes used in the 
   * HomeController.
   */
  public function __construct() {
    $this->stock = new Stock();
    $this->connection_obj = new DbConnect();
    $this->conn = $this->connection_obj->connect();
    $this->user = new User();
    $this->php_obj = new phpValidate();
  }

  #[Route('/', name: 'app_login')]
  /**
   * Root Route to handle the user request to the login page.
   *
   * @param Request $request
   *    Stores the credentials entered by the user.
   * 
   * @return Response
   *    If the user credentiaals are valid, it redirect the user to the Home 
   *    page, otherwise redirects the user to the login page. 
   */
  public function login(): Response {
    session_start();
    // Checks if the user is already logged in or not. If logged in, renders the
    // home page.
    if(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      $stock = $this->stock->getStocks();
      $stocks_by_user = $this->stock->getStockByUser($user);
      return $this->render('Muszilla/home.html.twig', ['user' => $user, 
      'stocks' => $stock, 'stock_by_user' => $stocks_by_user]);    
    }
    // Condition to handle the registration of the user.
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      try {
        $data = $_POST;
        $email_error = $this->php_obj->validateEmail($_POST['email']);
        if($email_error == '') {
          $register = $this->user->register($data);
        }
      }
      catch (Exception $e){
        $email_error = $this->php_obj->validateEmail($_POST['email']);
        if ($email_error != '') {
          $error = $email_error;
          return $this->render('Muszilla/login.html.twig', ['error' => $error]);
        }
        $error = $e;
        return $this->render('Muszilla/error.html.twig', ['error' => $error]);
      }
      
    }
    session_destroy();
    return $this->render('Muszilla/login.html.twig');
  }


  #[Route('/', name: 'app_root')]
  /**
   * Root route to handle the condition when the user tries to go back to the 
   * login page after logging in.
   *
   * @return Response
   *    Returns the home page if the user is already logged in, otherwise 
   *    redirects the user to the login page.
   */
  public function root(): Response {
    session_start();
    if(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      $stock = $this->stock->getStocks();
      $stocks_by_user = $this->stock->getStockByUser($user);
      return $this->render('Muszilla/home.html.twig', ['user' => $user, 
      'stocks' => $stock, 'stock_by_user' => $stocks_by_user]);      
    }
    return $this->render('Muszilla/login.html.twig');
  }

  #[Route('/logout', name: 'app_logout')] 
  /**
   * Function the destroy the user session and redirect to the login page if the
   * user wants to log out.
   *
   * @return Response
   *    If the user is logged in, then destroys the user session and redirects
   *    to to the login page, otherwise if not logged in 
   *    redirects to the login page.
   */
  public function logout(): Response {
    session_start();
    if(isset($_SESSION)) {
      session_unset();
      session_destroy();
      return $this->redirectToRoute('app_login');
    }
    return $this->redirectToRoute('app_login');
  }

  #[Route('/register', name: "app_register")] 
  /**
   * Function to render the register page.
   *
   * @param Request $request
   *    Stores the credentials entered by the user.
   * 
   * @return Response
   *    Renders the registration page if the user is not logged in, and asks 
   *    the user to register otherwise, render the home page, if already looged
   *    in.
   */
  public function register(Request $request):Response {
    session_start();
    if(isset($_SESSION['email'])) {
      return $this->redirectToRoute('app_root');
    }
    return $this->render('Muszilla/register.html.twig');
  }

  #[Route('/home', name: 'app_home')]
  /**
   * Function to render the home page to the user, if the user is logged in, and
   * is a valid user.
   *
   * @param Request $request
   *    Stores the credentials provided by the user to log into his account.
   * 
   * @return Response
   *    Renders the home page if the user is logged in, and the credentials are
   *    correct, otherwise renders the error page with a suitable error message.
   *    Renders the login page, if the user is not logged in and tries to go to 
   *    the home page. 
   */
  public function home(Request $request):Response {
    session_start();

    // Handles the condition where the user tries to log in.
    if(!empty($request->request->all())) {
      $email_error = $this->php_obj->validateEmail($_POST['email']);
      $pass_error = $this->php_obj->validatePassword($_POST['password']);
      $user = $request->request->all();
      $user_exist = $this->user->login($user);
      if($user_exist && $email_error == '' && $pass_error == '') {
        $_SESSION['email'] = $request->request->get('email');
        $user = $this->user->getUserData($user['email']);
        $stock = $this->stock->getStocks();
        $stocks_by_user = $this->stock->getStockByUser($user);
        return $this->render('Muszilla/home.html.twig', ['user' => $user, 
        'stocks' => $stock, 'stock_by_user' => $stocks_by_user]);
      }
      elseif ($email_error != '' || $pass_error != '') {
        $error = $email_error;
        $error .= $pass_error;
        return $this->redirectToRoute('app_login', ['error' => $error]);
      }
      else {
        $error = 'User does not exist';
        return $this->render('Muszilla/error.html.twig', ['error' => $error]);
      }
    }

    // Handles the condition where the user is logged in and tries to go to the 
    // Home page. 
    elseif(isset($_SESSION['email'])) {
      $email = $_SESSION['email'];
      $user = $this->user->getUserData($email);
      $stocks_by_user = $this->stock->getStockByUser($email);
      $stock = $this->stock->getStocks();
      return $this->render('Muszilla/home.html.twig', ['user' => $user, 
      'stocks' => $stock, 'stock_by_user' => $stocks_by_user]);
    }
    return $this->redirectToRoute('app_login');
  }

  #[Route('/stock-entry', name: 'app_addStock')]
  /**
   * Function to add stock to the Stocks database.
   *
   * @param Request $request
   *    stores the details of the stock to be added.
   * 
   * @return Response
   *    Renders the home page if the addition of stock is successful, otherwise 
   *    renders error page with a suitable error message.
   */
  public function addStock(Request $request):Response {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(!empty($_POST)) {
        $data = $request->request->all();
        $add = $this->stock->addStock($data, $_SESSION['email']);
        if($add) {
          return $this->redirectToRoute('app_home');
        }
      }
      else {
        $error = 'All fields are mandatory';
        $user = $this->user->getUserData($_SESSION['email']);
        return $this->render('Muszilla/error.html.twig', ['error' => $error, 'user' => $user]);
      }
    }
    else if (isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      $stocks_by_user = $this->stock->getStockDetailsByEmail($_SESSION['email']);
      return $this->render('Muszilla/addStock.html.twig', ['user' => $user, 
      'stock_by_user' => $stocks_by_user]);
    }
    return $this->redirectToRoute('app_login');
  }

  #[Route('/remove', name: 'app_removeStock')]
  /**
   * Route to handle the deletion of a stock previously added by the same user.
   *
   * @param Request $request
   *    Stores the data of the stock to be deleted.
   * 
   * @return Response
   *    Renders the home page if, the deletion of the stock id successfull, 
   *    otherwise returns the error page with a particular error message.
   */
  public function remove(Request $request): Response {
    $data = $_POST;
    $id = $data['id'];
    $remove = $this->stock->removeStock($id);
    if ($remove) {
      return $this->redirectToRoute('app_home');
    }
    $error = 'An errr occured!';
    $user = $this->user->getUserData($_SESSION['email']);
    return $this->render('Muszilla/error.html.twig', ['error' => $error, 'user' => $user]);
  }

  #[Route('/update', name: 'app_updateStock')]
  /**
   * Function to handle the updation of a stock of the user and update the same 
   * in the database.
   *
   * @param Request $request
   *    Stores the details of the stock to be updated.
   * 
   * @return Response
   *    Renders the add stock page where the user can view and 
   *    update the stock details added by him.
   *    On updating the stocks, it renders the add stock page with updated 
   *    details of the user using an AJAX request.
   */
  public function updateStock(Request $request): Response {
    session_start();
    // Checks if the user is logged in and tries to update his stocks. Once 
    // updated it renders the add stock page with updated data, otherwise 
    // renders and error page if there is an error in the data to be updated.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
      $data = $request->request->all();
      $email = $_SESSION['email'];
      $update_stock = $this->user->updateStock($data);
      if($update_stock) {
        return $this->redirectToRoute('app_addStock');
      }
    }
    $user = $this->user->getUserData($_SESSION['email']);
    $stocks_by_user = $this->stock->getStockDetailsByEmail($_SESSION['email']);
    return $this->render('Muszilla/addStock.html.twig', ['user' => $user, 
    'stock_by_user' => $stocks_by_user]);    
  }
}

?>
