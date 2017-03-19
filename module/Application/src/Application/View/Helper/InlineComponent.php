<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   10.03.2017
 */
namespace Application\View\Helper;

use Zend\View\Helper\HeadScript;

class InlineComponent extends HeadScript
{
    /**
     * Registry key for placeholder
     *
     * @var string
     */
    protected $regKey = 'Zend_View_Helper_InlineComponent';

    /**
     * @param string $mode
     * @param null $spec
     * @param string $placement
     * @param array $attrs
     * @param string $type
     * @return HeadScript
     */
    public function __invoke(
        $mode = self::FILE,
        $spec = null,
        $placement = 'APPEND',
        array $attrs = [],
        $type = 'text/javascript'
    )
    {
        return parent::__invoke($mode, $spec, $placement, $attrs, $type);
    }
}