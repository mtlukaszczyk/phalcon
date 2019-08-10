<?php

namespace App\Classes;

use Phalcon\Mvc\View\Engine;
use Phalcon\Mvc\View\EngineInterface;

/**
 * Class Twig
 * @package Phalcon\Mvc\View\Engine
 */
class Twig extends Engine implements EngineInterface {

    const DEFAULT_EXTENSION = '.html.twig';

    /**
     * @var \Twig_Environment
     */
    public $twig;

    /**
     * @param mixed|\Phalcon\Mvc\ViewBaseInterface $view
     * @param mixed|\Phalcon\DiInterface $dependencyInjector
     * @param array $options
     */
    public function __construct($view, $dependencyInjector, array $options = []) {
        parent::__construct($view, $dependencyInjector);

        $loader = new \Twig_Loader_Filesystem($this->getView()->getViewsDir());
        $this->twig = new \Twig_Environment($loader, $options);
    }

    /**
     * @param string $path
     * @param mixed $params
     * @param bool $mustClean
     */
    public function render($path, $params, $mustClean = false) {
        if (!$params) {
            $params = [];
        }

        $content = $this->twig->render(str_replace($this->getView()->getViewsDir(), '', $path), $params);
        if ($mustClean) {
            $this->getView()->setContent($content);

            return;
        }

        echo $content;
    }

    public function prepareFunctions($di) {

        $functions = [
            new \Twig\TwigFunction('outputCss', function () use ($di) {
                        $result = $di->get('assets')->outputCss();
                        return $result;
                    }),
            new \Twig\TwigFunction('outputJs', function () use ($di) {
                        $result = $di->get('assets')->outputJs();
                        return $result;
                    }),
            new \Twig\TwigFunction('simpleInput', function($id, $value, $label = '', $dataGrab = true, $classes = []) {
                        $o = '<p class="form-group has-feedback">
        <label>' . $label . '</label>
        <input type="text" class="form-control ' . ($dataGrab ? 'data-grab ' : '') . implode(', ', $classes) . '" id="' . $id . '" value="' . $value . '" old_value="' . $value . '"/>
     </p>';

                        return $o;
                    }),
            new \Twig\TwigFunction('simpleText', function($id, $value, $label = '', $dataGrab = true, $classes = []) {
                        $o = '<div class="form-group">
        <label>' . $label . '</label>
        <textarea class="form-control ' . ($dataGrab ? 'data-grab ' : '') . implode(', ', $classes) . '" id="' . $id . '">' . $value . '</textarea>
     </div>';

                        return $o;
                    })
        ];

        foreach ($functions as $function) {
            $this->twig->addFunction($function);
        }
    }

}
