<?php
namespace Bobin\MediaBundle\FileCreator;

use Bobin\MediaBundle\Data\MediaSize;
use Bobin\MediaBundle\Data\FileInfo;

class FileGifCreator extends FileCreator
{

	protected function createImage()
	{
		return imagecreatefromgif($this->getFileInformation()->getFilePath());
	}
	
	protected function createFile($newFileImage, $newFilePath)
	{
		return imagegif($newFileImage, $newFilePath);
	}
} 