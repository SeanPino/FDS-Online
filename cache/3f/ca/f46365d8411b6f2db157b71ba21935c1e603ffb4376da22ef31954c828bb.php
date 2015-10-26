<?php

/* documentation.php */
class __TwigTemplate_3fcaf46365d8411b6f2db157b71ba21935c1e603ffb4376da22ef31954c828bb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
\t<head>
\t\t<title>PyroSim</title>
\t\t<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
\t\t<link rel=\"stylesheet\" href=\"/static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>\" />
\t\t<link rel=\"stylesheet\" href=\"/static/foundation/stylesheets/app.css?<?php print time(); ?>\" />
\t\t<script src=\"/static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>\"></script>
\t</head>
\t<body>
\t\t<div class=\"row\">
\t\t\t<div id=\"main\" class=\"small-12 columns\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<img src=\"/static/images/100px_PyroSim_Logo.png\"/>
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<h1>API Documentation</h1>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<p>Select a file to upload.  The server will run a simulation and you will be updated with its status.</p>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-8 small-offset-2 columns\">
\t\t\t\t\t\t<div id=\"success_alert\" style=\"display: none\" data-alert class=\"alert-box primary\">
\t\t\t\t\t\t\t<label id=\"success_message\"></label>
\t\t\t\t\t\t\t<a href=\"#\" class=\"close\">&times;</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<form>
\t\t\t\t\t\t\t<fieldset>
\t\t\t\t\t\t\t\t<legend>FDS Upload</legend>
\t\t\t\t\t\t\t\t<input id=\"file\" type=\"file\" accept=\".fds\" name=\"file\" />
\t\t\t\t\t\t\t\t<button id=\"upload_file\" type=\"submit\" class=\"tiny pyro-color\">Upload</button>
\t\t\t\t\t\t\t</fieldset>
\t\t\t\t\t\t</form>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"row\">
\t\t\t<div id=\"footer\" class=\"small-12 columns\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<p>Built with love by Alex Neises, Sean Pino, &amp; Shawn Contant.</p>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<p>Version <?php print \$data['version']; ?></p>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<?php \$status = \$data['sprint']; ?>
\t\t\t\t\t\t<p>Day <?php print \$status['day']; ?> of Sprint <?php print \$status['sprint']; ?></p>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>

\t\t<script src=\"/static/foundation/bower_components/foundation/js/vendor/jquery.js\"></script>
\t\t<script src=\"/static/foundation/bower_components/foundation/js/vendor/fastclick.js\"></script>

\t\t<script src=\"/static/foundation/bower_components/foundation/js/foundation.min.js\"></script>

\t\t<script>
\t\t\t\$(document).foundation();
\t\t</script>

\t\t<script src=\"/static/js/api.js?<?php print time(); ?>\"></script>
\t</body>
</html>";
    }

    public function getTemplateName()
    {
        return "documentation.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
