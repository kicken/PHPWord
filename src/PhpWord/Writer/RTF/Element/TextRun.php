<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Writer\RTF\Element;

/**
 * TextRun element RTF writer
 *
 * @since 0.10.0
 */
class TextRun extends AbstractElement
{
    /**
     * Write element
     *
     * @return string
     */
    public function write()
    {
        $this->getStyles();

        $content = '';
        $content .= $this->writeOpening();
        $content .= '{';

        $elements = $this->element->getElements();
        foreach ($elements as $element) {
            $elementClass = get_class($element);
            $writerClass = str_replace('PhpOffice\\PhpWord\\Element', 'PhpOffice\\PhpWord\\Writer\\RTF\\Element', $elementClass);
            if (class_exists($writerClass)) {
                /** @var \PhpOffice\PhpWord\Writer\HTML\Element\AbstractElement $writer Type hint */
                $writer = new $writerClass($this->parentWriter, $element, true);
                $content .= $writer->write();
            }
        }

        $content .= '}';
        $content .= $this->writeClosing();

        return $content;
    }
}
