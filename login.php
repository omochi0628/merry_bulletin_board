<?php
        require('dbconnect.php');

        session_start();

        if(isset($_COOKIE['email'])){
            $_POST['email'] = $_COOKIE['email'];
            $_POST['password'] = $_COOKIE['password'];
            $_POST['save'] = 'on';
        }
        
        if(isset($_POST['email'],$_POST['password'])){
            //ログイン処理
            if(isset($_POST['email']) && isset($_POST['password'])){
                    $sql=sprintf('SELECT * FROM members WHERE email="%s" AND password="%s"',
                                mysqli_real_escape_string($db,$_POST['email']),
                                mysqli_real_escape_string($db,sha1($_POST['password']))
                                );
                    $record=mysqli_query($db,$sql) or die(mysqli_error($db));
                    if($table=mysqli_fetch_assoc($record)){
                        //ログイン成功
                        $_SESSION['id']=$table['id'];
                        $_SESSION['time']=time();
                        
//                        ログイン情報を記録
                        if($_POST['save'] == 'on'){
                            setcookie('email',$_POST['email'],time()+60*60*24*14);
                            setcookie('password',$_POST['password'],time()+60*60*24*14);
                        }
                        header('Location: talk.php');
                        exit();
                    }else{
                        $error['login_feiled']='failed';
                    }
            }else{
                $error['login_blank']='blank';
            }
        }
?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>Merry Bulletin Board</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/index.css" media="all">
    </head>

    <body>
        <!--header-->
        <header>
            <h1>Merry Bulletin Board</h1>
        </header>

        <!--main-->
        <main>
            <h2>ログイン</h2>
            <div id=lead>
                <p>メールアドレスとパスワードを入力してください。</p>
            </div>
            <form action="" method="post">
                <dl>
                    <!--メアド------------>
                    <dt>メールアドレス</dt>
                    <dd>
                        <input type="text" name="email" size="35" maxlength="255" value="<?php
                        if(isset($_POST['email']))
                        echo htmlspecialchars($_POST['email']); ?>">
                        <?php if(isset($error['login_blank'])): ?>
                        <p class="error">*メールアドレスとパスワードを入力して下さい。</p>
                        <?php endif; ?>
                        <?php if (isset($error['login_feiled'])): ?>
                        <p class="error">*ログイン失敗。正しく入力して下さい。</p>
                        <?php endif; ?>
                    </dd>
                    <!--パスワード------------->
                    <dt>パスワード</dt>
                    <dd>
                        <input type="password" name="password" size="35" maxlength="255"<?php
                        if(isset($_POST['password']))
                        echo htmlspecialchars($_POST['password']); ?>>
                    </dd>
                    <!--自動ログイン------------->
                    <dt>ログイン情報記録</dt>
                    <dd>
                        <input name="save" type="checkbox" id="save" value="on">
                        <label for="save">次回から自動ログインする</label>
                    </dd>
                </dl>
                <div>
                    <input type="submit" value="ログイン">
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