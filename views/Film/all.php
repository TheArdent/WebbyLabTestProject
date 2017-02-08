<div class="col-md-6 pull-right">
    <form class="form-inline pull-right" method="get" action="/Film/Search/">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Enter film name">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Search</button>
        </div>
        <a href="/Film/Add" class="btn btn-success">Add film</a>
    </form>
</div>
<? foreach ($films as $film): ?>
    <div class="row col-md-12 jumbotron">
        <h3><?= $film['name'] ?></h3>
        <h4>Year:<?= $film['year'] ?></h4>
        <p>
			<? foreach ($film['actors'] as $actor): ?>

				<?= $actor['first_name'] ?> <?= $actor['last_name'] ?> <br/>

			<? endforeach; ?>
        </p>
        <button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal<?= $film['film_id'] ?>">
            Edit
        </button>
        <button class="btn btn-default" onclick="deleteFilm(<?= $film['film_id'] ?>)">Delete</button>

        <div id="myModal<?= $film['film_id'] ?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Edit film</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-inline" method="post" action="/Film/Edit">

                            <input type="hidden" name="film_id" value="<?= $film['film_id'] ?>">

                            <div class="form-group">
                                <label for="filmName">Name</label>
                                <input type="text" class="form-control" name="film_name" id="filmName"
                                       value="<?= $film['name'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="filmYear">Year</label>
                                <input type="number" class="form-control" name="film_year" id="filmYear"
                                       value="<?= $film['year'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="filmFormat">Format</label>
                                <select class="form-control" name="film_format" id="filmFormat"
                                        value="<?= $film['format'] ?>">
                                    <option>VHS</option>
                                    <option>DVD</option>
                                    <option>Blu-Ray</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="addActor()">Add actor</button>
                            <br/><br/>

							<? foreach ($film['actors'] as $actor): ?>
                                <span class="actors">
                                <div class="form-group">
                                    <label for="actorFirstName">First</label>
                                    <input type="text" class="form-control" name="first_name[]" id="actorFirstName"
                                           value="<?= $actor['first_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="actorSecondName">Last name</label>
                                    <input type="text" class="form-control" name="last_name[]" id="actorSecondName"
                                           value="<?= $actor['last_name'] ?>">
                                </div>
                            </span>

                                <div class="form-group">
                                    <button class="btn btn-danger" type="button"
                                            onclick="deleteActor(<?= $film['film_id'] ?>,<?= $actor['actor_id'] ?>)"
                                            data-dismiss="modal">x
                                    </button>
                                </div>
                                <br/>
							<? endforeach; ?>

                        </form>

                        <div class="modal-footer">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
<? endforeach; ?>
