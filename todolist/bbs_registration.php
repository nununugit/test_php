<?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=kadai;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "SELECT * FROM users_datas";
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
        if(isset($_POST['regist_name'])){
            $name = @$_POST['regist_name'];
            $pass1 = @$_POST['user_pass1'];
            $pass2 = @$_POST['user_pass2'];
            if (empty($name)||empty($pass1)||empty($pass2)){
                echo "<br>";
                echo '<div class="alert alert-primary" role="alert"><strong>文字を入力してください</strong></div>';
            }else if($pass1==$pass2){
                $stmt = $dbh->prepare("SELECT * FROM users_datas WHERE user_name =:name;");
                $stmt->execute([':name' => $name]);
                $row = $stmt->fetch();
                if($row){
                    echo "ユーザは既に存在します。";
                }else{
                    $sql = "INSERT INTO users_datas VALUES('', '$name', '$pass1');";
                    $result = $dbh ->query($sql);
                    echo $userid;
                    date_default_timezone_set('Asia/Tokyo');
                    $timestamp = time() ;
                    $stmt = $dbh->prepare("SELECT * FROM users_datas WHERE user_name =:name;");
                    $stmt->execute([':name' => $name]);
                    $row = $stmt->fetch();
                    $userid = $row['uid'];
                    $now= date( "Y/m/d H:i:s", $timestamp );
                    $sql = "INSERT INTO todolist VALUES('', 'firstcomment','Hello World!!' ,'$userid',0,'$now' ,0);";
                    $result = $dbh ->query($sql);
                    header('Location: ./bbs_login.php');
                }
            }
        }?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ひとこと掲示板login</title>
    </head>
        <body>
        <form action="bbs_registration.php" method="post">
        <div class="form-group"><p>
        名前:<br>
        <input type="text" placeholder="ユーザ名" name="regist_name" size="15">
        </p>

        <p>
        パスワード: <br>
        <input type="password" placeholder="ユーザのパスワード" name="user_pass1" cols="20">
        </p>

        <p>
        パスワード(再入力): <br>
        <input type="password" placeholder="ユーザのパスワード(再入力)" name="user_pass2" cols="20">
        </p>

        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        </form>

        <a href="./bbs_login.php">ログインはこちら</a>    

        
        </div>
</body>
    </html>