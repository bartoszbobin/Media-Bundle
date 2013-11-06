<?php
namespace Bobin\MediaBundle\Data;

class FileInfo
{
	const SEPARATOR = "x";
	
	private $width;
	private $height;
	private $mimeType;
	private $filePath;
	
	public function __construct($filePath)
	{
		list($this->width, $this->height, $imageType) = getimagesize($filePath);
		$this->mimeType = image_type_to_mime_type($imageType);
		$this->filePath = $filePath;
	}
	
	public function getWidth()
	{
		return $this->width;
	}
	
	public function getHeight()
	{
		return $this->height;
	}
	
	public function getMimeType()
	{
		return $this->mimeType;
	}
	
	public function getFilePath()
	{
		return $this->filePath;
	}
}