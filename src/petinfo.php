<?php
require(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php');

use Dotenv\Dotenv;

class PetInfo
{
    const SKILL_DIR = '../skilltrees';

    private array $publish_mob_list;
    private array $skilltrees;
    private array $skills_for_view;

    // For now publishing 30 mobs only...
    private array $translate_mobname = array(
        'Zombie' => 'ゾンビ',
        'ZombieVillager' => '村人ゾンビ',
        'Drowned' => 'ドラウンド',
        'ZombieHorse' => 'ゾンビホース',
        'ZombifiedPiglin' => 'ゾンビピグリン',
        'Skeleton' => 'スケルトン',
        'Stray' => 'ストレイ',
        'Creeper' => 'クリーパー',
        'Slime' => 'スライム',
        'Phantom' => 'ファントム',
        'Enderman' => 'エンダーマン',
        'Endermite' => 'エンダーマイト',
        'Blaze' => 'ブレイズ',
        'WitherSkeleton' => 'ウィザースケルトン',
        'Wither' => 'ウィザー',
        'Illusioner' => 'イリュージョナー',
        'Ravager' => 'ラヴェジャー',
        'Vex' => 'ヴェックス',
        'Chicken' => 'ニワトリ',
        'Cow' => 'ウシ',
        'Mooshroom' => 'ムーシュルーム',
        'Horse' => 'ウマ',
        'Bee' => 'ミツバチ',
        'Fox' => 'キツネ',
        'Panda' => 'パンダ',
        'Squid' => 'イカ',
        'Turtle' => 'カメ',
        'Wolf' => 'オオカミ',
        'Salmon' => 'サケ',
        'Snowman' => 'スノーゴーレム',
        'Villager' => '村人'
    );
    private array $translate_beacon_buff = array(
        'Absorption' => '衝撃吸収',
        'FireResistance' => '火炎耐性',
        'JumpBoost' => '跳躍力上昇',
        'NightVision' => '暗視',
        'Resistance' => '防御力上昇',
        'Speed' => '移動速度',
        'Strength' => '攻撃力上昇',
        'WaterBreathing' => '水中呼吸',
        'Invisibility' => '透明化',
        'Regeneration' => '再生能力'
    );

    public function __construct()
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
            $for_view['MobTypes'] = $skilltree['MobTypes'][0];
            $for_view['MobTypesJp'] = $skilltree['MobTypes'][0] === '*' ? '全て' : $this->translate_mobname[$skilltree['MobTypes'][0]];
            $for_view['Description'] = implode(' | ', $skilltree['Description']);
            $for_view['MaxLevel'] = $skilltree['MaxLevel'] ?? 'なし';

            $for_view['CanFly'] = 'なし';
            if (array_key_exists('Ride', $skilltree['Skills'])) {
                foreach ($skilltree['Skills']['Ride']['Upgrades'] as $level => $ability) {
                    // @TODO CanFly get more details
                    if ($ability['CanFly']) $for_view['CanFly'] = 'あり';
                }
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
                            $for_view['Beacon_details'][] = [$buff . '_' . $this->translate_beacon_buff[$buff] => [$effect_level => $required_level]];
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
?>