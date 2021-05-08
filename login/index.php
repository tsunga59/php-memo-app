<?php
    session_start();
    require('../common/auth.php');

    if(isLogin()) {
        header('Location: ../memo/');
        exit;
    }

    include_once('../common/header.php');
    echo getHeader('ログイン');
?>

<section class="login">
    <div class="container">
        <form action="./action/login.php" method="post">
            <!-- エラーメッセージ -->
            <?php if(isset($_SESSION['errors'])): ?>
                <div class="error_area">
                    <?php foreach($_SESSION['errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
            <table>
                <tr>
                    <th>
                        <label for="email">メールアドレス</label>
                    </th>
                    <td>
                        <input type="email" name="email" id="email">
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
            <button type="submit">ログインする</button>
            <div class="account">
                <p>アカウントをお持ちでない方</p>
                <a href="../register">アカウントを作成する</a>
            </div>
        </form>
    </div>
</section>

<?php
    include_once('../common/footer.php');