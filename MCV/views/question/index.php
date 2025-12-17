<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php if (empty($questions)): ?>
        <p>Không có câu hỏi nào trong CSDL.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nội dung Câu hỏi</th>
                    <th>Chương/Bài học</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $q): ?>
                <tr>
                    <td><?php echo htmlspecialchars($q['id']); ?></td>
                    <td><?php echo htmlspecialchars($q['content']); // Giả sử tên cột là 'content' ?></td>
                    <td><?php echo htmlspecialchars($q['chapter_id']); // Giả sử có khóa ngoại 'chapter_id' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>