<?php
namespace Registry\File;

use Gedmo\Uploadable\FileInfo\FileInfoInterface;

class FileInfo implements FileInfoInterface
{
	protected $fileInfo;
	
	public function __construct(array $fileInfo)
	{
		$keys = array('error', 'size', 'type', 'tmp_name', 'name');
	
		foreach ($keys as $k) {
			if (!isset($fileInfo[$k])) {
				$msg = 'There are missing keys in the fileInfo. ';
				$msg .= 'Keys needed: '.implode(',', $keys);
	
				throw new \RuntimeException($msg);
			}
		}
	
		$this->fileInfo = $fileInfo;
	}
	
	public function getTmpName()
	{
		return $this->fileInfo['tmp_name'];
	}
	
	public function getName()
	{
		return $this->fileInfo['name'];
	}
	
	public function getSize()
	{
		return $this->fileInfo['size'];
	}
	
	public function getType()
	{
		return $this->fileInfo['type'];
	}
	
	public function getError()
	{
		return $this->fileInfo['error'];
	}
	
	public function isUploadedFile()
	{
		return false;
	}
}
