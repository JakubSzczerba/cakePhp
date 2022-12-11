<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>
<br>
<h4>Comments</h4>
<table>
    <?php foreach ($comments as $comment): ?>
        <tr>
            <td><?= $comment->author ?></td>
            <td><small>Created: <?= $comment->created->format(DATE_RFC850) ?></small></td>
            <td><?= $comment->content ?></td>
            <td>
                <?= $this->Html->link('Polub', ['action' => 'likeUp', $comment->id]) ?>
            </td>
            <td><?= $comment->likes ?> polubień</td>
        </tr>
    <?php endforeach; ?>
</table>
