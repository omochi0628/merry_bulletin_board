<?php
        session_start();
        require('../dbconnect.php');

        if(!isset($_SESSION['join'])){
            header('Location:index.php');
            exit();
        }
        
        if(!empty($_POST)){
            //登録処理
            $sql=sprintf('INSERT INTO members SET name="%s",email="%s",password="%s",picture="%s",created="%s"',
                        mysqli_real_escape_string($db,$_SESSION['join']['name']),
                        mysqli_real_escape_string($db,$_SESSION['join']['email']),
                        mysqli_real_escape_string($db,sha1($_SESSION['join']['password'])),
                        mysqli_real_escape_string($db,$_SESSION['join']['image']),
                        date('Y-m-d H:i:s')
                        );
            mysqli_query($db,$sql) or die(mysqli_error($db));
            unset($_SESSION['join']);
            header('Location:thanks.php');
            exit();
        }
?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>Merry Bulletin Board</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../css/index.css" media="all">
    </head>

    <body>

        <!--header-->
        <header>
            <h1>Merry Bulletin Board -会員登録-</h1>
        </header>

        <!--main-->
        <main>
            <h2>登録内容確認</h2>
            <form action="" method="post">
                <input type="hidden" name="action" value="submit">
                <dl>
                    <!--ニックネーム------------>
                    <dt>ニックネーム</dt>
                    <dd>
                        <?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES,'UTF-8'); ?>
                    </dd>
                    <!--メアド------------->
                    <dt>メールアドレス</dt>
                    <dd>
                        <?php echo htmlspecialchars($_SESSION['join']['email'],ENT_QUOTES,'UTF-8'); ?>
                    </dd>
                    <!--パスワード------------->
                    <dt>パスワード</dt>
                    <dd>
                        【表示されません】
                    </dd>
                    <!--アイコン------------->
                    <dt>アイコン画像</dt>
                    <dd>
                        <img src="../member_pictuer/<?php echo htmlspecialchars($_SESSION['join']['image'],ENT_QUOTES,'UTF-8'); ?>" width="100" height="100" alt="">
                    </dd>
                </dl>
                <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> |
                    <input type="submit" value="登録する">
                </div>
            </form>
        </main>
        <!--fotter-->
        <footer>
            <hr>
            <small> Copyright (c) 2015 E14C2002 Fujimoto Sachiko, All Rights Reserved.</small>
            <hr>
        </footer>
    </body>

    </html>