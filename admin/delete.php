<?php
session_start();
  if(!isset($_SESSION['email'])){
    
    header("Location: login.php");
}

require 'database.php';

 if(!empty($_GET['id'])){
    
     $id = checkInput($_GET['id']);
 } 
  if(!empty($_POST)){ 
     
      $id = checkInput($_POST['id']);
      $db = Database::connect();
      $statement = $db->prepare("DELETE FROM items WHERE id = ?");
      $statement->execute(array($id));
      Database::disconnect();
      header("Location: index.php");
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
                <h1><strong>Supprimer un item :</strong></h1>
                      <br>
                  <form class="form" role="form" action="delete.php" method="post">
                       <input type="hidden"  name="id" value="<?php echo $id;  ?>"/> 
                     <p class="alert alert-warning">Etes vous sûr de vouloir supprimer cet item ? </p>
                       <div class="form-actions">
                        <button type="submit" class="btn btn-warning"><span style="color:green" class="glyphicon glyphicon-ok"></span> Oui</button>   
                         <a class="btn btn-primary" href="index.php"><span style="color:red" class="glyphicon glyphicon-remove"></span>Non</a>
                       </div>
                    </form>
                  </div>
            </div>
         
    
    </body>
    
</html>