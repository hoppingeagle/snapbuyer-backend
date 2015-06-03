<?php namespace Snapbuyer\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Snapbuyer\Allegro\AllegroService;

class RefreshCache extends Command {

    private $allegroService;

    function __construct()
    {
        $this->allegroService = new AllegroService();
    }

    /**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'refreshCache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh offers cache';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->allegroService->getRandomOffers();
		$this->allegroService->getOffersWithPreferences();
        Log::info('Refreshed caches');
	}

}
