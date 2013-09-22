<?php
namespace Bobin\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Bobin\MediaBundle\Data\MediaSize;
use Bobin\MediaBundle\Data\FileInfo;
use Bobin\MediaBundle\FileCreator\FileJpegCreator;
use Bobin\MediaBundle\FileCreator\FileGifCreator;
use Bobin\MediaBundle\FileCreator\FilePngCreator;
use Bobin\MediaBundle\FileCreator\FileBmpCreator;

class FileController extends Controller
{

	/**
	 * @return Bobin\MediaBundle\Manager\NamespaceManager
	 */
	private function getMediaNamespaceManager() {
		return $this->get("bobin_media.namespace_manager");
	}
	
	public function generateAction($namespace, $directory = '', $size, $fileName)
	{
		$namespace = $this->getMediaNamespaceManager()->getMediaNamespace($namespace);
		//verify if size is allowed
		$mediaSize = $namespace->getMediaSize(new MediaSize($size));
		
		//verify if oryginal file exists
		$mediaPath = $namespace->getMediaPath($directory);
		$sourceFilePath = $mediaPath . 'oryg/' . $fileName;
		$newFilePath = $mediaPath . $mediaSize . '/' . $fileName;

		if (!file_exists ($sourceFilePath)) {
			throw $this->createNotFoundException('The oryginal file `'.$sourceFilePath.'` does not exist');
		}
		
		//generate dir structure and index.html file to prevent listing directory
		$this->createSizeDirIfNotExists($mediaPath, $mediaSize);
		
		//Generate new size for file
		$sourceFileInfo = new FileInfo($sourceFilePath);
		
		$newFileCreator = $this->getCreatorByMimeType($sourceFileInfo);
		$newFileCreator->setMediaSize($mediaSize);
		$newFileCreator->createAndSave($newFilePath);
		
		//Redirect into new file;
		$redirectUrl = $this->generateUrl(
            $request = $this->getRequest()->get('_route'),
            array(
				'size' => $mediaSize,
				'directory' => $directory,
				'fileName' => $fileName,
				'time' => time()
			),
			true
        );
		
		return new RedirectResponse($redirectUrl);
    }
	
	private function getCreatorByMimeType(FileInfo $fileInformation)
	{
		switch($fileInformation->getMimeType())
		{
			case 'image/gif':
				return new FileGifCreator($fileInformation);
			case 'image/png':
				return new FilePngCreator($fileInformation);
			case 'image/x-ms-bmp':
				return new FileBmpCreator($fileInformation);
		}

		return new FileJpegCreator($fileInformation);
	}
	
	private function createSizeDirIfNotExists($pathToDir, MediaSize $mediaSize) {
		if (!is_dir($pathToDir . $mediaSize)) {
			mkdir($pathToDir . $mediaSize);
		}
		chmod($pathToDir . $mediaSize, 0777);
		$indexFile = $pathToDir . $mediaSize . '/index.html';
		if (!file_exists($indexFile))
		{
			file_put_contents($indexFile, ' ');
		}
	}

}