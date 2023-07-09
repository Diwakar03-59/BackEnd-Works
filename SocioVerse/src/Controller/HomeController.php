<?php

namespace App\Controller;

use App\model\uploadCon;
use App\model\dbConnect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response as FlexResponse;

class HomeController extends AbstractController{

  #[Route('/register/{slug}', name: 'app_register')]
  /**
   * Function to render the register page.
   * @return Response
   */
  public function Register(string $slug = NULL): Response {
    $register = 'Register page';
    return $this->render('SocioVerse/register.html.twig', 
    ['title' => $register]);    
  }

  #[Route('/forgot', name: 'app_forgot_password')]
  public function Forgot(): Response {
    return $this->render('SocioVerse/forgot.html.twig', 
    []);
  }
  
  #[Route('/logout', name: 'app_logout')]
  /**
   * Function to implement logout functionality.
   *
   * @return Response
   */
  public function Logouut(): Response {
    $d = new dbConnect;
    session_start();
    if(isset($_SESSION['logged'])) {
      echo 'Logout Page';
      session_unset();
      session_destroy();
      return $this->render('SocioVerse/login.html.twig');
    }
    return $this->render('SocioVerse/login.html.twig');
  }


  #[Route('/loadmore/{slug}', name: 'app_loadmore')]
  /**
   * Function to implement loadmore posts functionality using AJAX.
   * $conn2 - Stores the next 10 posts be to rendered.
   * $current - Strores the details of the current user.
   *
   * @return Response
   */
  public function load(string $slug = NULL): Response {

    session_start();
    if(isset($_SESSION['logged'])) {
      $obj = new dbConnect;
      $uri = $_SERVER['REQUEST_URI'];
      $id = substr($uri, strlen($uri)-1);
      $conn2 = $obj->loadmore($id);
      $current = $obj->getCurrentUser($_SESSION['email']);
      return $this->render('SocioVerse/update.html.twig',
      ['moreposts' => $conn2, 'user' => $current]);

    }
    return $this->render('SocioVerse/home.login.twig');
  }

  #[Route('/home', name: 'app_home')]
  /**
   * Function to render various edge cases on home page.
   *
   * @return Response
   */
  public function Home(): Response {
    session_start();
    // Condition for signup, when the user registers.
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['cpassword'])) {
      session_destroy();
      $obj = new dbConnect;
      $data = [];
      $data[] = $_POST['fname'];
      $data[] = $_POST['lname'];
      $data[] = $_POST['email'];
      $data[] = $_POST['cpassword'];
      $imgobj = new uploadCon;
      $img = "/" . $imgobj->uploadImage($_POST);
      $data[] = $img;
      $register = $obj->signup($data);
      if($register) {
        echo "<script>alert('Account Created. Please Login!')</script>";
        return $this->render('SocioVerse/login.html.twig', []);
      }
      else {
        return $this->render('SocioVerse/login.html.twig', []);
      }
    }

    // Condition for login, when the user logs in.
    elseif ((($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['password'])) ) {
      //session_start();
      $obj = new dbConnect;
      $data = [];
      $data[] = $_POST['email'];
      $data[] = $_POST['password'];
      $login = $obj->login($data);
      if ($login) {
        $conn = $obj->getAllPosts();
        $current = $obj->getCurrentUser($data[0]);
        
        $_SESSION['logged'] = TRUE;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['profile'] = TRUE;
        $_SESSION['user'] = $data;
        return $this->render('SocioVerse/home.html.twig',
        ['posts' => $conn, 'user' => $current]);
      }
      else {
        echo "<script>alert('Invalid Credentials!!')</script>";
        return $this->render('SocioVerse/login.html.twig', []);
      }
    }

    // Condition to handle the case when the user posts a Post.
    elseif(isset($_POST['data'])) {
      // session_start();
      $obj = new dbConnect;
      $data = [];
      $email = $_SESSION['email'];
      $data[] = $email; 
      $data[] = $_POST['data'];
      
      $imgobj = new uploadCon;
      $img = "/" . $imgobj->uploadImage($_POST);
      $data[] = $img;
      $add = $obj->addPost($data);
      if ($add) {
        $conn = $obj->getAllPosts();
        $current = $obj->getCurrentUser($email);
        return $this->render('SocioVerse/home.html.twig', 
        ['posts' => $conn, 'user' => $current]);
        
      }
    } 

    // Condition to handle the edge case where the user is logged in traversing between different pages.
    elseif(isset($_SESSION['logged']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
      //echo 'me logged';
      $obj = new dbConnect;
      $email = $_SESSION['email'];
      $conn = $obj->getAllPosts();
      $current = $obj->getCurrentUser($email);
      $_SESSION['updated'] = TRUE;
      $conn = $obj->getAllPosts();
      $current = $obj->getCurrentUser($email);
      return $this->render('SocioVerse/home.html.twig', 
      ['posts' => $conn, 'user' => $current]);
    } 

    else {
      session_destroy();
      return $this->render('SocioVerse/login.html.twig');
    }
    //return $this->render('SocioVerse/login.html.twig');
  }

  #[Route('/profile', name: 'app_ok')] 
  /**
   * Function to render various edge cases on profile page.
   *
   * @return Response
   */
  public function profile(): Response {
    // Condition to handle the updation of user profile.
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emailID'])) {
      session_start();
      $data = [];
      $data[] = $_POST['fname'];
      $data[] = $_POST['lname'];
      $data[] = $_POST['emailID'];
      $imgobj = new uploadCon;
      $obj = new dbConnect;
      $email = $_POST['emailID'];
      $_SESSION['email'] = $email;
      $img = "/" . $imgobj->uploadImage($_POST);
      $data[] = $img;
      $upd = $obj->updateProfile($data);
      if ($upd) {
        $current = $obj->getCurrentUser($email);
        return $this->render('SocioVerse/profile.html.twig',
        ['user' => $current]);
      }
    }
    // Condition to handle the edge case where the user is logged in traversing between different pages.
    elseif($_SERVER['REQUEST_METHOD'] != 'POST') {
      session_start();
      if(isset($_SESSION['user'])) {
        $obj = new dbConnect;
        $email = $_SESSION['email'];
        $_SESSION['email'] = $email;
        $current = $obj->getCurrentUser($email);
        return $this->render('SocioVerse/profile.html.twig',
        ['user' => $current]);
        }
      }
    return $this->render('SocioVerse/login.html.twig');
  }
  
  #[Route('/{slug}', name: 'app_login')]
  /**
   * Function to render various edge cases on login page.
   *
   * @return Response
   */
  public function HomePage(string $slug = NULL): Response {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      return $this->render('SocioVerse/login.html.twig');
    }
    elseif (isset($_SESSION['email'])) {
      $obj = new dbConnect;
      $email = $_SESSION['email'];
      $conn = $obj->getAllPosts();
      $current = $obj->getCurrentUser($email);
      return $this->render('SocioVerse/home.html.twig', 
      ['posts' => $conn, 'user' => $current]);
    }
  }
  
}

?>
