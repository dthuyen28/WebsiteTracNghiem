<h2>Sửa câu hỏi</h2>

<form method="post" action="index.php?controller=question&action=update&id=<?= $question['id'] ?>">
    <label>Nội dung:</label><br>
    <textarea name="content" required><?= $question['content'] ?></textarea><br><br>

    <label>Mức độ:</label><br>
    <select name="level">
        <option value="easy" <?= $question['level'] == 'easy' ? 'selected' : '' ?>>Dễ</option>
        <option value="medium" <?= $question['level'] == 'medium' ? 'selected' : '' ?>>Trung bình</option>
        <option value="hard" <?= $question['level'] == 'hard' ? 'selected' : '' ?>>Khó</option>
    </select><br><br>

    <button type="submit">Cập nhật</button>
</form>
