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
                <?= $this->Html->link('Polub', ['action' => 'likeUp', $comment->id], ['id' => 'like']) ?>
            </td>
            <?php if ($comment->likes > 0): ?>
                <td>
                    <?= $this->Html->link('Odlub', ['action' => 'likeDown', $comment->id], ['id' => 'unlike']) ?>
                </td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
            <td><?= $comment->likes ?> polubień</td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    $(function (){
        $('#like').click(function () {
            $.ajax({
                method: 'POST',
                url: <?= $this->Url->build(['controller' => 'Articles', 'action' => 'likeUp']) ?>,
            })
        });
    })
</script>
