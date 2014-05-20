<?php
namespace Registry\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\FilePostRedirectGet as ZendFilePostRedirectGet;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\CollectionInputFilter;

class CustomFilePostRedirectGet extends ZendFilePostRedirectGet
{
    /**
     * Traverse the InputFilter and run a callback against each Input and associated value
     *
     * @param  InputFilterInterface $inputFilter
     * @param  array                $values
     * @param  callable             $callback
     * @return array|null
     */
    protected function traverseInputs(InputFilterInterface $inputFilter, $values, $callback)
    {
        $returnValues = null;
        foreach ($values as $name => $value) {
            if (!$inputFilter->has($name)) {
                continue;
            }

            $input = $inputFilter->get($name);
            if ($input instanceof CollectionInputFilter && is_array($value)) {
                foreach ($value as $key => $collectionValue) {
                    $retVal = $this->traverseInputs($input, $collectionValue, $callback);
                    if (null !== $retVal) {
                        $returnValues[$name][$key] = $retVal;
                    }
                    continue;
                }
            } elseif ($input instanceof InputFilterInterface && is_array($value)) {
                $retVal = $this->traverseInputs($input, $value, $callback);
                if (null !== $retVal) {
                    $returnValues[$name] = $retVal;
                }
                continue;
            }

            $retVal = $callback($input, $value);
            if (null !== $retVal) {
                $returnValues[$name] = $retVal;
            }
        }

        return $returnValues;
    }
}
