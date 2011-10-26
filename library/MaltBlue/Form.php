<?php

class MaltBlue_Form extends Zend_Form
{
    const SORT_LIST_ASC = 'asc';
    const SORT_LIST_DESC = 'desc';
    const SORT_LIST_NONE = 'none';
    
    public function prefixList($listData, $listPrefix, $sort=self::SORT_LIST_ASC)
    {
        if (!empty($listData) && !empty($listPrefix)) {
            if (is_string($listPrefix)) {
                $listData[''] = $listPrefix;
            }
            
            if (is_array($listPrefix)) {
                list($value, $label) = each($listPrefix);
                $listData[$value] = $label;
            }
            
            switch($sort) {
                case (self::SORT_LIST_ASC):
                    asort($listData);
                break;
                case (self::SORT_LIST_DESC):
                    arsort($listData);
                break;
                default:
                    // do nothing...
            }
            
            return $listData;
        }
    }
    
    /**
     * A simple function to verify if a button was clicked
     */
    public function wasButtonClicked($buttonName)
    {
        if ($this->getValue($buttonName)) {
            return TRUE;
        }
        return FALSE;
    }
}