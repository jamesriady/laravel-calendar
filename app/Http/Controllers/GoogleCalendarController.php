<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendar;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
	private $googleCalendar;

	public function __construct(GoogleCalendar $googleCalendar) 
	{
		$this->googleCalendar = $googleCalendar;
	}

    public function connect() 
    {
    	$client = $this->googleCalendar->getClient();
        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    public function store(Request $request)
    {
    	$client = $this->googleCalendar->getClient();
        $authCode = $request->code;
        Log::info($authCode);
        
        // Load previously authorized credentials from a file.
        $credentialsPath = public_path('credentials_generated.json');
        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        return redirect('/google-calendar')->with('message', 'Credentials saved');
    }

    public function getResources()
	{
        // Get the authorized client object and fetch the resources.
        $client = $this->googleCalendar->oauth();
        return $this->googleCalendar->getResource($client);

	 }
}
