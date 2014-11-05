<?php
	/**
	 * More Infos Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */
	require_once __DIR__."/php-github-api/vendor/autoload.php";


	class InfosController extends AppController {
		public function		git() {
			$owner = "Ne02ptzero";
			$repo = "espace-createur";
			$client = new Github\Client(
				new \Github\HttpClient\CachedHttpClient(array('cache_dir' => "/tmp/github-api-cache"))
			);
			$commits = $client->api('repo')->commits()->all($owner, $repo, array("sha" => "master"));
			$this->set("commits", $commits);
		}
	}
?>
