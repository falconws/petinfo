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

    private function make_skills_for_view(): void
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
                    if (array_key_exists('CanFly', $ability) && $ability['CanFly']) $for_view['CanFly'] = 'あり';
                }
            }

            if (array_key_exists('Backpack', $skilltree['Skills'])) {
                // @TODO Backpack get more details
                $for_view['Backpack'] = 'あり';
            } else {
                $for_view['Backpack'] = 'なし';
            }
            
            if (array_key_exists('Beacon', $skilltree['Skills'])) {
                $for_view['Beacon'] = 'あり';
                $beacontree['Beacon_details'] = @$this->make_beacon_details($skilltree['Skills']['Beacon']['Upgrades']);
            } else {
                $for_view['Beacon'] = 'なし';
            }

            $this->skills_for_view[] = array_merge($for_view, $beacontree);
        }
    }

    private function make_beacon_details(array $beacontree): array
    {
        $all_level_list = [];
        foreach ($beacontree as $required_level => $ability) {
            // Remove false buffs
            if (array_key_exists('Buffs', $ability)) $ability['Buffs'] = array_diff($ability['Buffs'], [false]);
            foreach (explode(',', $required_level) as $level) {
                if (!array_key_exists($level, $all_level_list)) {
                    $all_level_list[$level]['Count'] = array_key_exists('Count', $ability) ? intval($ability['Count']) : 0;
                    $all_level_list[$level]['Duration'] = array_key_exists('Duration', $ability) ? intval($ability['Duration']) : 0;
                    foreach ($ability['Buffs'] as $buff_name => $buff_value) {
                        $all_level_list[$level]['Buffs'][$buff_name] = is_bool($buff_value) ? $buff_value : intval($buff_value);
                    }
                    continue;
                }
                // Same level
                $all_level_list[$level]['Count'] += array_key_exists('Count', $ability) ? intval($ability['Count']) : 0;
                $all_level_list[$level]['Duration'] += array_key_exists('Duration', $ability) ? intval($ability['Duration']) : 0;

                foreach ($ability['Buffs'] as $buff_name => $buff_value) {
                    if (is_bool($buff_value)) {
                        $all_level_list[$level]['Buffs'][$buff_name] = $buff_value;  // always $buff_value is true
                    } else {
                        // Warning: Undefined array key. But this is intended.
                        $all_level_list[$level]['Buffs'][$buff_name] += intval($buff_value);
                    }
                }
            }
        }

        ksort($all_level_list);
        foreach ($all_level_list as $level => $ability) {
            if (!isset($prev_ability)) {
                $prev_ability = $ability;  // initial loop
                continue;
            }
            $all_level_list[$level]['Count'] += $prev_ability['Count'];
            $all_level_list[$level]['Duration'] += $prev_ability['Duration'];

            if (array_key_exists('Buffs', $prev_ability)) {
                foreach ($prev_ability['Buffs'] as $buff_name => $buff_value) {
                    if (is_bool($buff_value)) {
                        $all_level_list[$level]['Buffs'][$buff_name] = $buff_value;  // always $buff_value is true
                    } else {
                        // Warning: Undefined array key. But this is intended.
                        $all_level_list[$level]['Buffs'][$buff_name] += intval($buff_value);
                    }
                }
            }

            $prev_ability = $all_level_list[$level];
        }

        // sort beacon buff name in alphabetical order
        foreach ($all_level_list as $key => $value) {
            if (array_key_exists('Buffs', $all_level_list[$key])) ksort($all_level_list[$key]['Buffs']);
        }

        return $all_level_list;
    }

    private function load_env(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..');
        $dotenv->load();
        $this->publish_mob_list = array_map('trim', explode(',', $_ENV['PUBLISH_MOB_LIST']));
    }

    public function get_skilltrees(): array
    {
        return $this->skilltrees;
    }

    public function get_skills_for_view(): array
    {
        return $this->skills_for_view;
    }

    public function get_translate_beacon_buff(): array
    {
        return $this->translate_beacon_buff;
    }
}
?>