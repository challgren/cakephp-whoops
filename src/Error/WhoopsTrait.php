<?php
declare(strict_types=1);

namespace CakephpWhoops\Error;

use Cake\Core\Configure;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

trait WhoopsTrait {

	protected ?Run $_whoops = null;

	/**
	 * @return \Whoops\Run
	 */
	protected function getWhoopsInstance(): Run {
		if ($this->_whoops === null) {
			$this->_whoops = new Run();
		}

		return $this->_whoops;
	}

	/**
	 * @return \Whoops\Handler\PrettyPageHandler
	 */
	protected function getHandler(): HandlerInterface {
		$handler = new PrettyPageHandler();
		if (!Configure::read('Whoops.editor')) {
			return $handler;
		}

		$handler->setEditor(function ($file, $line) {
			$userPath = Configure::read('Whoops.userBasePath');
			$serverPath = Configure::read('Whoops.serverBasePath');
			if ($userPath && $serverPath) {
				$file = str_replace($serverPath, $userPath, $file);
			}
			$pattern = Configure::read('Whoops.ideLinkPattern') ?: 'phpstorm://open?file=%s&line=%s';
			$url = sprintf($pattern, $file, $line);
			if (!Configure::read('Whoops.asAjax', false)) {
				return $url;
			}

			return [
				'url' => $url,
				'ajax' => true,
			];
		});

		return $handler;
	}

}
