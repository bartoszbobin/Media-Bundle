<?php
namespace Bobin\MediaBundle\FileCreator;

use Bobin\MediaBundle\Data\MediaSize;
use Bobin\MediaBundle\Data\FileInfo;

abstract class FileCreator 
{
	private $fileInformation;
	private $mediaSize;
	
	public function __construct(FileInfo $fileInformation)
	{
		$this->fileInformation = $fileInformation;
	}
	
	public function setMediaSize(MediaSize $mediaSize)
	{
		$this->mediaSize = $mediaSize;
	}
	
	public function getFileInformation()
	{
		return $this->fileInformation;
	}
	
	abstract protected function createImage();
	abstract protected function createFile($newFileImage, $newFilePath);
	
	public function createAndSave($newFilePath)
	{
		$scale = $this->calculateScale();
		
		$newFileWidth = (int) $this->fileInformation->getWidth() / $scale;
		$newFileHeight = (int) $this->fileInformation->getHeight() / $scale;
		
		$newFileWidth = (int) min( $newFileWidth, 2000 );
		$newFileHeight = (int) min( $newFileHeight, 2000 );	
		
		$sourceFileImage = $this->createImage();
		
		if ($this->mediaSize->getWidth() > 0 && $this->mediaSize->getHeight() > 0)
		{
			$i_width 	= $this->mediaSize->getWidth();
			$i_height 	= $this->mediaSize->getHeight();
		} else {
			$i_width 	= $newFileWidth;
			$i_height 	= $newFileHeight;
		}
		
		if (!$this->mediaSize->isResizeSmallToSize())
		{
			if ($newFileWidth > $this->fileInformation->getWidth() || $newFileHeight > $this->fileInformation->getHeight())
			{
				$newFileWidth 	= $this->fileInformation->getWidth() ;
				$newFileHeight 	= $this->fileInformation->getHeight();

				$i_width 	= $this->fileInformation->getWidth() ;
				$i_height	= $this->fileInformation->getHeight();
			}
		}
		
		$newFileImage = imagecreatetruecolor( $i_width, $i_height );
			
		$sourceImageoffset = array( 'x' => 0, 'y' => 0);
		
		if ($this->mediaSize->isFitBigToSize()) {
			if ( $i_width < $newFileWidth) {
				$sourceImageoffset['x'] = trim ( $i_width - $newFileWidth ) / 2;
			}
			if ( $i_height < $newFileHeight) {
				$sourceImageoffset['y'] = trim ( $i_height - $newFileHeight ) / 2;
			}
		}

      	imagefill($newFileImage, 0, 0, imagecolorallocate($newFileImage, 255, 255, 255));
		imageAntiAlias($newFileImage, true);
		imagecopyresampled(
			$newFileImage,
			$sourceFileImage,
			$sourceImageoffset['x'],
			$sourceImageoffset['y'],
			0,
			0,
			$newFileWidth,
			$newFileHeight,
			$this->fileInformation->getWidth() ,
			$this->fileInformation->getHeight()
		);
		
		$this->createFile($newFileImage, $newFilePath);
		imagedestroy($newFileImage);
	}
	
	private function calculateScale()
	{
		if ($this->mediaSize->getWidth() > 0)
		{
			$scaleHorizontal = (float) $this->fileInformation->getWidth() / $this->mediaSize->getWidth();
		}
		
		if ($this->mediaSize->getHeight() > 0 )
		{
			$scaleVertical = (float) $this->fileInformation->getHeight() / $this->mediaSize->getHeight();
		}
		
		if ($this->mediaSize->getWidth() == 0)
		{
			$scaleHorizontal = (float) $scaleVertical;
		}
		
		if ($this->mediaSize->getHeight() == 0)
		{
			$scaleVertical = (float) $scaleHorizontal;
		}
		
		if ($this->mediaSize->isFitBigToSize())
		{
			return ($scaleHorizontal > $scaleVertical) ? $scaleVertical : $scaleHorizontal;
		}

		return ($scaleHorizontal > $scaleVertical) ? $scaleHorizontal : $scaleVertical;
	}
}