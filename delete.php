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
}catch(PDOException $e){
    print ($e->getMessage());
    die();
}

if(isset($_POST['id'])){
            $id =  @$_POST['id'];
            $name = @$_POST['users_names'];
            $comment = @$_POST['users_comments'];
            $sql = "UPDATE simple_bbs SET delete_flag = 1 WHERE id=$id";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
        }
        ?>