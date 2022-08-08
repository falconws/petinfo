<?php
include_once(__DIR__ . '/../vendor/autoload.php');
use Jenssegers\Blade\Blade;

class PetInfo
{
    const SKILL_DIR = '../skilltrees';

    function __construct()
    {
        $this->skilltrees = [];
        foreach (glob(self::SKILL_DIR . DIRECTORY_SEPARATOR . '*.st.json') as $json_file) {
            $json = json_decode(file_get_contents($json_file), associative: true);  // PHP >=8
            $this->skilltrees[] = $json;
        }
    }

    public function displayVar()
    {
        echo $this->var;
    }
}

function main()
{
    $petinfo = new PetInfo();
    // var_dump($petinfo->skilltrees);
    $blade = new Blade('templates', 'cache');
    echo $blade->render('petinfo_view', ['data_list' => $petinfo->skilltrees]);
}

main();

?>