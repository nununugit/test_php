<?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=jikken1;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
            $pass1 = @$_POST['user_pass1'];
            $pass2 = @$_POST['user_pass2'];
            if (empty($name)||empty($pass1)||empty($pass2)){
                echo "<br>";
                echo '<div class="alert alert-primary" role="alert"><strong>文字を入力してください</strong></div>';
            }else if($pass1==$pass2){
                $sql = "INSERT INTO users_datas VALUES('', '$name', '$pass1');";
                $result = $dbh ->query($sql);
                if(!$result){
                    die($dbh ->error);
                
                header('Location: ./bbs_login.php');}
            
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
        <form action="bbs_index.php" method="post">
        <div class="form-group"><p>
        名前:<br>
        <input type="text" placeholder="ユーザ名" name="user_name" size="15">
        </p>
        <p>
        パスワード: <br>
        <input type="text" placeholder="ユーザのパスワード" name="user_pass1" cols="20">
        </p>

        <p>
        パスワード(再入力): <br>
        <input type="text" placeholder="ユーザのパスワード(再入力)" name="user_pass2" cols="20">
        </p>

        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        </form>
        
        </div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <!-- Bootstrap Javascript(jQuery含む) -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        </body>
    </html>