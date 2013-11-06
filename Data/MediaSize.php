<?php
namespace Bobin\MediaBundle\Data;

class MediaSize 
{
	const SEPARATOR = "x";
	
	private $width;
	private $height;
	private $fitBigToSize = true;
	private $resizeSmallToSize = true;
	private $backgroundColor = '#FFFFFF';
	
	public function __construct($size = "") {
		$sizeArray = explode(self::SEPARATOR, $size);
		if (count($sizeArray) != 2)
		{
			return;
		}
		$this->width = (int) $sizeArray[0];
		$this->height = (int) $sizeArray[1];
	}
	
	public function __toString()
	{
		return $this->getSize();
	}
	
	public function getSize()
	{
		return $this->width . self::SEPARATOR . $this->height;
	}
	
	public function equals(MediaSize $object)
	{
		return $this->getSize() === $object->getSize();
	}
	
	public function getWidth()
	{
		return $this->width;
	}
	
	public function getHeight()
	{
		return $this->height;
	}

	public function isResizeSmallToSize()
	{
		return $this->resizeSmallToSize;
	}

	public function isFitBigToSize()
	{
		return $this->fitBigToSize;
	}
	
	public function setWidth($width)
	{
		$this->width = $width;
	}

	public function setHeight($height)
	{
		$this->height = $height;
	}
	public function setResizeSmallToSize($resizeSmallToSize)
	{
		$this->resizeSmallToSize = $resizeSmallToSize;
	}

	public function setFitBigToSize($fitBigToSize)
	{
		$this->fitBigToSize = $fitBigToSize;
	}
	

}