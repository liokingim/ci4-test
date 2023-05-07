<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= $result['id'] ?></td>
                    <td><?= $result['title'] ?></td>
                    <td><?= $result['content'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>