<?php
namespace Bobin\MediaBundle\Data;

use Bobin\MediaBundle\Data\MediaSize;

class MediaNamespace {
	private $mediaPathFromRoot;
	private $sizes = [];
	
	public function __construct(array $namespaceConfig) {
		$this->mediaPathFromRoot = $namespaceConfig['path'];
		$this->sizes = $this->convertMediaSizes($namespaceConfig['sizes']);
	}

	public function getMediaPath($directory) {
		return $this->mediaPathFromRoot . (!empty($directory) ? $directory .'/' : '');
	}

	public function getMediaSize(MediaSize $mediaSize) {
		foreach($this->sizes as $allowedSize)
		{
			if ($allowedSize->equals($mediaSize)) {
				return $allowedSize;
			}
		}

		throw $this->createNotFoundException('Requested media size is not permitted');
	}

	private function convertMediaSizes(array $mediaSizes) {
		$sizes = [];
		foreach ($mediaSizes as $size)
		{
			$mediaSize = new MediaSize();
			$mediaSize->setWidth($size['width']);
			$mediaSize->setHeight($size['height']);
			$mediaSize->setFitBigToSize($size['fit_big_to_size']);
			$mediaSize->setResizeSmallToSize($size['resize_small_to_size']);
			$sizes[] = $mediaSize;
		}
		return $sizes;
	}

}