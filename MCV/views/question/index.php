<h2>Danh sách câu hỏi</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nội dung</th>
        <th>Mức độ</th>
        <th>Hành động</th> <!-- Thêm cột Hành động -->
    </tr>

    <?php foreach ($questions as $q): ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= $q['content'] ?></td>
        <td><?= $q['level'] ?></td>
        <td>
            <!-- Link thêm -->
            <a href="index.php?controller=question&action=create">➕ Thêm</a>
            <!-- Link sửa -->
            <a href="index.php?controller=question&action=edit&id=<?= $q['id'] ?>">Sửa</a> |
            <!-- Link xóa -->
            <a href="index.php?controller=question&action=delete&id=<?= $q['id'] ?>"
               onclick="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
