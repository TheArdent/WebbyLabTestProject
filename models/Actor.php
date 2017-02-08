<?php

class Actor
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

	public function Add($first_name, $last_name)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Insert(
			'actors',
			[
				'first_name' => $first_name,
				'last_name'  => $last_name,
			]
		);
	}

	public function All($order, $type)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select("SELECT * FROM actors ORDER BY {$order} {$type}");
	}

	public function Get($id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select("SELECT * FROM actors WHERE actor_id = {$id}")[0];
	}

	public function Delete($actor_id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Delete('actors', 'actor_id =' . $actor_id);
	}

	public function Clear()
	{
		foreach ($this->All('actor_id', 'DESC') as $actor) {
			$actor = $this->getFilms($actor['actor_id']);
			if (empty($actor)) {
				$this->Delete($actor['actor_id']);
			}
		}
	}

	public function getActorByNames($name)//just for search
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select(
			"select * from actors where actors.first_name LIKE '%{$name}%' or actors.last_name LIKE '%{$name}%'"
		);
	}

	public function getFilms($actor_id)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select(
			'select * from films f, actors a, actorsatfilms a2f where f.film_id = a2f.film_id and a2f.actor_id = a.actor_id and a.actor_id =' . $actor_id
		);
	}

	public function getUserByNames($first_name, $last_name)
	{
		$My_DB = DB::GetInstance();

		return $My_DB->Select(
			"SELECT * FROM actors WHERE `first_name` = '{$first_name}' and `last_name` = '{$last_name}'"
		);
	}
}