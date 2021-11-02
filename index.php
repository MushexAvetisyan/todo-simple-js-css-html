<?php
require 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My ToDo List</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <div class="main-section">
<div>
<ul>
  <li>
    <a href="https://www.facebook.com/streetart.photograph.50/" target="_blank">
      <span><i class="fab fa-facebook" area-hidden="true"></i> - Facebook</span>
    </a>
  </li>
  <li>
    <a href="https://twitter.com/lifeisillusioon" target="_blank">
      <span><i class="fab fa-twitter"></i> - Twitter</span>
    </a>
  </li>
  <li>
    <a href="https://www.instagram.com/mushex_arm/" target="_blank">
      <span><i class="fab fa-instagram"></i> - Instagram</span>
    </a>
  </li>
  <li>
    <a href="https://github.com/MushexAvetisyan" target="_blank">
      <span><i class="fab fa-github"></i> - GitHub</span>
    </a>
  </li>
  <li>
    <a href="https://www.pinterest.com/avetisyanmushex/_saved/" target="_blank">
      <span><i class="fab fa-pinterest"></i> - Pinterest</span>
    </a>
  </li>
</div>
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
               <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                <input type="text" 
                       name="title" 
                       style="border-color: #ff6666";
                       placeholder="This field is Required" 
                       value="" />
                <button type="submit">Add &nbsp; <span>&#43;</span></button>

                <?php } else { ?>
                <input type="text" 
                       name="title" 
                       placeholder="What do you need to do?" 
                       value="" />
                <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php 
         $todos = $conn->query("SELECT * FROM Todos ORDER BY id DESC");
        ?>
        <div class="show-todo-section">
            <?php if ($todos->rowCount() <= 0 ) {?>
        <div class="todo-item">
                <div class="empty">
                    <h1>My ToDo List</h1>
                    <img src="img/f.png" width="100%">
                    <img src="img/Ellipsis.gif" width="80px">
                </div>
            </div>
            <?php } ?>


            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                    class="remove-to-do">x</span>
                    <?php if($todo['checked']) { ?>
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id= "<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php  echo $todo['title'] ?></h2>
                        <?php } else { ?>
                            <input type="checkbox"
                            data-todo-id= "<?php echo $todo['id']; ?>"
                               class="check-box"/>
                        <h2><?php  echo $todo['title'] ?></h2>
                        <?php } ?>
                        <br>
                        <small>created: <?php  echo $todo['Date_time'] ?></small>
            </div>
            <?php } ?>
        </div>
    </div>


    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", {id: id},
                        (data) => {
                            if(data){
                                // $(this).parent().hide(600);
                                location.reload();
                            }
                        }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php',
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error') {
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else{
                                h2.addClass('checked');
                              }
                          }
                      }
                );
            })
        });
    </script>
</body>
</html>