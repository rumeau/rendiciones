<?php
namespace Registry\AssetManager\Resolver;

use AssetManager\Resolver\ResolverInterface;
use SplFileInfo;
use Traversable;
use Zend\Stdlib\SplStack;
use Assetic\Asset\FileAsset;
use AssetManager\Exception;
use AssetManager\Service\MimeResolver;
use AssetManager\Resolver\MimeResolverAwareInterface;

class DirectoryWildcard implements ResolverInterface, MimeResolverAwareInterface
{
/**
     * @var SplStack
     */
    protected $wildcards;

    /**
     * Flag indicating whether or not LFI protection for rendering view scripts is enabled
     *
     * @var bool
     */
    protected $lfiProtectionOn = true;

    /**
     * The mime resolver.
     *
     * @var MimeResolver
     */
    protected $mimeResolver;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wildcards = new SplStack();
    }

    /**
     * Set the mime resolver
     *
     * @param MimeResolver $resolver
     */
    public function setMimeResolver(MimeResolver $resolver)
    {
        $this->mimeResolver = $resolver;
    }

    /**
     * Get the mime resolver
     *
     * @return MimeResolver
     */
    public function getMimeResolver()
    {
        return $this->mimeResolver;
    }

    /**
     * Add many paths to the stack at once
     *
     * @param array|Traversable $paths
     */
    public function addWildcards($wildcards)
    {
        foreach ($wildcards as $wildcard) {
            $this->addWildcard($wildcard);
        }
    }

    /**
     * Rest the path stack to the paths provided
     *
     * @param  Traversable|array                  $paths
     * @throws Exception\InvalidArgumentException
     */
    public function setWildcards($wildcards)
    {
        if (!is_array($wildcards) && !$wildcards instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid argument provided for $paths, expecting either an array or Traversable object, "%s" given',
                is_object($wildcards) ? get_class($wildcards) : gettype($wildcards)
            ));
        }

        $this->clearWildcards();
        $this->addWildcards($wildcards);
    }

    /**
     * Normalize a path for insertion in the stack
     *
     * @param  string $path
     * @return string
     */
    protected function normalizeWildcard($wildcard)
    {
        $key = key($wildcard);
        $val = $wildcard[$key];

        $alias = rtrim($key, '/\\');

        $path = rtrim($val, '/\\');
        $path .= DIRECTORY_SEPARATOR;

        return array($alias => $path);
    }

    /**
     * Add a single path to the stack
     *
     * @param  string                             $path
     * @throws Exception\InvalidArgumentException
     */
    public function addWildcard($wildcard)
    {
        if (!is_array($wildcard)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid path provided; must be an array with and alias => path, received %s',
                gettype($wildcard)
            ));
        }

        $this->wildcards[] = $this->normalizeWildcard($wildcard);
    }

    /**
     * Clear all paths
     *
     * @return void
     */
    public function clearWildcards()
    {
        $this->wildcards = new SplStack();
    }

    /**
     * Returns stack of paths
     *
     * @return SplStack
     */
    public function getWildcards()
    {
        return $this->wildcards;
    }

    /**
     * Set LFI protection flag
     *
     * @param  bool $flag
     * @return self
     */
    public function setLfiProtection($flag)
    {
        $this->lfiProtectionOn = (bool) $flag;
    }

    /**
     * Return status of LFI protection flag
     *
     * @return bool
     */
    public function isLfiProtectionOn()
    {
        return $this->lfiProtectionOn;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($name)
    {
        if ($this->isLfiProtectionOn() && preg_match('#\.\.[\\\/]#', $name)) {
            return null;
        }

        $file = @basename($name);
        $alias = str_replace($file, '', $name);
        $alias = rtrim($alias, '/\\');

        $wildcards = $this->getWildcards();
        foreach ($wildcards as $w) {
            if (key($w) != $alias) {
                continue;
            }

            $file = new SplFileInfo($w[$alias] . $file);

            if ($file->isReadable() && !$file->isDir()) {
                $filePath = $file->getRealPath();
                $mimeType = $this->getMimeResolver()->getMimeType($filePath);
                $asset    = new FileAsset($filePath);

                $asset->mimetype = $mimeType;

                return $asset;
            }
        }

        return null;
    }
}
