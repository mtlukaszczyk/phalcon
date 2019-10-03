<?php

namespace App\Classes\Engines;

use Phalcon\Mvc\View\Engine\Volt as VoltMain;

class Volt extends VoltMain {

    const DEFAULT_EXTENSION = '.html.volt';

    /**
     * @param mixed|\Phalcon\Mvc\ViewBaseInterface $view
     * @param mixed|\Phalcon\DiInterface $dependencyInjector
     * @param array $options
     */
    public function __construct($view, $dependencyInjector) {
        parent::__construct($view, $dependencyInjector);

        $this->setOptions(
                [
                    'compiledPath' => '../app/compiled-templates/',
                    'compiledExtension' => '.compiled',
                ]
        );
    }

    public function prepareFunctions($di) {

        $functions = [
            'outputCss' => function () use ($di) {
                $result = $di->get('assets')->outputCss();
                return $result;
            },
            'outputJs' => function () use ($di) {
                $result = $di->get('assets')->outputJs();
                return $result;
            },
            'simpleInput' => function($id, $value, $label = '', $dataGrab = true, $classes = []) {
                $o = '<p class="form-group has-feedback">
        <label>' . $label . '</label>
        <input type="text" class="form-control ' . ($dataGrab ? 'data-grab ' : '') . implode(', ', $classes) . '" id="' . $id . '" value="' . $value . '" old_value="' . $value . '"/>
     </p>';

                return $o;
            },
            'simpleText' => function($id, $value, $label = '', $dataGrab = true, $classes = []) {
                $o = '<div class="form-group">
        <label>' . $label . '</label>
        <textarea class="form-control ' . ($dataGrab ? 'data-grab ' : '') . implode(', ', $classes) . '" id="' . $id . '">' . $value . '</textarea>
     </div>';

                return $o;
            }
        ];

        foreach ($functions as $functionName => $function) {
            $this->getCompiler()->addFunction($functionName, $function);
        }
    }

}
