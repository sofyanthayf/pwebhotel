<?php
// var_dump($rate)
 ?>

<ol>
  <?php foreach ($rate as $r): ?>
    <li><?= $r->rtype ?> - <?= $r->rate ?></li>
  <?php endforeach; ?>
</ol>
