<?php
/**
 * ownCloud - testapp
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Morris Jobke 2014
 */

namespace OCA\TestApp\Controller;


use OCP\Files\Folder;
use \OCP\IRequest;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Controller;

class PageController extends Controller {

    private $userId;

    public function __construct($appName, IRequest $request, $userId, Folder $folder){
        parent::__construct($appName, $request);
        $this->userId = $userId;
		/** @var \OCP\Files\Folder folder */
		$this->folder = $folder;

		$folder2 = $folder->getDirectoryListing();
		foreach ($folder2 as $folder3) {
			\OCP\Util::writeLog('scanFolder', $folder3->getName(), \OC_Log::ERROR);

			if ($folder3 instanceof \OCP\Files\Folder) {
				$folder4 = $folder3->getDirectoryListing();

				foreach ($folder4 as $folder5) {
					\OCP\Util::writeLog('scanFolder2', $folder5->getName(), \OC_Log::ERROR);
				}
			}
		}
    }


    /**
     * CAUTION: the @Stuff turn off security checks, for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index() {
        $params = array('user' => $this->userId);
        return new TemplateResponse('testapp', 'main', $params);  // templates/main.php
    }


    /**
     * Simply method that posts back the payload of the request
     * @NoAdminRequired
     */
    public function doEcho($echo) {
        return array('echo' => $echo);
    }


}