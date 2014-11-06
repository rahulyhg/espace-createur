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

		public function		websiteInfo($website) {
			$content = file_get_contents("http://w3techs.com/sites/info/".$website);
			if (strlen(strstr($content, "Magento")) > 0)
				$result = "Magento";
			else if (strlen(strstr($content, "Prestashop")) > 0)
				$result = "Prestashop";
			else if (strlen(strstr($content, "Wordpress")) > 0)
				$result = "Wordpress";
			$this->set("result", $result);
			$this->set("url", $website);
		}
	}
?>
