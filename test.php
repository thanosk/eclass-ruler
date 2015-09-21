<?php
require_once 'vendor/autoload.php';
require_once 'Criterion.php';
require_once 'CriterionSimple.php';

echo "HOA Example start ========= \n";
// Create contexts
$context1 = new Hoa\Ruler\Context();
// η πληροφορία του act_type, module, resource μπορεί να προέρχεται κατευθείαν
// από ένα user-generated event (π.χ. submit τελευταίου βήματος άσκησης)
$context1['activity_type']  = 'exercise';
$context1['module']  = 10;
$context1['resource'] = 1;
// η πληροφορία του threshold μπορεί να προέρχεται από ένα ContextCreator Object
// ειδικό για ασκήσεις που θα το καλεί το PHP backend βασιζόμενο και πάλι στην 
// πληροφορία που κουβαλάει το Event
$context1['threshold'] = new Hoa\Ruler\DynamicCallable(function () {
    // select user's exercise grade from DB
    return 8.6;
});

$context2 = new Hoa\Ruler\Context();
$context2['activity_type']  = 'forum';
$context2['module']  = 9;
$context2['threshold'] = new Hoa\Ruler\DynamicCallable(function () {
    // count user's forum posts from DB
    return 20.0;
});

// τα Properties του Criterion θα διαβάζονται από τη ΒΔ
$crit = Criterion::initWithProperties(1, 'certificate', 'exercise', 10, 1, 8.6, 'get');
$crit->evaluate($context1);
$crit->evaluate($context2);
echo "HOA Example end ========= \n\n\n";


echo "Simple Example start ========= \n";
$context3 = new Ruler\Context(array(
    'activity_type' => 'exercise',
    'module' => 10,
    'resource' => 1,
    'threshold' => function() {
        return 8.6;
    }
));

$context4 = new Ruler\Context(array(
    'activity_type' => 'forum',
    'module' => 9,
    'threshold' => function() {
        return 20.0;
    }
));

$crit2 = CriterionSimple::initWithProperties(1, 'certificate', 'exercise', 10, 1, 8.6, 'get');
$crit2->evaluate($context3);
$crit2->evaluate($context4);
echo "Simple Example end ========= \n\n\n";