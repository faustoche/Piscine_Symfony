<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* ex03/base.html.twig */
class __TwigTemplate_3a3db894484a703efdb89bf7566abe96 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "ex03/base.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <title>ex03</title>
        <style>
            html, body { height: 100%; margin: 0; padding: 0; }
            body { 
                display: flex; 
                flex-direction: column; 
                font-family: 'Segoe UI', Arial, sans-serif; 
                background-color: #f4f7f6;
            }

            header { 
                background: #eb255aff; 
                color: white; 
                padding: 2rem; 
                text-align: center; 
            }
            header h1 { margin: 0; text-transform: uppercase; letter-spacing: 2px; }

            main { 
                flex: 1; 
                display: flex; 
                flex-direction: column; 
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 20px;
            }

            footer { 
                background: #eb255aff; 
                color: white; 
                text-align: center; 
                padding: 1rem; 
                width: 100%;
            }

            .card {
                background: white;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                display: inline-block;
                min-width: 350px;
                text-align: center;
            }

            .alert { 
                padding: 15px; 
                margin-bottom: 20px; 
                border-radius: 4px; 
                border: 1px solid; 
                width: 100%; 
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            button { 
                background: #eb255aff; 
                color: white; 
                border: none; 
                padding: 12px 25px; 
                border-radius: 5px; 
                cursor: pointer; 
                font-size: 1rem;
                margin-top: 10px;
            }
            button:hover { background: #cb1a49ff; }
        </style>
    </head>
    <body>
        <header>
            <h1>EXERCICE 03</h1>
        </header>

        <main>
            ";
        // line 81
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 82
        yield "        </main>

        <footer>
            <p>Piscine Symfony - 42 - Faustine Crocq</p>
        </footer>
    </body>
</html>";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 81
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "ex03/base.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  144 => 81,  130 => 82,  128 => 81,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
    <head>
        <meta charset=\"UTF-8\">
        <title>ex03</title>
        <style>
            html, body { height: 100%; margin: 0; padding: 0; }
            body { 
                display: flex; 
                flex-direction: column; 
                font-family: 'Segoe UI', Arial, sans-serif; 
                background-color: #f4f7f6;
            }

            header { 
                background: #eb255aff; 
                color: white; 
                padding: 2rem; 
                text-align: center; 
            }
            header h1 { margin: 0; text-transform: uppercase; letter-spacing: 2px; }

            main { 
                flex: 1; 
                display: flex; 
                flex-direction: column; 
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 20px;
            }

            footer { 
                background: #eb255aff; 
                color: white; 
                text-align: center; 
                padding: 1rem; 
                width: 100%;
            }

            .card {
                background: white;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                display: inline-block;
                min-width: 350px;
                text-align: center;
            }

            .alert { 
                padding: 15px; 
                margin-bottom: 20px; 
                border-radius: 4px; 
                border: 1px solid; 
                width: 100%; 
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            button { 
                background: #eb255aff; 
                color: white; 
                border: none; 
                padding: 12px 25px; 
                border-radius: 5px; 
                cursor: pointer; 
                font-size: 1rem;
                margin-top: 10px;
            }
            button:hover { background: #cb1a49ff; }
        </style>
    </head>
    <body>
        <header>
            <h1>EXERCICE 03</h1>
        </header>

        <main>
            {% block content %}{% endblock %}
        </main>

        <footer>
            <p>Piscine Symfony - 42 - Faustine Crocq</p>
        </footer>
    </body>
</html>", "ex03/base.html.twig", "/home/faustoche/Documents/Piscine_Symfony/Symfony_11_Base/ex03/templates/ex03/base.html.twig");
    }
}
