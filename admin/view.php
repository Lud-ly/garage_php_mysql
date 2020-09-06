<?php

  session_start();
  if(!isset($_SESSION['email'])){
    
    header("Location: login.php");
}

  require 'database.php';

  if(!empty($_GET['id'])){
    
      $id = checkInput($_GET['id']);
  }

   $db = Database::connect();
   $statement = $db->prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category
                                                   FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');

  $statement->execute(array($id));
  $item = $statement->fetch();
  Database::disconnect();


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
                  <div class="col-sm-6">
                       <h1><strong>Voir un item </strong></h1>
                      <br>
                       <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                      <br/>
                      <form>
                        <div class="form-group">
                            <label>Nom : </label><?php echo '  ' . $item['name']; ?>
                        </div>
                           <div class="form-group">
                            <label>Description : </label><?php echo '  ' . $item['description']; ?>
                        </div>
                           <div class="form-group">
                            <label>Prix : </label><?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' €'; ?>
                        </div>
                           <div class="form-group">
                            <label>Catégorie : </label><?php echo '  ' . $item['category']; ?>
                        </div>
                           <div class="form-group">
                            <label>Image : </label><?php echo '  ' . $item['image']; ?>
                        </div>
                      </form>
                      <br>
                       <div class="form-actions">
                       </div>
                  </div>
                  
                  
            <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/' .  $item['image'] ; ?>" alt="...">
                          <div class="price"><?php echo number_format((float)$item['price'],2,'.','') . ' €'; ?></div>
                            <div class="caption">
                                    <h4><?php echo $item['name']; ?></h4>
                                    <p><?php echo $item['description']; ?></p>
                                    <a href="http://www.lacentrale.fr" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Chercher</a>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    
    </body>
    
</html>