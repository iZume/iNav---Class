<?php  

/**
 * iNav class
 *
 * @package   iNav
 * @author    iZume <izume32@gmail.com>
 * @link      http://github.com/iZume/iNav-Class
 */

namespace iZume;

class iNav{
    /*
        Output string to renderjkh
    */
    public $output = null;
    
    /*
        Render head from navbar
    */
    public $head = array();

    /*
        Items array
    */
    public $items = array();

    /*
        Navbar config 
         ej: allowedAttr, etc
    */
    public $config = array();

    /*
        String to replace 
    */
    private $replazable = '{{!<:AVAILABLE-SPACE:>!}}';

    /*
        Render head to items
    */
    private $configItem = array();

    private $dropdownItems = array();

    private $dropdownConfig = array();

    function __construct($arr = array(
            'allowedAttr' => array(
                'class' => array(), 
                'id' => array(), 
                'href' => array(
                    'a'
                ),
                'data' => array()
            )
        )) {
        $this->config = $arr;
        
    }
    public function header($arr) {
        $this->head = $arr;
    }
    public function createItem($arr) {
        
        $arr['extra'] = $this->configItem;
        
        $arr['extra']['dropdown']['items'] = $this->dropdownItems;

        $arr['extra']['dropdown']['config'] = $this->dropdownConfig;

        $this->dropdownItems = array();

        //$this->dropdownConfig = array();

        array_push($this->items, $arr);
    }
    public function configDropdown($arr) {
        $this->dropdownConfig = $arr;
    }
    public function clearItem($action) {
        $this->configItem($action, null);
    } 
    public function dropdown($arr){
        array_push($this->dropdownItems, $arr);    
    }
    public function configItem($action, $arr) {
        switch ($action) {
            case 'in': {
                $this->configItem['in'] = $arr;
                break;
            }
            case 'out': {
                $this->configItem['out'] = $arr;
                break;
            }
        }
    }
    public function render(){
        if(array_key_exists('before', $this->head) === TRUE) {
            $this->startAndEnd($this->head['before']);
        }
        if(array_key_exists('start', $this->head) === TRUE) {
            $this->startAndEnd($this->head['start']);
        }   
        $this->renderItems();
        return (str_replace($this->replazable, '', ($this->output)) . "\n");
    }
    private function getElement($arr, $type = 'open') {
        if(array_key_exists('element', $arr) === FALSE) {
            return null;
        }
        $element = $arr['element'];
        $add = null;
        foreach ($arr as $key => $s) {
            $attr = $this->ElementAllowAttr($key, $element);
           
            $add .= is_null($attr) ? null : " $attr=\"$s\"";
        }
        return ($type == 'closed' ? "</$element>" : "<$element$add>");
    }
    private function ElementAllowAttr($key, $element) {
        $g = false;
        if(isset($this->config['allowedAttr'][$key])) {
            $g = count($this->config['allowedAttr'][$key]) < 1 || in_array($element, $this->config['allowedAttr'][$key]);
        }
        return $g == true ? $key : null;
    }
    private function renderItems() {
        foreach ($this->items as $i) {
            $this->startAndEnd($i, true);
        };
    }
    private function insertIn($insert, $bef, $in, $aft){
        return $bef . $this->getElement($insert) . $in . ( $this->getElement(array('element' => $insert['element']), 'closed') ) . $aft ;
    }
    private function renderDropDown($item){
        $d = null;
        if(isset($item) && count($item) > 0) {
            foreach ($item as $v => $sb) {                            
                $d .= $this->insertIn($sb, null, $this->insertIn(['element' => 'a', 'href' => $sb['href']], null, $sb['html'], null), null);
            }
        }       
        return $d;
    }
    private function startAndEndEx($arr, $aft = false) {
        $html = array_key_exists('html', $arr) ? $arr['html'] : null;
        $space = ( $aft == false ? null : $this->replazable );
        $isItem = !is_null($html);
        if($isItem == true) {
            if(!empty($arr['extra']['in'])) {
                $html = $this->insertIn($this->configItem['in'], null, $html, null);
            }
            $html = $this->insertIn(['element' => 'a', 'href' => $arr['href']], null, $html, null);
            if(isset($arr['extra']['dropdown']['items']) && count($arr['extra']['dropdown']['items']) > 0) {
                $bif = null;

                if(isset($arr['extra']['dropdown']['config']['after']))
                {
                    $bif = $this->insertIn($arr['extra']['dropdown']['config']['after'], null, $this->renderDropDown($arr['extra']['dropdown']['items']), null);
                } else {
                    $bif = $this->renderDropDown($arr['extra']['dropdown']['items']);
                }
                $html .= $this->insertIn($arr['extra']['dropdown']['config']['start'], null, $bif, null);   
            }
        }
        $u = $this->insertIn($arr, null, ($html . ($aft == false ? $this->replazable : null)), $isItem == true && !empty($arr['extra']['out']) ? null : $space );
        if($isItem == true) {
            if(!empty($arr['extra']['out'])) {
                $u = $this->insertIn($arr['extra']['out'], null, $u, $space);
            }
        }
        return $u;
    }
    private function startAndEnd($arr, $aft = false) {
        $tmp = $this->startAndEndEx($arr, $aft); 
        $this->output = ($success = str_replace($this->replazable, $tmp, $this->output)) == false ? ($this->output . $tmp) : $success;
        
    }
}
?>