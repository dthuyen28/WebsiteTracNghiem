<h2>Danh sách câu hỏi</h2>

<a href="index.php?controller=question&action=create">➕ Thêm câu hỏi</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nội dung</th>
        <th>Mức độ</th>
    </tr>

    <?php foreach ($questions as $q): ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= $q['content'] ?></td>
        <td><?= $q['level'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
