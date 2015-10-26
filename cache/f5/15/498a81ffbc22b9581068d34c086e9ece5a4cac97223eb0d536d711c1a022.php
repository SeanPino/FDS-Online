<?php

/* list.php */
class __TwigTemplate_f515498a81ffbc22b9581068d34c086e9ece5a4cac97223eb0d536d711c1a022 extends Twig_Template
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
\t\t<link rel=\"stylesheet\" href=\"static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>\" />
\t\t<link rel=\"stylesheet\" href=\"static/foundation/stylesheets/app.css?<?php print time(); ?>\" />
\t\t<script src=\"static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>\"></script>
\t</head>
\t<body>
\t\t<div class=\"row\">
\t\t\t<div id=\"main\" class=\"small-12 columns\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<img src=\"static/images/100px_PyroSim_Logo.png\"/>
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<h1>Online Simulator</h1>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"small-12 columns\">
\t\t\t\t\t\t<p>The current simulations in storage.</p>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<input type=\"button\" id=\"refresh\" value=\"Refresh List\" />
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
\t\t\t\t\t<div id=\"results\">
\t\t\t\t\tNow Loading Results.
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
\t\t</div>\t
\t\t<script src=\"static/foundation/bower_components/foundation/js/vendor/jquery.js\"></script>
\t\t<script src=\"static/foundation/bower_components/foundation/js/vendor/fastclick.js\"></script>
\t\t<script src=\"static/foundation/bower_components/foundation/js/foundation.min.js\"></script>

\t\t<script>
\t\t\t\$(document).foundation();
\t\t\t\$(document).ready(function(){
\t\t\t\tgetList();
\t\t\t});
\t\t\t\$(\"#refresh\").click(function(){
\t\t\t\tgetList();
\t\t\t});
\t\t\tfunction getList(){
\t\t\t\t\$.ajax({
\t\t\t\t\t//url: 'api/v1/jobs',
\t\t\t\t\turl: 'http://pyro.demo/api/v1/list/',
\t\t\t\t\ttype: 'GET',
\t\t\t\t\t//data: data,
\t\t\t\t\tcache: false,
\t\t\t\t\t//dataType: 'json',
\t\t\t\t\tprocessData: false,
\t\t\t\t\tcontentType: false,
\t\t\t\t\tsuccess: function (object) {
                                            if(!object){
                                                output = \"No jobs in storage.\";
                                            }else{
                                                result = jQuery.parseJSON(object);
                                                output = \"<table class='sim-list'><tr><th>ID</th><th>Name</th><th>Status</th><th>Percent Complete</th></tr>\";
                                                for(x=0; x<result.length; x++){
                                                    switch(parseInt(result[x][\"status_id\"])){
                                                        case 1:
                                                            status = \"In Queue\";
                                                            break;
                                                        case 2:
                                                            status = \"Processing\";
                                                            break;
                                                        case 3:
                                                            status = \"Completed\";
                                                            break;
                                                        default:
                                                            status = \"Error\";
                                                    }
                                                    percent = \"Not started\";
                                                    output += (\"<tr><td>\" + result[x][\"id\"] + \"</td><td>\" + result[x][\"name\"] + \"</td><td>\" + status + \"</td><td>\" + percent + \"</td></tr>\");
                                                }
                                                output += \"</table>\";
                                            }
                                            \$(\"#results\").html(output);
\t\t\t\t\t},
\t\t\t\t\terror: function (object, status, error) {
                                                console.log(\"The response text: \" + object.responseText);
\t\t\t\t\t\tconsole.log(\"There was an error: \" + error);
\t\t\t\t\t}
\t\t\t\t});
\t\t\t}
\t\t
\t\t</script>

\t\t<script src=\"static/js/core.js?<?php print time(); ?>\"></script>
\t</body>
</html>";
    }

    public function getTemplateName()
    {
        return "list.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
