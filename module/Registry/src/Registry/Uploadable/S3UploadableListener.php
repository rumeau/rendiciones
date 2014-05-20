<?php
namespace Registry\Uploadable;

use Aws\Common\Aws;
use Gedmo\Uploadable\UploadableListener,
    Gedmo\Exception\UploadablePartialException,
    Gedmo\Exception\UploadableCantWriteException,
    Gedmo\Exception\UploadableExtensionException,
    Gedmo\Exception\UploadableFormSizeException,
    Gedmo\Exception\UploadableIniSizeException,
    Gedmo\Exception\UploadableNoFileException,
    Gedmo\Exception\UploadableNoTmpDirException,
    Gedmo\Exception\UploadableUploadException,
    Gedmo\Exception\UploadableFileAlreadyExistsException,
    Gedmo\Exception\UploadableMaxSizeException,
    Gedmo\Uploadable\FileInfo\FileInfoInterface;

class S3UploadableListener extends UploadableListener
{
    protected $aws;

    protected $s3Client;

    protected $storageConfig;

    public function __construct($mimeTypeGuesser = null)
    {
        parent::__construct($mimeTypeGuesser = null);
    }

    public function addS3Support(Aws $aws, $config = array())
    {
        $this->aws = $aws;
        $this->storageConfig = $config;
        $this->s3Client = $aws->get('s3');
        $this->s3Client->registerStreamWrapper();
    }

    /**
     * Moves the file to the specified path
     *
     * @param FileInfo\FileInfoInterface $fileInfo
     * @param $path
     * @param bool $filenameGeneratorClass
     * @param bool $overwrite
     * @param bool $appendNumber
     * @param $object
     * @return array
     * @throws \Gedmo\Exception\UploadableUploadException
     * @throws \Gedmo\Exception\UploadableNoFileException
     * @throws \Gedmo\Exception\UploadableExtensionException
     * @throws \Gedmo\Exception\UploadableIniSizeException
     * @throws \Gedmo\Exception\UploadableFormSizeException
     * @throws \Gedmo\Exception\UploadableFileAlreadyExistsException
     * @throws \Gedmo\Exception\UploadablePartialException
     * @throws \Gedmo\Exception\UploadableNoTmpDirException
     * @throws \Gedmo\Exception\UploadableCantWriteException
     */
    public function moveFile(FileInfoInterface $fileInfo, $path, $filenameGeneratorClass = false, $overwrite = false, $appendNumber = false, $object)
    {
        if ($fileInfo->getError() > 0) {
            switch ($fileInfo->getError()) {
                case 1:
                    $msg = 'Size of uploaded file "%s" exceeds limit imposed by directive "upload_max_filesize" in php.ini';

                    throw new UploadableIniSizeException(sprintf($msg, $fileInfo->getName()));
                case 2:
                    $msg = 'Size of uploaded file "%s" exceeds limit imposed by option MAX_FILE_SIZE in your form.';

                    throw new UploadableFormSizeException(sprintf($msg, $fileInfo->getName()));
                case 3:
                    $msg = 'File "%s" was partially uploaded.';

                    throw new UploadablePartialException(sprintf($msg, $fileInfo->getName()));
                case 4:
                    $msg = 'No file was uploaded!';

                    throw new UploadableNoFileException(sprintf($msg, $fileInfo->getName()));
                case 6:
                    $msg = 'Upload failed. Temp dir is missing.';

                    throw new UploadableNoTmpDirException($msg);
                case 7:
                    $msg = 'File "%s" couldn\'t be uploaded because directory is not writable.';

                    throw new UploadableCantWriteException(sprintf($msg, $fileInfo->getName()));
                case 8:
                    $msg = 'A PHP Extension stopped the uploaded for some reason.';

                    throw new UploadableExtensionException(sprintf($msg, $fileInfo->getName()));
                default:
                    throw new UploadableUploadException(sprintf('There was an unknown problem while uploading file "%s"',
                        $fileInfo->getName()
                    ));
            }
        }

        $info = array(
            'fileName'          => '',
            'fileExtension'     => '',
            'fileWithoutExt'    => '',
            'origFileName'      => '',
            'filePath'          => '',
            'fileMimeType'      => $fileInfo->getType(),
            'fileSize'          => $fileInfo->getSize()
        );

        $info['fileName'] = basename($fileInfo->getName());
        $info['filePath'] = $path.'/'.$info['fileName'];

        $hasExtension = strrpos($info['fileName'], '.');

        if ($hasExtension) {
            $info['fileExtension'] = substr($info['filePath'], strrpos($info['filePath'], '.'));
            $info['fileWithoutExt'] = substr($info['filePath'], 0, strrpos($info['filePath'], '.'));
        } else {
            $info['fileWithoutExt'] = $info['fileName'];
        }

        // Save the original filename for later use
        $info['origFileName'] = $info['fileName'];

        // Now we generate the filename using the configured class
        if ($filenameGeneratorClass) {
            $filename = $filenameGeneratorClass::generate(
                str_replace($path.'/', '', $info['fileWithoutExt']),
                $info['fileExtension'],
                $object
            );
            $info['filePath'] = str_replace(
                '/'.$info['fileName'],
                '/'.$filename,
                $info['filePath']
            );
            $info['fileName'] = $filename;

            if ($pos = strrpos($info['filePath'], '.')) {
                // ignores positions like "./file" at 0 see #915
                $info['fileWithoutExt'] = substr($info['filePath'], 0, $pos);
            } else {
                $info['fileWithoutExt'] = $info['filePath'];
            }
        }

        if (is_file($info['filePath'])) {
            if ($overwrite) {
                $this->removeFile($info['filePath']);
            } else if ($appendNumber) {
                $counter = 1;
                $info['filePath'] = $info['fileWithoutExt'].'-'.$counter.$info['fileExtension'];

                do {
                    $info['filePath'] = $info['fileWithoutExt'].'-'.(++$counter).$info['fileExtension'];
                } while (is_file($info['filePath']));
            } else {
                throw new UploadableFileAlreadyExistsException(sprintf('File "%s" already exists!',
                    $info['filePath']
                ));
            }
        }

        if (!$this->doMoveFile($fileInfo->getTmpName(), $info, $fileInfo->isUploadedFile())) {
            throw new UploadableUploadException(sprintf('File "%s" was not uploaded, or there was a problem moving it to the location "%s".',
                $fileInfo->getName(),
                $path
            ));
        }

        return $info;
    }

    /**
     * Simple wrapper method used to move the file. If it's an uploaded file
     * it will use the "move_uploaded_file method. If it's not, it will
     * simple move it
     *
     * @param string - Source file
     * @param string - Destination file
     * @param bool - Is an uploaded file?
     *
     * @return bool
     */
    public function doMoveFile($source, $info, $isUploadedFile = true)
    {
        $dest = $info['filePath'];
        $mime = $info['fileMimeType'];
        $data = array(
            'Bucket' => $this->storageConfig['bucket'],
            'Key' => $dest,
            'SourceFile' => $source,
            'Owner' => $this->storageConfig['owner'],
            'ACL' => 'public-read',
            'ContentType' => $mime
        );

        try {
            $this->s3Client->putObject($data);
            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}
