<div class="col-md-12">
    <form class="form-inline pull-right" method="get" action="/Actor/Search/">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Enter actor name">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Search</button>
        </div>
    </form>
</div>
<? foreach ($actors as $film): ?>
    <div class="col-md-12 jumbotron">
        <h3><?= $film['actors']['first_name'] ?> <?= $film['actors']['last_name'] ?></h3>
        <p><strong>Films:</strong></p>
		<? foreach ($film['films'] as $item): ?>
            <p><?= $item['name'] ?>
                <small>(<?= $item['year'] ?>)</small>
            </p>
		<? endforeach; ?>
    </div>
<? endforeach; ?>
