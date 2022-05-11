<?php

namespace Vchat\Settings;

require_once "./src/Utils/GetBasePath.php";

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Twig\Extra\CssInliner\CssInlinerExtension;

class View
{
    private FilesystemLoader $loader;
    private Environment $twig;
    private string $path;
    private array $directories = [];

    public function __construct()
    {
        $this->path = getBasePath("Views/");

        array_push($this->directories, [
            "views" => $this->path,
            "cache" => $this->path . "cache/",
            "shared" => $this->path . "shared/",
            "components" => $this->path . "components/"
        ]);

        $this->initTemplateEngineBase();
    }

    private function initTemplateEngineBase()
    {
        $this->loader = new FilesystemLoader($this->directories[0]["views"]);
        $this->loader->addPath($this->directories[0]["shared"], "shared");
        $this->loader->addPath($this->directories[0]["components"], "components");

        $this->twig = new Environment($this->loader, [
            "debug" => true,
            "auto_reload" => true,
            "charset" => "utf-8",
        ]);

        $this->twig->addExtension(new DebugExtension);
        $this->twig->addExtension(new CssInlinerExtension);
        $this->twig->addFunction(new TwigFunction("route", function ($url) {
            return $_ENV["BASE_URL"] . $url;
        }));
    }

    public function render($renderPage, $data = [])
    {
        echo $this->twig->render($renderPage, $data);
    }

    public function display($page)
    {
        $this->twig->display($page);
    }
}
