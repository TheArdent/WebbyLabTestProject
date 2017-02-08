<?php
define('STR_TITLE', 'Title: ');
define('STR_YEAR', 'Release Year: ');
define('STR_FORMAT', 'Format: ');
define('STR_ACTOR', 'Stars: ');

class FilmController
{
	public function actionIndex()
	{
		$view = new View();
		$view->title = 'FilmProject HomePage';
		$view->content = $view->render('Film/index');
		$view->display();
	}

	public function actionAll()
	{
		$order = isset($_GET['order']) ? $_GET['order'] : 'film_id';
		$type = isset($_GET['type']) ? $_GET['type'] : 'ASC';
		$Films = Film::Instance();
		$view = new View();

		$getActors = function ($film) {
			$Films = Film::Instance();
			$film['actors'] = $Films->GetActors($film['film_id']);

			return $film;
		};
		$view->films = array_map($getActors, $Films->All($order, $type));
		echo $view->render('Film/all');
	}

	public function actionAdd()
	{
		$view = new View();
		$view->title = 'Add new film';
		$view->content = $view->render('Film/add');
		$view->display();
	}

	public function actionAddPost()
	{
		$actor = Actor::Instance();
		$Film = Film::Instance();

		if (!isset($_POST['film_name']) || !isset($_POST['film_format']) || !isset($_POST['film_year'])) {
			die('Failed request');
		}

		$film_id = $Film->Add($_POST['film_name'], $_POST['film_year'], $_POST['film_format']);

		for ($i = 0; $i < count($_POST['first_name']); $i++) {
			$tmp = $actor->getUserByNames($_POST['first_name'][$i], $_POST['last_name'][$i]);
			if (!$tmp) {
				$actor_id = $actor->Add($_POST['first_name'][$i], $_POST['last_name'][$i]);
			}
			else {
				$actor_id = $tmp[0]['actor_id'];
			}

			$Film->AddActor($film_id, $actor_id);
		}

		header('Location: /');
		exit;
	}

	public function actionGet()
	{
		$view = new View();
		$Film = Film::Instance();
		if (isset($_GET['film_id'])) {
			$id = $_GET['film_id'];
		}
		else {
			die('Failed request');
		}
		$view->film = $Film->Get($id);
		echo $view->render('Film/get');
	}

	public function actionEdit()
	{
		$actor = Actor::Instance();
		$Film = Film::Instance();

		$film_id = $_POST['film_id'];
		$film_name = $_POST['film_name'];
		$film_format = $_POST['film_format'];
		$film_year = $_POST['film_year'];

		$Film->Edit($film_id, $film_name, $film_format, $film_year);

		for ($i = 0; $i < count($_POST['first_name']); $i++) {
			if ($_POST['first_name'][$i] == "" || $_POST['first_name'][$i] == " " || $_POST['last_name'][$i] == "" || $_POST['last_name'][$i] == " ") {
				continue;
			}

			$tmp = $actor->getUserByNames($_POST['first_name'][$i], $_POST['last_name'][$i]);
			if (!$tmp) {
				$actor_id = $actor->Add($_POST['first_name'][$i], $_POST['last_name'][$i]);
			}
			else {
				$actor_id = $tmp[0]['actor_id'];
			}

			if (!$Film->isActors($film_id, $actor_id)) {
				$Film->AddActor($film_id, $actor_id);
			}
		}

		header('Location: /');
		exit;
	}

	public function actionDeleteActor()
	{
		$Film = Film::Instance();
		$Actor = Actor::Instance();
		$film_id = $_GET['film_id'];
		$actor_id = $_GET['actor_id'];
		$Film->DeleteActor($film_id, $actor_id);
		$Actor->Clear();
	}

	public function actionSearch()
	{
		$Films = Film::Instance();
		$view = new View();

		if (!isset($_GET['name']) || $_GET['name'] == "") {
			die('Failed request');
		}

		$films = $Films->getFilmByName($_GET['name']);

		$getActors = function ($film) {
			$Films = Film::Instance();
			$film['actors'] = $Films->GetActors($film['film_id']);

			return $film;
		};
		$view->films = array_map($getActors, $films);

		$view->title = 'Search film';
		$view->content = $view->render('Film/all');
		$view->display();
	}

	public function actionImport()
	{
		$view = new View();
		$Actors = Actor::Instance();
		$Film = Film::Instance();
		$view->title = 'Import page';
		$view->content = $view->render('Film/import');
		$view->display();
		if (isset($_FILES['file'])) {
			if ($_FILES['file']['type'] != 'text/plain' && $_FILES['file']['type'] != 'text/html') {
				die('Failed file type');
			}

			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while (!feof($handle)) {
				$buffer = fgets($handle, 4096);

				if (strpos($buffer, STR_TITLE) !== false) {
					$film_name = substr($buffer, strlen(STR_TITLE), -1);
				}

				if (strpos($buffer, STR_YEAR) !== false) {
					$film_year = substr($buffer, strlen(STR_YEAR), -1);
				}

				if (strpos($buffer, STR_FORMAT) !== false) {
					$film_format = substr($buffer, strlen(STR_FORMAT), -1);
				}

				if (strpos($buffer, STR_ACTOR) !== false) {
					$film_actors = substr($buffer, strlen(STR_ACTOR), -1);
				}

				if (strlen($buffer) == 1) {
					$actors = explode(', ', $film_actors);

					$film = $Film->getFilmByName($film_name);
					if (empty($film)) {
						$film_id = $Film->Add($film_name, $film_year, $film_format);
					}
					else {
						$film_id = $Film->getFilmByName($film_name)[0]['film_id'];
					}

					foreach ($actors as $actor) {
						$first_name = explode(' ', $actor)[0];
						$last_name = explode(' ', $actor)[1];

						$tmp = $Actors->getUserByNames($first_name, $last_name);
						if (!$tmp) {
							$actor_id = $Actors->Add($first_name, $last_name);
						}
						else {
							$actor_id = $tmp[0]['actor_id'];
						}
						if (!$Film->isActors($film_id, $actor_id)) {
							$Film->AddActor($film_id, $actor_id);
						}
					}

				}
			}
			fclose($handle);
			header('Location: /');
			exit;
		}
	}

	public function actionDelete()
	{
		$Film = Film::Instance();
		$Actor = Actor::Instance();
		if (isset($_GET['film_id'])) {
			$Film->Delete($_GET['film_id']);
		}
		else {
			die('Failed request');
		}
		$Actor->Clear();
		$this->actionAll();
	}
}