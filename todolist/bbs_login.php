<?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=kadai;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users_datas";
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
        if(isset($_POST['user_name'])){
            $name = @$_POST['user_name'];
            $pass = @$_POST['user_pass'];
            if (empty($name)||empty($pass)){
                echo "<br>";
                echo '<div class="alert alert-primary" role="alert"><strong>文字を入力してください</strong></div>';
            }else{
            $stmt = $dbh->prepare("SELECT * FROM users_datas WHERE user_name = :name AND user_pass=:pass;");
            $stmt->execute([':name' => $name,':pass'=> $pass]);
            $row = $stmt->fetch();
            if($row){
                session_start();
                $token_uid = sha1($row['uid']);
                $token_username = sha1($row['user_name']);
                $_SESSION['profile']=array('user_id'=>$row['uid'],'user_name'=>$row['user_name']);
                header('Location: ./bbs_index.php');
            }else{
                echo "ログイン失敗";
            }
           
        }
    }
        ?>
    

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ひとこと掲示板login</title>
    </head>
        <body>
        <form action="bbs_login.php" method="post">
        <div class="form-group"><p>
        名前:<br>
        <input type="text" placeholder="ユーザ名" name="user_name" size="15">
        </p>

        <p>
        パスワード: <br>
        <input type="password" placeholder="ユーザのパスワード" name="user_pass" cols="20">
        </p>

        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        </form>
        
    <a href="./bbs_registration.php">登録はこちら</a>    

        </div>
        </body>
    </html>