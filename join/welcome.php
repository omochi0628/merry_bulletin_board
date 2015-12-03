<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Merry Bulletin Board</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/welcome.css" media="all">
</head>


<body>
    <!--header-->
    <header>
        <h1>Merry Bulletin Board</h1>
        <p>-Welcome-</p>
    </header>
    <!--main-->
    <main>
        <img src="../img/front_hituzi.png" alt="メリー" width="195">
        <h3>「Merry Bulletin Board」とは</h3>
        <p>
            ものラボじメンバーの、ものラボじによる、ものラボじのための、掲示板である。
        </p>

        <div class="btn">
            <form method="post" action="index.php">
                <input type="submit" value="アカウント作成" name="index" id="index">
            </form>

            <form method="post" action="../login.php">
                <input type="submit" value="ログイン" name="login" id="login">
            </form>
        </div>
    </main>
    <!--fotter-->
    <footer>
        <hr>
        <small> Copyright (c) 2015 Fujimoto Sachiko, All Rights Reserved.</small>
        <hr>
    </footer>
</body>

</html>