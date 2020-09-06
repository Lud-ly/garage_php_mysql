<?php
require 'database.php';
session_start();
   
      $email = $password = $error = "";

  if(!empty($_POST)){
      
      $email             = checkInput($_POST['email']);
      $password          = checkInput($_POST['password']);
      
      $db = Database::connect();
      $statement = $db->prepare("SELECT * FROM users WHERE email = ? and password = ?"); 
      $statement->execute(array($email,$password));
      Database::disconnect();
      
      
      if($statement->fetch()){
          
          $_SESSION['email'] = $email;
          header("Location: index.php");
    }
      else{
          $error = "Votre mot de passe ou email sont incorrects";
      }
}

function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
    <head>
    <title>MonsterGarage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
   <link rel="stylesheet" href="../Styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Rock+Salt&display=swap" rel="stylesheet" type="text/css">
    </head>
    
    
    
    <body>
       <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span> Monster <span class="g">G</span>arage  <span class="glyphicon glyphicon-leaf"></span></h1>
            <div class="container admin">
              <div class="row">
                <h1><strong>Login </strong></h1>
                      <br>
                   <a class="btn btn-default" href="/index.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                      <form class="form" role="form" action="login.php" method="post">
                          <div class="form-group">
                              <label for="name">Email : </label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $email; ?>">
                              
                           </div>
                       <div class="form-group">
                              <label for="password">Mot de passe : </label>
                              <input type="password" class="form-control" id="password" name="password"  value="<?php echo $password; ?>" placeholder="Mot de passe">
                        </div>
                       <span class="help-inline"><?php echo $error; ?></span>
                       <div class="form-actions">
                        <button type="submit" class="btn btn-success"> Se connecter</button> 
                      </div>
                    </form>
                  </div>
            </div>
       </body>
</html>