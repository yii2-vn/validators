<?php
/**
 * @link http://github.com/yii2vn/esms
 * @copyright Copyright (c) 2017 Yii2VN
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2vn\validators;

use Yii;
use yii\base\InvalidConfigException;
use yii\validators\Validator;
use yii\validators\RegularExpressionValidator;

/**
 * Validator hổ trợ kiểm tra số điện thoại di động tại Việt Nam
 *
 * @package yii2vn\esms
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class MobileNumberValidator extends RegularExpressionValidator {

    public $telNet = "all";

    public $viettelPattern = '/^(\+?84|0)(9[6-8]|16[2-9]|868)[\d]{7}$/';

    public $vinaPattern = '/^(\+?84|0)(91|94|12[3-5]|127|129|88)[\d]{7}$/';

    public $mobiPattern = '/^(\+?84|0)(90|93|12[0-2]|126|128|89)[\d]{7}$/';

    public $vnmobiPattern = '/^(\+?84|0)(92|188|186)[\d]{7}$/';

    public $beelinePattern = '/^(\+?84|0)(99[3-7])[\d]{7}$/';

    public $gmobilePattern = '/^(\+?84|0)199[\d]{7}$/';

    public $vsatPattern = '/^(\+?84|0)992[\d]{7}$/';

    public $indochinaPattern = '/^(\+?84|0)99(8|9)[\d]{7}$/';

    private $telNetPattern = [];

    public function init() {
        Validator::init();
        if ($this->telNet === "all") {
            $reflector = new \ReflectionClass($this);
            foreach ($reflector->getProperties() as $property) {
                $propertyName = $property->getName();
                if (strpos($propertyName, "Pattern") === strlen($propertyName) - 7 && $propertyName !== 'telNetPattern') {
                    array_push($this->telNetPattern, trim($this->$propertyName, '/'));
                }
            }
        } elseif ($this->hasProperty($this->telNet . "Pattern")) {
            $pattenProperty = $this->telNet . "Pattern";
            $this->telNetPattern = $this->$pattenProperty;
        } else {
            throw new InvalidConfigException("Invalid telnet");
        }
        $arrayPattern = (array) $this->telNetPattern;
        $this->pattern = "/(" . implode(")|(", $arrayPattern) . ")/";
        //     var_dump($this->pattern); die;
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} must be an phone number.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value) {
        return parent::validateValue($value);
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view) {
        return parent::clientValidateAttribute($model, $attribute, $view);
    }

}
