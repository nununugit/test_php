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
        $mysqli = mysqli_connect('localhost','root','','jikken1');
        if($mysqli->connect_error){
            die($mysqli->connect_error);
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
        while($row = $result -> fetch_assoc()){
            print($row['users_names'].':'.$row['users_comments']);
            print("<hr>\n");
        }

        //MySQLサーバの接続を閉じる
        $mysqli -> close();
        ?>
        </body>
    </html>
