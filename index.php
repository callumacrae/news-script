<?php

/**
 * callumacrae/news-script
 *
 * @author Callum Macrae <callum@macr.ae>
 * @license http://sam.zoy.org/wtfpl/ Do What The Fuck You Want To Public License
 */

$root_path = __DIR__;
include('includes/common.php');

$conn = DB::get();

$template->set_title('Index Page');
$template->parse('index_body');
