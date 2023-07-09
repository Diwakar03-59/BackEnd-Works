<?php

namespace App\Controller;

use App\Controller\registerController;
use App\model\DbConnect;
use App\model\User;
use App\model\Music;
use Exception;
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
 * @var object $music 
 *    Variable to store the object of the Music class.
 * 
 * @var object $connection_obj 
 *    Variable to store the object od the DbConnect class.
 * 
 * @var object $user 
 *    Variable to store the object of the User class.
 * 
 * @var object $upload_obj
 *    Variable to store the object of the uploadCon class.
 */ 
class HomeController extends AbstractController {

  private object $conn = '';
  private object $music = '';
  private object $connection_obj = '';
  private object $upload_obj = '';
  private object $user = '';

  /**
   * Construction to initialize the objects of the classes used in the 
   * HomeController.
   */
  public function __construct() {
    $this->music = new Music();
    $this->connection_obj = new DbConnect();
    $this->conn = $this->connection_obj->connect();
    $this->upload_obj = new UploadCon();
    $this->user = new User();
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
   *    page,
   *    otherwise redirects the user to the login page. 
   */
  public function login(Request $request): Response {
    session_start();
    if(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      return $this->render('Muszilla/home.html.twig', ['user' => $user]);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      try {
        $data = $request->request->all();
        $img = $this->upload_obj->uploadImage($data);
        $register = $this->user->register($data, $img);
      }
      catch (Exception $e){
        $error = $e;
        $user = $this->user->getUserData($_SESSION['email']);
        return $this->render('Muszilla/error.html.twig', ['error' => $error, 'user' => $user]);
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
   *    redirects the user to the home page.
   */
  public function root(): Response {
    session_start();
    if(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      return $this->render('Muszilla/home.html.twig', ['user' => $user]);
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
      $user = $this->user->getUserData($_SESSION['email']);
      return $this->redirectToRoute('app_root', ['user' => $user]);
    }
    session_destroy();
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
   *    Renders the home page if the user is logges in, and the credentials are
   *    correct, otherwise renders the error page with a suitable error message.
   *    Renders the login page, if the user is not logged in and tries to go to 
   *    the home page. 
   */
  public function home(Request $request):Response {
    session_start();

    // Handles the condition where the user tries to log in.
    if(!empty($request->request->all())) {
      $user = $request->request->all();
      $user_exist = $this->user->login($user);
      if($user_exist) {
        $_SESSION['email'] = $request->request->get('email');
        $user = $this->user->getUserData($user['email']);
        $music = $this->music->getMusic();
        return $this->render('Muszilla/home.html.twig', ['user' => $user, 'music' => $music]);
      }
      else {
        $error = 'User does not exist';
        $user = $this->user->getUserData($user['email']);
        return $this->render('Muszilla/error.html.twig', ['error' => $error, 'user' => $user]);
      }
    }

    // Handles the condition where the user is logged in and tries to go to the 
    // Home page. 
    elseif(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      $music = $this->music->getMusic();
      return $this->render('Muszilla/home.html.twig', ['user' => $user, 'music' => $music]);
    }
    return $this->redirectToRoute('app_login');
  }

  #[Route('/add', name: 'app_addmusic')]
  /**
   * Function to add music file to the server repository and the database.
   *
   * @param Request $request
   *    stores the details of the music to be added.
   * 
   * @return Response
   *    Renders the home page if the file upload is successful, otherwise 
   *    renders error page with a suitable error message.
   */
  public function addMusic(Request $request):Response {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if($_FILES['music-file']['error'] == 0) {
        $data = $_POST;
        $cover = $this->upload_obj->uploadImage($_FILES);
        $music = $this->upload_obj->uploadMusic($_FILES);
        $add = $this->user->addMusic($data, $music, $cover);
        $user = $this->user->getUserData($_SESSION['email']);
        return $this->redirectToRoute('app_home');
      }
      else {
        $error = 'All fields are mandatory';
        $user = $this->user->getUserData($_SESSION['email']);
        return $this->render('Muszilla/error.html.twig', ['error' => $error, 'user' => $user]);
      }
    }
    else if (isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      return $this->render('Muszilla/addMusic.html.twig', ['user' => $user]);
    }
    return $this->redirectToRoute('/app_login');
  }

  #[Route('/play/{slug}', name: 'app_play')] 
  /**
   * Function to hanlde the playing of a music file. It takes the id of the
   * music file to be played and plays the same.
   *
   * @param string $slug
   *    Stores the id of the file to be played.
   * 
   * @return Response
   *    Returns the play music page with the requested music playing if the user
   *    is logged in, otherwise renders the log in page.
   */
  public function play(string $slug = NULL):Response {
    session_start();
    if(!isset($_SESSION['email'])) {
      return $this->redirectToRoute('app_login');
    }
    $uri = $_SERVER['REQUEST_URI'];
    $id = substr( $uri, strlen( '/play/' ) );
    $user = $this->user->getUserData($_SESSION['email']);
    $music = $this->music->getMusicById($id);
    return $this->render('Muszilla/play.html.twig', ['user' => $user, 'music' => $music]);
  }

  #[Route('/profile', name: 'app_profile')]
  /**
   * Function to render the Profile details of the user.
   *
   * @return Response
   *    Renders the Profile page, if the user is logged in otherwise redirects 
   *    to the login page.
   */
  public function profile(): Response {
    session_start();
    if(isset($_SESSION['email'])) {
      $user = $this->user->getUserData($_SESSION['email']);
      return $this->render('Muszilla/profile.html.twig', ['user' => $user]);
    }
    return $this->redirectToRoute('app_login');
  }


  #[Route('/update', name: 'app_updateProfile')]
  /**
   * Function to handle the updation of profile of the user and update the same 
   * in the database.
   *
   * @param Request $request
   *    Stores the details of the user to be updated.
   * 
   * @return Response
   *    Renders the update profile page where the user can update his details.
   *    On updating the profile, it renders the Profile page with updated 
   *    details of the user using an AJAX request.
   */
  public function updateProfile(Request $request): Response {
    session_start();
    // Checks if the user is logged in and tries to update his profile. Once 
    // updatted it renders the Profile page with updated data, otherwise renders
    // and error page if there is an error in the data to be updated.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
      $data = $request->request->all();
      $email = $_SESSION['email'];
      $update_profile = $this->user->updateProfile($data, $email);
      if($update_profile) {
        try {
          $_SESSION['email'] = $data['email'];
          $user = $this->user->getUserData($_SESSION['email']);
          return $this->render('Muszilla/prof-section.html.twig', ['user' => $user]);
        }
        catch (Exception $e) {
          $error = $e;
          return $this->render('Muszilla/error.html.twig', ['error' => $error]);
        }     
      }
    }
    $user = $this->user->getUserData($_SESSION['email']);
    return $this->render('Muszilla/updateProfile.html.twig', ['user' => $user]);
    
  }
}

?>

