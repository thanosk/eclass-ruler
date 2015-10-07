<?php

require_once 'GameAbstract.php';

class Game extends GameAbstract {
    
    public function __construct() {
        $this->ruler = new Hoa\Ruler\Ruler();
    }
    
    protected function buildRule() {
        $satisfiesAllCriteria = function($userCriterionIds) {
            $ret = true;
            
            foreach($this->criterionIds as $crit) {
                if (!in_array($crit, $userCriterionIds)) {
                    $ret = false;
                    break;
                }
            }
            
            return $ret;
        };
        
        $asserter = new Hoa\Ruler\Visitor\Asserter();
        $asserter->setOperator('satisfiesallcriteria', $satisfiesAllCriteria);
        $this->ruler->setAsserter($asserter);
        
        $this->rule = 'satisfiesallcriteria(userCriterionIds)';
    }
    
    public function evaluate($context) {
        if (!$this->autoassign) {
            return false;
        }
            
        if ($this->ruler->assert($this->rule, $context)) {
            $this->assertedAction($context);
            return true;
        } else {
            $this->notAssertedAction($context);
            return false;
        }
    }
}
