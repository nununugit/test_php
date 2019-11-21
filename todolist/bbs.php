<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <title>掲示板</title>
    </head>
    <body>
        <form action="bbs.php" method="post">
            <p>
                名前: <br>
                <input type="text" name="name" placeholder="名前を入力してください" size="54">
            </p>
            <p>
                コメント: <br>
                <textarea name="comment" placeholder="コメントを入力してください" rows="5" cols="50"></textarea>
            </p>
            <p>
                <input type="submit" value="投稿">
                <input type="reset" value="入力内容の初期化"><br>
            </p>
        </form>
        <form action="bbs.php" method="post">
            <p>
                <input type="submit" name="ALL_DELETE" value="全投稿を削除">
            </p>
        </form>
        <?php
            //タイムゾーンをアジア/東京に設定
            date_default_timezone_set('Asia/Tokyo');
            //日付時間を取得
            $timestomp = date('Y/m/d_H:i:s');
            $mysqli = mysqli_connect('localhost','root','','jikken');
            if($mysqli->connect_error){
                die($mysqli->connect_error);
            }
    
            //テーブルへの登録
            //未入力の項目があるときデータベースへの登録を行わない
            if(isset($_POST['name'])){
                
            if(empty($_POST['name'])||empty($_POST['comment'])){
                print("未入力の項目が存在します");
            //送信された年月日時分秒, 入力された名前, コメントをデータベースへ登録
            }else{
                $name = @$_POST['name'];
                $comment = @$_POST['comment'];
                $sql = "INSERT into simple_bbs values('','$timestomp','','$name','$comment' );";
                $result = $mysqli ->query($sql);
                if(!$result){
                    die($mysqli ->error);
                }
            }
            }
        ?>
        </form>
        <form action="bbs.php" method="post">
            <p>
                投稿検索<br>
                <input type="date" name="min_date" value="">~
                <input type="date" name="max_date">
            </p>
        </form>
        <?php
            //削除されていない投稿投稿のみ呼び出し
            $sql = "SELECT * FROM `simple_bbs` WHERE delete_flug=0";
            $result = $mysqli -> query($sql);
        
            if(!$result){
                die($mysql -> error);
            }
            
        ?>
        <table>
            <tr>
               <th>タイムスタンプ</th><th>名前</th><th>コメント</th><th>削除</th>
            </tr>

            <?php foreach($result as $row){ ?>
            <tr>
                
                <td><?php echo($row['timestomp']);?></td>
                <td><?php echo($row['name']);?></td>
                <td><?php echo($row['comment']);?></td>

                <td>
                    <form action="bbs.php" method="post">
                        <input type="submit" name="EACH_DELETE" value="削除">
                        <input type="hidden" name="id" value="<?=$row['id']?>">
                    </form>
                </td>
            </tr>
            <?php }?>        
        </table>
        <?php
            //全削除
            if(isset($_POST['ALL_DELETE'])){
                $sql = "UPDATE `simple_bbs` SET `delete_flug`=1;";
                $result = $mysqli ->query($sql);
                header('Location: ./bbs.php');
                if(!$result){
                    die($mysqli ->error);
                }
            }
            //個別削除
            if(isset($_POST['EACH_DELETE'])){
                $id = @$_POST['id'];
                $sql = "UPDATE `simple_bbs` SET delete_flug=1 where id=$id;";
                $result = $mysqli ->query($sql);
                header('Location: ./bbs.php');
                
                if(!$result){
                    die($mysqli ->error);
                }
            }
        ?>
        <?php
                //MySQLサーバの接続を閉じる
                $mysqli -> close();

                //個別の投稿ごとに, 削除ボタンを追加
                //他仕様の追加, 実装方法の変更,　レイアウトの変更を各自行う
        ?>
    </body>
</html>