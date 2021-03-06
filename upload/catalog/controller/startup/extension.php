<?php
namespace Opencart\Application\Controller\Startup;
class Extension extends \Opencart\System\Engine\Controller {
	public function index() {
		// Add extension paths from the DB
		$this->load->model('setting/extension');

		$results = $this->model_setting_extension->getExtensions();

		foreach ($results as $result) {
			$extension = str_replace(['_', '/'], ['', '\\'], ucwords($result['extension'], '_/'));

			// Register controllers, models and system extension folders
			$this->autoloader->register('Opencart\Application\Controller\Extension\\' . $extension, DIR_EXTENSION . $result['extension'] . '/catalog/controller/');
			$this->autoloader->register('Opencart\Application\Model\Extension\\' . $extension, DIR_EXTENSION . $result['extension'] . '/catalog/model/');
			$this->autoloader->register('Opencart\System\Extension\\' . $extension, DIR_EXTENSION . $result['extension'] . '/system/');

			// Template directory
			$this->template->addPath('extension/' . $result['extension'], DIR_EXTENSION . $result['extension'] . '/catalog/view/template/');

			// Language directory
			$this->language->addPath('extension/' . $result['extension'], DIR_EXTENSION . $result['extension'] . '/catalog/language/');

			// Config directory
			$this->config->addPath('extension/' . $result['extension'], DIR_EXTENSION . $result['extension'] . '/system/config/');
		}
	}
}