<?php

/*
 * This file is part of the JsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonSchema\Constraints;

/**
 * The Number Constraints, validates an number against a given schema
 *
 * @author Robert Schönthal <seroscho@googlemail.com>
 * @author Bruno Prieto Reis <bruno.p.reis@gmail.com>
 */
class Number extends Constraint
{
    /**
     * {@inheritDoc}
     */
    public function check($element, $schema = null, $path = null, $i = null)
    {
        // Verify minimum
        if (isset($schema->exclusiveMinimum)) {
            if (isset($schema->minimum)) {
                if ($schema->exclusiveMinimum && $element === $schema->minimum) {
                    $this->addError($path, "must have a minimum value greater than boundary value of " . $schema->minimum);
                } else if ($element < $schema->minimum) {
                    $this->addError($path, "must have a minimum value of " . $schema->minimum);
                }
            } else {
                $this->addError($path, "use of exclusiveMinimum requires presence of minimum");
            }
        } else if (isset($schema->minimum) && $element < $schema->minimum) {
            $this->addError($path, "must have a minimum value of " . $schema->minimum);
        }

        // Verify maximum
        if (isset($schema->exclusiveMaximum)) {
            if (isset($schema->maximum)) {
                if ($schema->exclusiveMaximum && $element === $schema->maximum) {
                    $this->addError($path, "must have a maximum value less than boundary value of " . $schema->maximum);
                } else if ($element > $schema->maximum) {
                    $this->addError($path, "must have a maximum value of " . $schema->maximum);
                }
            } else {
                $this->addError($path, "use of exclusiveMaximum requires presence of maximum");
            }
        } else if (isset($schema->maximum) && $element > $schema->maximum) {
            $this->addError($path, "must have a maximum value of " . $schema->maximum);
        }

        // Verify divisibleBy
        if (isset($schema->divisibleBy) && fmod($element, $schema->divisibleBy) != 0) {
            $this->addError($path, "is not divisible by " . $schema->divisibleBy);
        }

        $this->checkFormat($element, $schema, $path, $i);
    }
}