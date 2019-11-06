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
            echo '処理が完了しました';
        }catch(PDOException $e){
            print ($e->getMessage());
            die();
        }

        //テーブルへの登録
        if(isset($_POST['users_names'])){
            $name = @$_POST['users_names'];
            $comment = @$_POST['users_comments'];
            $sql = "INSERT INTO simple_bbs VALUES( '','$name', '$comment',0 );";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
        }if(isset($_GET['id'])){
                    $id =  @$_GET['id'];
                    $sql = "UPDATE simple_bbs SET delete_flag = 1 WHERE id=$id;";
                    $result = $dbh ->query($sql);
                    if(!$result){
                        die($dbh ->error);
                    }
        }if(isset($_POST['delete_all'])){
                    $sql = "DROP TABLE `simple_bbs`;CREATE TABLE `simple_bbs` (
                        `id` int(11) NOT NULL,
                        `users_names` varchar(11) NOT NULL,
                        `users_comments` text NOT NULL,
                        `delete_flag` tinyint(1) NOT NULL DEFAULT 0
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                      
                      --
                      -- ダンプしたテーブルのインデックス
                      --
                      
                      --
                      -- テーブルのインデックス `simple_bbs`
                      --
                      ALTER TABLE `simple_bbs`
                        ADD PRIMARY KEY (`id`);
                      
                      --
                      -- ダンプしたテーブルのAUTO_INCREMENT
                      --
                      
                      --
                      -- テーブルのAUTO_INCREMENT `simple_bbs`
                      --
                      ALTER TABLE `simple_bbs`
                        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                      COMMIT;
                      INSERT INTO simple_bbs VALUES( '','master', 'first comment',0 );
                      ";
                    $result = $dbh ->query($sql);
                    echo "success";
                    if(!$result){
                        die($dbh ->error);
                    }
        }
        ?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
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
        <input type="submit" value="全削除" name="delete_all"" >
        </p>     
        </form>
        <table>
        <tr><th>name</th><th>comment</th><th>delete_button</th></tr>
        <?php foreach($data as $row){ ?>
            <tr>
            <td><?php echo $row['users_names'];?></td>
            <td><?php echo $row['users_comments'];?></td>
            <td>
            <form action="simple_bbs.php" method="get">
        <input type="submit" value="削除する" >
        <input type="hidden" name="id" value="<?=$row['id']?>">
        </form>
    </td>
        </tr>
        <?php }?>
        </table>        
        </body>
    </html>

        