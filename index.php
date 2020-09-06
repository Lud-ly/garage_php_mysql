<!DOCTYPE html>
<html>
    <head>
    <title>MonsterGarage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="Styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Rock+Salt&display=swap" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah&display=swap" rel="stylesheet" type="text/css">   
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    </head>
    
    
    <body>
        <section id="app">
        <div class="container site">
             <h1 class="text-logo">Monster <span class="g">G</span>arage </h1>
              <a class="buttonAdmin" href="admin/login.php">  Ajouter des voitures 
            </a>
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
                            <div class="thumbnail">
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
              Database::disconnect();
              echo '</div>';
           ?>
        </div>
     </section>
</body>
    
   <footer class="text-center"> 
           <a  href="#top">
                <span class="glyphicon glyphicon-chevron-up"></span>
           </a>
           <h6>2019-2020 &copy; Ludovic-Mouly.com </h6>
      </footer>
    
    
    
    
</html>