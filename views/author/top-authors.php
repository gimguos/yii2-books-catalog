<h1>ТОП-10 авторов за <?= $year ?> год</h1>

<table class="table">
    <thead>
    <tr>
        <th>Автор</th>
        <th>Количество книг</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($topAuthors as $author): ?>
        <tr>
            <td><?= $author->full_name ?></td>
            <td><?= $author->book_count ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>