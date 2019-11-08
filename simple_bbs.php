<?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=jikken1;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM simple_bbs where delete_flag=0";
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
        if(isset($_POST['users_names'])){
            $name = @$_POST['users_names'];
            $comment = @$_POST['users_comments'];
            if (empty($name)||empty($comment)){
                echo "<br>";
                echo '<div class="alert alert-primary" role="alert"><strong>文字を入力してください</strong></div>';
            }else{
            date_default_timezone_set('Asia/Tokyo');
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp );
            $sql = "INSERT INTO simple_bbs VALUES( '','$name', '$comment',0,'$now' );";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
            header('Location: ./simple_bbs.php');}
           
        }if(isset($_GET['id'])){
                    $id =  @$_GET['id'];
                    $sql = "UPDATE simple_bbs SET delete_flag = 1 WHERE id=$id;";
                    $result = $dbh ->query($sql);
                    if(!$result){
                        die($dbh ->error);
                    }
                    header('Location: ./simple_bbs.php');

        }if(isset($_POST['delete_all'])){
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp ) ;
            $sql="UPDATE simple_bbs SET delete_flag = 1 WHERE delete_flag = 0;
            INSERT INTO simple_bbs VALUES( '','master', 'firstcomment',0,'$now' );";
                    $result = $dbh ->query($sql);
                    echo "success";
                    if(!$result){
                        die($dbh ->error);
                    }
                    header('Location: ./simple_bbs.php');
        }?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>掲示板（簡易版）</title>
    </head>
        <body>
        <form action="simple_bbs.php" method="post">
        <p>
        名前:<br>
        <input type="text" name="users_names" size="40">
        </p><p>
        コメント: <br>
        <textarea name="users_comments" rows="4" cols="50"></textarea>
        </p><p>
        <input type="submit" name="投稿" >
        </p><p>
        <input type="reset" value="リセット">
        </p>        
        </form>
        <form action="simple_bbs.php" method="post">
        <p>
        <input type="submit" value="全削除" name="delete_all" >
        </p>
        </form>
        <div class="table-responsive">
        <table class="table">
        <thead class="thead-dark">
        <tr><th>投稿者</th><th>コメント</th><th>コメント削除</th><th>投稿日</th></tr>
        <?php foreach($data as $row){ ?>
            <tr>
            <td><?php echo $row['users_names'];?></td>
            <td><?php echo $row['users_comments'];?></td>
            <td>
            <form action="simple_bbs.php" method="get">
        <input type="submit" value="削除する" >
        <input type="hidden" name="id" value="<?=$row['id']?>">
        <td><?php echo $row['post_date'];?></td>
        </form>
    </td>
        </tr>
        <?php }?>
        </table>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <!-- Bootstrap Javascript(jQuery含む) -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        </body>
    </html>