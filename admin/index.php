<?php
  session_start();
  if(!isset($_SESSION['email'])){
    
    header("Location: login.php");
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
            <div  class="container admin">
              <div class="row">
                  <a class="btn btn-default" href="/index.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span>  </a>
                <h1><strong> Liste des items </strong> <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span>Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                         <th>NOM</th>
                         <th>Description</th>
                         <th>Prix</th>
                         <th>Catégorie</th>
                         <th>Actions</th>
                    </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                          require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category
                                                   FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
                        while($item = $statement->fetch())
                        {
                         
                          echo '<tr>';
                          echo '<td>' . $item['name'] . '</td>';
                          echo '<td>' .  $item['description']  . '</td>';
                          echo '<td>' . number_format($item['price'], 2, '.', '') . '</td>';
                          echo '<td>'.  $item['category']  .'</td>';
                          echo '<td width=300>';
                          echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] .'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                          echo' ';
                          echo '<a class="btn btn-danger" href="delete.php?id='.  $item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                          echo' ';
                          echo '<a class="btn btn-default" href="view.php?id=' .  $item['id'] . '"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                          echo '</td>';
                          echo '</tr>';
                        }
                         Database::disconnect();
                        
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <a class="btn-order" href="login.php"><span class="glyphicon glyphicon-chevron-left">   Retour</span></a>
        </div>
    
    </body>
    
</html>