<h3>Add film</h3>
<form class="form-inline" method="post" action="/Film/AddPost">

    <div class="form-group">
        <label for="filmName">Name</label>
        <input type="text" class="form-control" name="film_name" id="filmName">
    </div>

    <div class="form-group">
        <label for="filmYear">Year</label>
        <input type="number" class="form-control" name="film_year" id="filmYear">
    </div>

    <div class="form-group">
        <label for="filmFormat">Format</label>
        <select class="form-control" name="film_format" id="filmFormat">
            <option>VHS</option>
            <option>DVD</option>
            <option>Blu-Ray</option>
        </select>
    </div>

    <button type="submit" class="btn btn-default">Submit</button>
    <button type="button" class="btn btn-default" onclick="addActor()">Add actor</button>
    <br/><br/>

    <div class="actors">

        <div class="form-group">
            <label for="actorFirstName">First</label>
            <input type="text" class="form-control" name="first_name[]" id="actorFirstName">
        </div>

        <div class="form-group">
            <label for="actorSecondName">Last name</label>
            <input type="text" class="form-control" name="last_name[]" id="actorSecondName">
        </div>
        <br/>
    </div>


</form>
