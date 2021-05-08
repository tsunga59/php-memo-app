<?php
    session_start();
    require('../common/auth.php');

    if(isLogin()) {
        header('Location: ../memo/');
        exit;
    }

    include_once('../common/header.php');
    echo getHeader('ユーザー登録');
?>

<section class="register">
    <div class="container">
        <form action="./action/register.php" method="post">
            <table>
                <!-- エラーメッセージ -->
                <?php if(isset($_SESSION['errors'])): ?>
                    <div class="error_area">
                        <?php foreach($_SESSION['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
                <tr>
                    <th>
                        <label for="name">ユーザー名</label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" placeholder="山田 太郎">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="email">メールアドレス</label>
                    </th>
                    <td>
                        <input type="email" name="email" id="email" placeholder="example@com">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="password">パスワード</label>
                    </th>
                    <td>
                        <input type="password" name="password" id="password">
                    </td>
                </tr>
            </table>
            <button type="submit">登録する</button>
            <div class="account">
                <p>既にアカウントをお持ちの方</p>
                <a href="../login">ログイン画面へ</a>
            </div>
        </form>
    </div>
</section>

<?php
    include_once('../common/footer.php');