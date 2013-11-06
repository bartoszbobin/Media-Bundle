<?php
namespace Bobin\MediaBundle\FileCreator;

use Bobin\MediaBundle\Data\MediaSize;
use Bobin\MediaBundle\Data\FileInfo;

class FilePngCreator extends FileCreator
{
	protected function createImage()
	{
		return imagecreatefrompng($this->getFileInformation()->getFilePath());
	}
	
	protected function createFile($newFileImage, $newFilePath)
	{
		return imagepng($newFileImage, $newFilePath);
	}
} 