<?php

 
  require 'admin/database.php';


    echo '<nav>
                        <ul class="nav nav-pills">';
             $db = Database::connect();
             $statement = $db->query('SELECT * FROM categories');
             $categories = $statement->fetchAll();
            foreach($categories as $category){
                
                if($category['id'] == '1')
                    echo '<li role="presentation" class="active"><a href="#' . $category['id'] .'" data-toggle="tab">' .$category['name']. '</a></li>';
                else
                   echo '<li role="presentation"><a href="#'. $category['id'] . '" data-toggle="tab">' . $category['name'].'</a></li>'; 
                }
                   echo'</ul>
                     </nav>';
               
                   echo '<div class="tab-content">';
            
               foreach($categories as $category){
                   
                  if($category['id'] == '1')
                     echo '<div class="tab-pane active" id="' . $category['id'] . '">';
                        else
                     echo '<div class="tab-pane" id="' . $category['id'] . '">'; 
                  
                     echo '<div class="row">';
                  
                     $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
                     $statement->execute(array($category['id']));
                  
                     while($item = $statement->fetch()){
                         
                     echo '<div class="col-sm-6 col-md-6 card">
                            <div class="thumbnail" style="margin:0 auto">
                            <a class="btn btn-order" href="viewPublic.php?id=' .  $item['id'] . '"><span class="glyphicon glyphicon-eye-open"></span></a> 
                              <img src="images/' . $item['image'] . '" alt="...">
                               <div class="price">env. ' . number_format($item['price'], 2, '.','').' €</div>
                               <a href="http://www.lacentrale.fr" target="_blank" class="btn btn-order" role="button"><span class="glyphicon glyphicon-search"></span></a>
                                <div class="caption">
                                    <h4>' .$item['name'] . '</h4>
                                    <p>'  .$item['description'] . '</p>
                                </div>
                            </div>
                         </div>';
                     }
              echo  '</div>
                    </div>';
              }


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
   <link rel="stylesheet" href="./Styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Rock+Salt&display=swap" rel="stylesheet" type="text/css">
    </head>
    
    
    
    <body>
       <h1 class="text-logo">Monster <span class="g">G</span>arage</h1>
            <div class="container-fluid descript">
              <div class="row">
                   <div class="col-sm-12 site">
                        <span class="glyphicon glyphicon-eye-open"></span>
                      <br/>
                        <a class="btn btn-default" href="index.php">
                       Accueil
                       </a> 
                       
                       <br/>
                       <a href="http://www.lacentrale.fr" target="_blank" class="btn btn-order" role="button"><span class="glyphicon glyphicon-search"></span></a>
                    <div class="publicThumbnail" style="margin:0 auto!important">
                        <img src="<?php echo './images/' .  $item['image'] ; ?>" alt="...">
                        </div>
                    </div>
                  <br/>
                  <div class="col-sm-12">
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
                          <div class="price"><?php echo number_format((float)$item['price'],2,'.','') . ' €'; ?></div>
                      </form>
                      <br>
                       <div class="form-actions">
                       </div>
                  </div>
             </div>
         </div>
    
    </body>
    
</html>
 

