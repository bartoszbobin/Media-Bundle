<?php
namespace Bobin\MediaBundle\FileCreator;

use Bobin\MediaBundle\Data\MediaSize;
use Bobin\MediaBundle\Data\FileInfo;

class FileJpegCreator extends FileCreator
{
	protected function createImage()
	{
		return imagecreatefromjpeg($this->getFileInformation()->getFilePath());
	}
	
	protected function createFile($newFileImage, $newFilePath)
	{
		return imagejpeg($newFileImage, $newFilePath, 1000);
	}
} 