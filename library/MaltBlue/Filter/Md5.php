<?php

/**
 * Malt Blue
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   MaltBlue
 * @package    MaltBlue_Filter
 * @copyright  Copyright (c) 2005-2011 Malt Blue. (http://www.maltblue.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @category   MaltBlue
 * @package    MaltBlue_Filter
 * @copyright  Copyright (c) 2005-2011 Malt Blue. (http://www.maltblue.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class MaltBlue_Filter_Md5 implements Zend_Filter_Interface
{
    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns an md5 hash of the value passed in
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        return md5($value);
    }
}