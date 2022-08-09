<?php
require_once('petinfo.php');

use Jenssegers\Blade\Blade;

function main()
{
    $petinfo = new PetInfo();
    $blade = new Blade('templates', 'cache');
    echo $blade->render('petinfo_view', ['data_list' => $petinfo->get_skills_for_view()]);
}

main();
?>