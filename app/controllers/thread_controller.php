<?php

class ThreadController extends AppController
{
	public function index()
	{
		$this->set(get_defined_vars());
	}
}