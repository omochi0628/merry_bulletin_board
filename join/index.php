<?php
        require('../dbconnect.php');

        session_start();

        if(isset($_POST['name'],$_POST['email'],$_POST['password'])){
            //エラー項目の確認
            if($_POST['name']==''){
                $error['name']='blank';
            }
            if($_POST['email']==''){
                $error['email']='blank';
            }
            if(strlen($_POST['password']) < 4){
                $error['password']='length';
            }
            if($_POST['password']==''){
                $error['password']='blank';
            }
            $fileName=$_FILES['image']['name'];
            if(isset($fileName)){
                $ext=substr($fileName, -3);
                if($ext != 'jpg' && $ext != 'gif'){
                    $error['image'] = 'type';
                }
            }
            
            //重複チェック
            if(isset($_POST['email'])){
                $sql=sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
                            mysqli_real_escape_string($db,$_POST['email'])
                            );
                $record=mysqli_query($db,$sql) or die(mysqli_error($db));
                $table=mysqli_fetch_assoc($record);
                if($table['cnt'] > 0){
                    $error['email_dup']='duplicate';
                }
            }
            
            if(empty($error)){
                //画像up
                $image = date('YmdHis') . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],'../member_pictuer/'. $image);
                
                $_SESSION['join']=$_POST;
                $_SESSION['join']['image']=$image;
                header('Location:check.php');
                exit();
            }
        }

        //書き直し
        if(isset($_REQUEST['action'])){
            if($_REQUEST['action'] == 'rewrite'){
                $_POST=$_SESSION['join'];
                $error['rewrite']=true;
            }
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
            <h1>Merry Bulletin Board</h1>
        </header>

        <!--main-->
        <main>
            <h2>会員登録</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <dl>
                    <!--ニックネーム------------>
                    <dt>ニックネーム<span class="required">必須</span></dt>
                    <dd>
                        <input type="text" name="name" size="35" maxlength="255" value="<?php
                    if(isset($_POST['name']))
                    echo htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['name'])): ?>
                            <p class="error">※ニックネームを入力してください。</p>
                            <?php endif; ?>
                    </dd>
                    <!--メアド------------->
                    <dt>メールアドレス<span class="required">必須</span></dt>
                    <dd>
                        <input type="text" name="email" size="35" maxlength="255" value="<?php
                    if(isset($_POST['email']))
                    echo htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['email'])): ?>
                            <p class="error">※メールアドレスを入力してください。</p>
                        <?php endif; ?>
                        <?php if (isset($error['email_dup'])): ?>
                            <p class="error">※このメールアドレスは既に登録済みです。</p>
                        <?php endif; ?>
                    </dd>
                    <!--パスワード------------->
                    <dt>パスワード<span class="required">必須</span></dt>
                    <dd>
                        <input type="text" name="password" size="10" maxlength="20" value="<?php
                    if(isset($_POST['password']))
                    echo htmlspecialchars($_POST['password'],ENT_QUOTES,'UTF-8'); ?>">
                        <?php if (isset($error['password'])): ?>
                            <p class="error">※4文字以上のパスワードを入力して下さい。</p>
                            <?php endif; ?>
                    </dd>
                    <!--アイコン------------->
                    <dt>アイコン画像</dt>
                    <dd>
                        <input name="image" type="file" id="image" size="35">
                        <?php if(isset($error['image'])): ?>
                            <p class="error">※画像を再指定して下さい。</p>
                            <?php endif; ?>
                    </dd>
                </dl>
                <div>
                    <input type="submit" value="登録確認" id="completion">
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