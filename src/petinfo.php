<?php
require(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php');

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;

class PetInfo
{
    const SKILL_DIR = '../skilltrees';

    private array $publish_mob_list;
    private array $skilltrees;
    private array $skills_for_view;

    function __construct()
    {
        $this->load_env();
        $this->skilltrees = [];
        foreach (glob(self::SKILL_DIR . DIRECTORY_SEPARATOR . '*.st.json') as $json_file) {
            $json = json_decode(file_get_contents($json_file), true);
            if (in_array(strtolower($json['MobTypes'][0]), array_map('strtolower', $this->publish_mob_list))) {
                $this->skilltrees[] = $json;
            }
        }
        $this->make_skills_for_view();
    }

    private function make_skills_for_view()
    {
        foreach ($this->skilltrees as $skilltree) {
            $for_view['Name'] = $skilltree['Name'];

            // @TODO Translate English to Japanese
            $for_view['MobTypes'] = $skilltree['MobTypes'][0] === '*' ? '全て' : $skilltree['MobTypes'][0];

            $for_view['RequiredLevel'] = $skilltree['RequiredLevel'] ?? 'なし';
            $for_view['MaxLevel'] = $skilltree['MaxLevel'] ?? 'なし';

            if (array_key_exists('Ride', $skilltree['Skills'])) {
                foreach ($skilltree['Skills']['Ride']['Upgrades'] as $level => $ability) {
                    // @TODO CanFly get more details
                    $for_view['CanFly'] = 'あり';
                }
            } else {
                $for_view['CanFly'] = 'なし';
            }

            if (array_key_exists('Backpack', $skilltree['Skills'])) {
                // @TODO Backpack get more details
                $for_view['Backpack'] = 'あり';
            } else {
                $for_view['Backpack'] = 'なし';
            }

            // Beacon
            if (array_key_exists('Beacon', $skilltree['Skills'])) {
                $for_view['Beacon'] = 'あり';
                $for_view['Beacon_details'] = [];
                foreach ($skilltree['Skills']['Beacon']['Upgrades'] as $required_level => $ability) {
                    foreach ($ability['Buffs'] as $buff => $effect_level) {
                        $effect_level = $effect_level === true ? '-' : $effect_level;
                        if ($effect_level) {
                            // @TODO Translate English to Japanese ($buff)
                            $for_view['Beacon_details'][] = [$buff => [$effect_level => $required_level]];
                        }
                    }
                }
            } else {
                $for_view['Beacon'] = 'なし';
                $for_view['Beacon_details'] = [];
            }

            $this->skills_for_view[] = $for_view;
        }
    }

    private function load_env()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..');
        $dotenv->load();
        $this->publish_mob_list = array_map('trim', explode(',', $_ENV['PUBLISH_MOB_LIST']));
    }

    public function get_skilltrees()
    {
        return $this->skilltrees;
    }

    public function get_skills_for_view()
    {
        return $this->skills_for_view;
    }
}

function main()
{
    $petinfo = new PetInfo();
    $blade = new Blade('templates', 'cache');
    echo $blade->render('petinfo_view', ['data_list' => $petinfo->get_skills_for_view()]);
}

main();

?>