<h2>Thêm câu hỏi</h2>

<form method="post" action="index.php?controller=question&action=create">
    <label>Nội dung:</label><br>
    <textarea name="content" required></textarea><br><br>

    <label>Mức độ:</label><br>
    <select name="level">
        <option value="easy">Dễ</option>
        <option value="medium">Trung bình</option>
        <option value="hard">Khó</option>
    </select><br><br>

    <button type="submit">Lưu</button>
</form>
