<?php

/**
 * A set of rule-engine criteria.
 */
class CriterionSet {
    
    protected $criteria = array();
    
    /**
     * CriterionSet constructor.
     * 
     * @param array $criteria Criterion objects to add to CriterionSet
     */
    public function __construct(array $criteria = array()) {
        foreach ($criteria as $criterion) {
            $this->addCriterion($criterion);
        }
    }
    
    /**
     * Add a Criterion to the CriterionSet.
     * 
     * @param Criterion $criterion Criterion to add to the set
     */
    public function addCriterion(Criterion $criterion) {
        $this->criteria[spl_object_hash($criterion)] = $criterion;
    }
    
    /**
     * Evaluate all Criteria in the CriterionSet.
     * 
     * @param Hoa\Ruler\Context $context Context with which to evaluate each rule
     */
    public function evaluateCriteria(Hoa\Ruler\Context $context) {
        foreach ($this->criteria as $criterion) {
            $criterion->evaluate($context);
        }
    }
}
