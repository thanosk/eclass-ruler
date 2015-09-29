<?php

class CriterionSet {
    
    protected $criteria = array();
    
    public function __construct(array $criteria = array()) {
        foreach ($criteria as $criterion) {
            $this->addCriterion($criterion);
        }
    }
    
    public function addCriterion(Criterion $criterion) {
        $this->criteria[spl_object_hash($criterion)] = $criterion;
    }
    
    public function evaluateCriteria(Hoa\Ruler\Context $context) {
        foreach ($this->criteria as $criterion) {
            $criterion->evaluate($context);
        }
    }
}
