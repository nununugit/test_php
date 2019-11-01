<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <title>掲示板（簡易版）</title>
    </head>
        <body>
        <form action="simple_bbs.php" method="post">
        <p>
        名前: <input type="text" name="users_names" size="40">
        </p>
        <p>
        コメント: <br>
        <textarea name="users_comment" rows="4" cols="50"></textarea>
        </p>
        <p>
        <input type="submit" name="投稿" ><input type="reset" value="リセット">
        </p>
        </form>

        <?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=jikken1;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM simple_bbs";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[]=$row;
            }
            echo '処理が完了しました';
        }catch(PDOException $e){
            print ($e->getMessage());
            die();
        }
        
       

        //テーブルへの登録
        if(isset($_POST['users_names'])){
            $name = @$_POST['users_names'];
            $comment = @$_POST['users_comments'];
            $sql = "INSERT INTO simple_bbs VALUES('$name', '$comment',0 );";
            $result = $mysqli ->query($sql);
            if(!$result){
                die($mysqli ->error);
            }
        }

        //掲示板データの整形
        $sql = 'SELECT * FROM simple_bbs where delete_flag=0 ';
        $result = $mysqli -> query($sql);
        if(!$result){
            die($mysql -> error);
        }
        ?>

        <?php foreach($data as $row): ?>
        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['username'];?></td>
            <td><?php echo $row['age'];?></td>
            <td><?php echo $row['mail'];?></td>
        </tr>
        <?php endforeach; ?>
        <?php
        //MySQLサーバの接続を閉じる
        $mysqli -> close();
        ?>
        </body>
    </html>
