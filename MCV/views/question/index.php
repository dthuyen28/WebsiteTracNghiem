<h2>Danh sách câu hỏi</h2>
<a href="index.php?controller=question&action=create">Thêm câu hỏi</a>
<ul>
<?php foreach ($questions as $q): ?>
    <li><?= $q['content'] ?></li>
<?php endforeach; ?>
</ul>
