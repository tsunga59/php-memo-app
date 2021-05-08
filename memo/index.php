<?php

    session_start();

    require('../common/auth.php');
    require('../common/database.php');

    if(!isLogin()) {
        header('Location: ../login/');
        exit;
    }

    include_once('../common/header.php');
    echo getHeader('メモ投稿');

    $pdo = getDatabaseConnection();
    $id = getLoginId();
    $memos = [];

    $statement = $pdo->prepare('SELECT id, title, content, updated_at FROM memos WHERE user_id = :id ORDER BY updated_at DESC');
    $statement->bindParam(':id', $id);
    $statement->execute();

    while($result = $statement->fetch(PDO::FETCH_ASSOC)) {
        array_push($memos, $result);
    }

    $edit_id = "";
    if(isset($_SESSION['selected_memo'])) {
        $edit_memo = $_SESSION['selected_memo'];
        $edit_id = empty($edit_memo['id']) ? "" : $edit_memo['id'];
        $edit_title = empty($edit_memo['title']) ? "" : $edit_memo['title'];
        $edit_content = empty($edit_memo['content']) ? "" : $edit_memo['content'];
    }

?>

<section class="memo">
    <div class="memo_left">
        <div class="top_area">
            <p><?php echo getLoginName(); ?>さん、ようこそ！</p>
            <div class="btn_area">
                <a href="./action/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                <a href="./action/create.php"><i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="memo_list">
            <?php if(empty($memos)): ?>
                <p>メモがありません。</p>
            <?php endif; ?>
            <?php foreach($memos as $memo): ?>
                <a href="./action/select.php?id=<?php echo $memo['id']; ?>" class="<?php echo $edit_id == $memo['id'] ? 'active' : ''; ?>">
                    <p class="title"><?php echo $memo['title']; ?></p>
                    <span class="date"><?php echo date('Y/m/d H:i', strtotime($memo['updated_at'])); ?></span>
                    <span class="description"><?php echo mb_substr($memo['content'], 0, 25) . "…"; ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="memo_right">
        <?php if(isset($_SESSION['selected_memo'])): ?>
        <form action="" method="post">
            <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
            <div class="top_area">
                <div class="btn_area">
                    <button type="submit" formaction="./action/update.php"><i class="fas fa-pen"></i></button>
                    <button type="submit" formaction="./action/delete.php"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="content_area">
                <input type="text" name="edit_title" placeholder="タイトル…" value="<?php echo $edit_title; ?>" class="title">
                <textarea name="edit_content" placeholder="詳細テキスト…" class="content"><?php echo $edit_content; ?></textarea>
            </div>
        </form>
        <?php else: ?>
        <p>メモを新規作成または選択してください。</p>
        <?php endif; ?>
    </div>
</section>

<?php
    include_once('../common/footer.php');