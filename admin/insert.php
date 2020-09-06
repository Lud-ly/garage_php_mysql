<?php
 session_start();
  if(!isset($_SESSION['email'])){
    
    header("Location: login.php");
}

require 'database.php';

   
    $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";
  if(!empty($_POST)){
      
      $name             = checkInput($_POST['name']);
      $description      = checkInput($_POST['description']);
      $price            = checkInput($_POST['price']);
      $category         = checkInput($_POST['category']);
      $image            = checkInput($_FILES['image']['name']);
      $imagePath        = '../images/'  . basename($image);
      $imageExtension   =pathinfo($imagePath,PATHINFO_EXTENSION);
      $isSuccess        = true; 
      $isUploadSuccess  = false;
      
      if(empty($name)){
          $nameError = 'Ce champ ne  peut être vide';
          $isSuccess = false;
      }
      if(empty($description)){
          $descriptionError = 'Ce champ ne  peut être vide';
          $isSuccess = false;
      }
      if(empty($price)){
          $priceError = 'Ce champ ne  peut être vide';
          $isSuccess = false;
      }
      if(empty($category )){
          $categoryError = 'Ce champ ne  peut être vide';
          $isSuccess = false;
      }
      if(empty($image )){
          $imageError = 'Ce champ ne  peut être vide';
          $isSuccess = false;
      }
      else{
          $isUploadSuccess = true;
          if($imageExtension !="jpg" && $imageExtension !="png" && $imageExtension !="jpeg" && $imageExtension !="gif"){
              
               $imageError = "les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
               $isUploadSuccess = false;
          }
          if(file_exists($imagePath)){
              
               $imageError = "Le fichier existe déjà .";
               $isUploadSuccess = false;
          }
          if($_FILES["image"]["size"] > 500000){
              
               $imageError = "Le fichier de doit pas dépasser les 500KB";
               $isUploadSuccess = false;
          }
          if($isUploadSuccess){
              if(!move_uploaded_file($_FILES["image"]["tmp_name"],$imagePath)){
                  
                  $imageError = "Il y a eu une erreur pendant l'upload";
                  $isUploadSuccess = false;
              }
          }
      }
      if($isSuccess && $isUploadSuccess){
          $db = Database::connect();
          $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values(?,?,?,?,?)");
          $statement->execute(array( $name,$description,$price,$category,$image));
          Database::disconnect();
          header("Location: index.php");
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
       <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span> Monster<span class="g">G</span>arage  <span class="glyphicon glyphicon-leaf"></span></h1>
            <div class="container admin">
              <div class="row">
                  <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                <h1><strong>Ajouter un item </strong></h1>
                      <br>
                  
                      <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                              <label for="name">Nom : </label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                              <span class="help-inline"><?php echo $nameError; ?></span>
                           </div>
                           <div class="form-group">
                              <label for="description">Description : </label>
                              <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                              <span class="help-inline"><?php echo $descriptionError; ?></span>
                            </div>
                           <div class="form-group">
                              <label for="price">Prix:  (en €)</label>
                              <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                              <span class="help-inline"><?php echo $priceError; ?></span>
                           </div>
                           <div class="form-group">
                               <label for="category">Catégorie : </label>
                              <select class="form-control" id="category" name="category">
                                <?php
                                  $db = Database::connect();
                                  foreach($db->query('SELECT * FROM categories') as $row){
                                     echo '<option value="' . $row['id'] .'">' . $row['name'] . '</option>'; 
                                  }
                                   Database::disconnect();
                                  ?>
                               </select>
                              <span class="help-inline"><?php echo $categoryError; ?></span>
                            
                           </div>
                           <div class="form-group">
                              <label for="image">Sélectionner une image : </label>
                              <input type="file" id="image" name="image">
                              <span class="help-inline"><?php echo $imageError; ?></span>
                        </div>
                      
                      <br>
                  
                       <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span>Ajouter</button>   
                       </div>
                    </form>
                  </div>
            </div>
         
    
    </body>
    
</html>