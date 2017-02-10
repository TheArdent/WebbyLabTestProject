<?php

class ActorController
{
	public function actionIndex()
	{
		$view = new View();
		$view->title = 'Actor List';
		$view->content = $view->render('Actor/index');
		$view->display();
	}

	public function actionAll()
	{
		$Actors = Actor::Instance();
		$view = new View();

		$getFilms = function ($actor) {
			$Actors = Actor::Instance();
			$film['actors'] = $Actors->Get($actor['actor_id']);
			$film['films'] = $Actors->getFilms($actor['actor_id']);

			return $film;
		};
		if (!empty($Actors->All('actor_id', 'ASC')))
			$view->actors = array_map($getFilms, $Actors->All('actor_id', 'ASC'));

		echo $view->render('Actor/all');
	}

	public function actionSearch()
	{
		$Actors = Actor::Instance();
		$view = new View();
		$view->title = 'Search actor';
		if (!isset($_GET['name']) || $_GET['name'] == "") {
			die('Failed request');
		}
		$name = $_GET['name'];
		$actors = $Actors->getActorByNames($name);

		if (empty($actors)) {
			$actors = $Actors->getActorByNames(explode(' ', $name)[0]);
		}//FIRST NAME

		if (empty($actors)) {
			$actors = $Actors->getActorByNames(explode(' ', $name)[1]);
		}//LAST NAME

		$getFilms = function ($actor) {
			$Actors = Actor::Instance();
			$film['actors'] = $Actors->Get($actor['actor_id']);
			$film['films'] = $Actors->getFilms($actor['actor_id']);

			return $film;
		};

		$view->actors = array_map($getFilms, $actors);

		$view->content = $view->render('Actor/all');
		$view->display();
	}
}