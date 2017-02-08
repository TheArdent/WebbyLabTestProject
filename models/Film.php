<?php

class Film
{
	private static $instance;

	public static function Instance()
	{
		if (self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{
	}

	public function Add($name, $year, $format)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Insert(
			'films',
			[
				'name'   => $name,
				'year'   => $year,
				'format' => $format
			]
		);
	}

	public function AddActor($film_id, $actor_id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Insert(
			'actorsatfilms',
			[
				'film_id'  => $film_id,
				'actor_id' => $actor_id,
			]
		);
	}

	public function Edit($id, $film_name, $film_format, $film_year)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Update(
			'films',
			[
				'name'   => $film_name,
				'format' => $film_format,
				'year'   => $film_year
			],
			'film_id =' . $id
		);
	}

	public function All($order, $type)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select("SELECT * FROM films ORDER BY {$order} {$type}");
	}

	public function Get($id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select("SELECT * FROM films WHERE film_id = {$id}")[0];
	}

	public function GetActors($id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select(
			"select * from films f, actors a, actorsatfilms a2f where f.film_id = a2f.film_id and a2f.actor_id = a.actor_id and f.film_id = {$id}"
		);
	}

	public function getFilmByName($name)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select("SELECT * FROM films WHERE films.name LIKE '%{$name}%'");
	}

	public function isActors($film_id, $actor_id)
	{
		foreach ($this->GetActors($film_id) as $actor) {
			if ($actor['actor_id'] == $actor_id) {
				return true;
			}
		}

		return false;
	}

	public function DeleteActor($film_id, $actor_id)
	{
		$My_DB = DB::GetInstance();
		$query = 'film_id =' . $film_id . ' and actor_id =' . $actor_id;

		return $My_DB->Delete('actorsatfilms', $query);
	}

	public function Delete($id)
	{
		$My_DB = DB::GetInstance();

		return [$My_DB->Delete('films', 'film_id =' . $id), $My_DB->Delete('actorsatfilms', 'film_id =' . $id)];
	}
}