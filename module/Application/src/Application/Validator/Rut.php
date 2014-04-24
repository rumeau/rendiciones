<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;
use Traversable;

class Rut extends AbstractValidator
{
    const INVALID        = 'rutInvalid';
    const INVALID_TYPE   = 'rutInvalidType';
    
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID        => "Invalid RUT given",
        self::INVALID_TYPE   => "The RUT does not appear to be a valid Client RUT"
    );
        
    /**
     * Optional format
     *
     * @var string|null
     */
    protected $min;
    
    /**
     * Sets validator options
     *
     * @param  string|array|Traversable $options OPTIONAL
     */
    public function __construct($options = array())
    {
        if ($options instanceof Traversable) {
            $options = iterator_to_array($options);
        } elseif (!is_array($options)) {
            $options = func_get_args();
            $temp['min'] = array_shift($options);
            $options = $temp;
        }
        
        if (array_key_exists('min', $options)) {
            $this->setMin($options['min']);
        }
    
        parent::__construct($options);
    }
    
    /**
     * Returns the min option
     *
     * @return string|null
     */
    public function getMin()
    {
        return $this->min;
    }
    
    /**
     * Sets the min option
     *
     * @param  string $min
     * @return provides a fluent interface
     */
    public function setMin($min = null)
    {
        $this->min = $min;
        return $this;
    }
    
    /**
     * Returns true if $value is a valid date of the format YYYY-MM-DD
     * If optional $format is set the date format is checked
     * according to DateTime
     *
     * @param  string|array|int|DateTime $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)
        && !is_array($value)
        && !is_int($value)
        ) {
            $this->error(self::INVALID);
            return false;
        }
        
        $this->setValue($value);
        
        $min = $this->getMin();
        
        if (!is_array($value)) {
            $rut = array(
                'rut' => (int) substr($value, 0, -1),
                'dv'  => substr($value, -1)
            );
            $value = $rut;
        } else {
            $value = array(
                'rut' => (int) $value[0],
                'dv'  => $value[1]
            );
        }
        
        $value['dv'] = strtoupper($value['dv']);
        $validDv     = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'K');
        
        if (is_int($value['rut']) && $value['rut'] > 0 && in_array($value['dv'], $validDv)) {
            if ($min && $value['rut'] < $min) {
                $this->error(self::INVALID_TYPE);
                return false;
            }
            
            $calcDv = $this->calculateDv($value['rut']);
            
            if ($calcDv != $value['dv']) {
                $this->error(self::INVALID);
                return false;
            }
        } else {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
    
    public function calculateDv($rut)
    {
        if (is_int($rut) && $rut > 0) {
            $d = 1;
            for ($x = 0; $rut != 0; $rut /= 10) {
                $d = ($d + $rut % 10 * (9 - $x++ % 6)) % 11;
            }
            
            return chr($d ? $d + 47 : 75);
        } else {
            return false;
        }
    }
}
