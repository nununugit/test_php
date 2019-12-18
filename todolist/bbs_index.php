<?php

session_start();
$session_user = $_SESSION['profile']['user_name'];
$session_uid = $_SESSION['profile']['user_id'];
if($session_uid){
echo "<h1>ようこそ".$_SESSION['profile']['user_name']."さん</h1>";

        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=kadai;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM todolist where delete_flag=0 AND uid = '$session_uid'";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[]=$row;
            }
        }catch(PDOException $e){
            print ($e->getMessage());
            die();
        }
            //テーブルへの登録
        if(isset($_POST['todo_title'])){
            $title = @$_POST['todo_title'];
            $comment = @$_POST['todo_value'];
            echo $title;
            echo $comment;
            if (empty($title)||empty($comment)){
                echo "<br>";
                echo '<div class="alert alert-primary" role="alert"><strong>文字を入力してください</strong></div>';
            }else{
            date_default_timezone_set('Asia/Tokyo');
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp );
            $sql = "INSERT INTO todolist VALUES( '','$title', '$comment','$session_uid',0,'$now',0 );";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
            header('Location: ./bbs_index.php');
        }
            
            //個別削除
        }if(isset($_GET['todo_id1'])){
                    $todo_id =  @$_GET['todo_id1'];
                    $sql = "UPDATE todolist SET delete_flag = 1 WHERE todo_id=$todo_id;";
                    $result = $dbh ->query($sql);
                    if(!$result){
                        die($dbh ->error);
                    }
                    header('Location: ./bbs_index.php');

            //全削除
        }if(isset($_POST['delete_all'])){
            date_default_timezone_set('Asia/Tokyo');
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp ) ;
            $sql="UPDATE todolist SET delete_flag = 1 WHERE delete_flag = 0 AND uid ='$session_uid';
            INSERT INTO todolist VALUES( '','test', 'test','$session_uid', 0 ,'$now',0 );";
                    $result = $dbh ->query($sql);
                    echo "success";
                    if(!$result){
                        die($dbh ->error);
                    }
                    header('Location: ./bbs_index.php');
        }if(isset($_POST['logout'])){
            session_destroy();
            header('Location: ./bbs_login.php');
        }
    }else{
        header('Location: ./bbs_login.php');
    }
        ?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>やることリスト</title>
    </head>
        <body>
        <form action="bbs_index.php"  method="post">
        <div class="form-group"><p>
        タイトル:<br>
        <input type="text" placeholder="title" name="todo_title" size="40">
        </p>
        
        <p>
        コメント:<br>
        <textarea placeholder="コメント" name="todo_value" rows="4" cols="50"></textarea>
        </p>

        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        <input class="btn btn-primary mb-2" type="reset" value="リセット">        
        </form>
        
        <form action="bbs_index.php" method="post">
        <input class="btn btn-primary mb-2" type="submit" value="全削除" name="delete_all" >
        </form>
        
        <form action="bbs_index.php" method="post">
        <input class="btn btn-primary mb-2" type="submit" value="ログアウト" name="logout" >
        </div>
        </form>
        
        <div class="table-responsive">
            <table class="table">
        <thead class="thead-dark">
        <tr><th>タイトル</th><th>コメント</th><th>コメント削除</th><th>checkbox</th><th>投稿日</th></tr>
        <?php foreach($data as $row){ ?>
            <tr>
            <td><?php echo htmlentities( $row['todo_title'], ENT_QUOTES, 'UTF-8');?></td>
            
            <td><?php echo htmlentities( $row['todo_value'], ENT_QUOTES, 'UTF-8');;?></td>
            
            <td>
            <form action="bbs_index.php" method="get">
            <input type="submit" value="削除する" >
            <input type="hidden" name="todo_id1" value="<?=$row['todo_id']?>">
            </form>    
            </td>
            
            <td>
            <form action="bbs_index.php" method="get">
            <input type="checkbox" name="chk[]">
            <input type="submit" value="完了">
            <input type="hidden" name="todo_id2" value="<?=$row['todo_id']?>">   
            </td>
            </form>

        <td><?php echo $row['post_date'];?></td>
        </tr>
        <?php }?>        
            </table>
        </div>
        <a href="./bbs_alltodo.php">みんなの投稿はこちら</a>
        </body>
    </html>